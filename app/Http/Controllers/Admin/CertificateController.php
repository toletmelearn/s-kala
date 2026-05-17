<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CertificateRequest;
use App\Models\Certificate;
use App\Models\Trainee;
use App\Models\TrainingProgram;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class CertificateController extends Controller
{
    public function index(): View
    {
        $status = request('status');
        $program = request('program');
        $search = trim((string) request('search'));

        $certificates = Certificate::query()
            ->with(['trainee', 'trainingProgram'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($program, fn ($query) => $query->where('training_program_id', $program))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search): void {
                    $innerQuery
                        ->where('certificate_no', 'like', "%{$search}%")
                        ->orWhereHas('trainee', fn ($traineeQuery) => $traineeQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('registration_no', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.certificates.index', [
            'pageTitle' => 'Certificates',
            'breadcrumb' => 'Certificates',
            'certificates' => $certificates,
            'programs' => TrainingProgram::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'statuses' => ['draft', 'issued', 'revoked'],
            'filters' => compact('status', 'program', 'search'),
        ]);
    }

    public function create(): View
    {
        $traineeId = request('trainee');
        $trainee = $traineeId ? Trainee::query()->find($traineeId) : null;

        return view('admin.certificates.create', [
            'pageTitle' => 'Create Certificate',
            'breadcrumb' => 'Certificates / Create',
            'certificate' => new Certificate([
                'issue_date' => now()->toDateString(),
                'status' => 'draft',
                'training_program_id' => $trainee?->preferred_program_id,
                'title' => 'Certificate of Completion',
            ]),
            'trainees' => Trainee::query()->orderByRaw("CASE WHEN status = 'completed' THEN 0 ELSE 1 END")->orderBy('name')->get(),
            'programs' => TrainingProgram::query()->where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function store(CertificateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = $data['status'] ?? 'draft';

        $certificate = Certificate::query()->create($data);

        if ($certificate->status === 'issued') {
            $this->persistPdfPath($certificate);
        }

        return redirect()->route('admin.certificates.show', $certificate)->with('status', 'Certificate created.');
    }

    public function show(Certificate $certificate): View
    {
        return view('admin.certificates.show', [
            'pageTitle' => 'Certificate Details',
            'breadcrumb' => 'Certificates / Details',
            'certificate' => $certificate->load(['trainee', 'trainingProgram']),
            'verificationUrl' => route('certificates.verify', $certificate->verification_code),
        ]);
    }

    public function edit(Certificate $certificate): View
    {
        return view('admin.certificates.edit', [
            'pageTitle' => 'Edit Certificate',
            'breadcrumb' => 'Certificates / Edit',
            'certificate' => $certificate,
            'trainees' => Trainee::query()->orderByRaw("CASE WHEN status = 'completed' THEN 0 ELSE 1 END")->orderBy('name')->get(),
            'programs' => TrainingProgram::query()->where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function update(CertificateRequest $request, Certificate $certificate): RedirectResponse
    {
        $certificate->update($request->validated());

        if ($certificate->status === 'issued') {
            $this->persistPdfPath($certificate);
        }

        return redirect()->route('admin.certificates.show', $certificate)->with('status', 'Certificate updated.');
    }

    public function destroy(Certificate $certificate): RedirectResponse
    {
        if ($certificate->status !== 'draft') {
            return back()->with('status', 'Only draft certificates can be deleted.');
        }

        $certificate->delete();

        return redirect()->route('admin.certificates.index')->with('status', 'Certificate deleted.');
    }

    public function issue(Certificate $certificate): RedirectResponse
    {
        $certificate->update(['status' => 'issued']);
        $this->persistPdfPath($certificate);

        return back()->with('status', 'Certificate issued.');
    }

    public function revoke(Certificate $certificate): RedirectResponse
    {
        $certificate->update(['status' => 'revoked']);

        return back()->with('status', 'Certificate revoked.');
    }

    public function download(Certificate $certificate): Response|RedirectResponse
    {
        if (! class_exists(Pdf::class)) {
            return back()->with('status', 'PDF package not installed. Run: composer require barryvdh/laravel-dompdf');
        }

        $pdf = Pdf::loadView('admin.certificates.pdf', [
            'certificate' => $certificate->load(['trainee', 'trainingProgram']),
            'verificationUrl' => route('certificates.verify', $certificate->verification_code),
        ])->setPaper('a4', 'landscape');

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$certificate->certificate_no.'.pdf"',
        ]);
    }

    private function persistPdfPath(Certificate $certificate): void
    {
        if (! class_exists(Pdf::class)) {
            return;
        }

        $directory = public_path('uploads/certificates');
        File::ensureDirectoryExists($directory);

        $filename = $certificate->certificate_no.'.pdf';
        $relativePath = 'uploads/certificates/'.$filename;

        $pdf = Pdf::loadView('admin.certificates.pdf', [
            'certificate' => $certificate->load(['trainee', 'trainingProgram']),
            'verificationUrl' => route('certificates.verify', $certificate->verification_code),
        ])->setPaper('a4', 'landscape');

        File::put(public_path($relativePath), $pdf->output());

        $certificate->forceFill(['pdf_path' => $relativePath])->save();
    }
}
