<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTraineeRequest;
use App\Http\Requests\Admin\UpdateTraineeRequest;
use App\Models\Trainee;
use App\Models\TrainingProgram;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TraineeController extends Controller
{
    /**
     * Display trainee records with filters.
     */
    public function index(): View
    {
        $status = request('status');
        $programId = request('program');
        $search = trim((string) request('search'));

        $trainees = Trainee::query()
            ->with('preferredProgram')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($programId, fn ($query) => $query->where('preferred_program_id', $programId))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('registration_no', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.trainees.index', [
            'pageTitle' => 'Trainees',
            'breadcrumb' => 'Trainees',
            'trainees' => $trainees,
            'programs' => TrainingProgram::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'statuses' => ['pending', 'contacted', 'enrolled', 'completed', 'rejected'],
            'statusFilter' => $status,
            'programFilter' => $programId,
            'searchFilter' => $search,
        ]);
    }

    /**
     * Show the create form.
     */
    public function create(): View
    {
        return view('admin.trainees.create', [
            'pageTitle' => 'Create Trainee',
            'breadcrumb' => 'Trainees / Create',
            'trainee' => new Trainee(['status' => 'pending']),
            'programs' => TrainingProgram::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'statuses' => ['pending', 'contacted', 'enrolled', 'completed', 'rejected'],
        ]);
    }

    /**
     * Store a trainee record.
     */
    public function store(StoreTraineeRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->storeUpload($request->file('photo'), 'photos', 'photo');
        }

        if ($request->hasFile('id_proof')) {
            $data['id_proof'] = $this->storeUpload($request->file('id_proof'), 'id-proofs', 'id-proof');
        }

        $trainee = Trainee::query()->create($data);

        return redirect()
            ->route('admin.trainees.show', $trainee)
            ->with('status', 'Trainee created.');
    }

    /**
     * Display a trainee.
     */
    public function show(Trainee $trainee): View
    {
        return view('admin.trainees.show', [
            'pageTitle' => 'Trainee Details',
            'breadcrumb' => 'Trainees / Details',
            'trainee' => $trainee->load('preferredProgram'),
        ]);
    }

    /**
     * Show the edit form.
     */
    public function edit(Trainee $trainee): View
    {
        return view('admin.trainees.edit', [
            'pageTitle' => 'Edit Trainee',
            'breadcrumb' => 'Trainees / Edit',
            'trainee' => $trainee,
            'programs' => TrainingProgram::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'statuses' => ['pending', 'contacted', 'enrolled', 'completed', 'rejected'],
        ]);
    }

    /**
     * Update a trainee.
     */
    public function update(UpdateTraineeRequest $request, Trainee $trainee): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $this->deleteUpload($trainee->photo, 'uploads/trainees/photos/');
            $data['photo'] = $this->storeUpload($request->file('photo'), 'photos', 'photo');
        }

        if ($request->hasFile('id_proof')) {
            $this->deleteUpload($trainee->id_proof, 'uploads/trainees/id-proofs/');
            $data['id_proof'] = $this->storeUpload($request->file('id_proof'), 'id-proofs', 'id-proof');
        }

        $trainee->update($data);

        return redirect()
            ->route('admin.trainees.show', $trainee)
            ->with('status', 'Trainee updated.');
    }

    /**
     * Delete a trainee.
     */
    public function destroy(Trainee $trainee): RedirectResponse
    {
        $this->deleteUpload($trainee->photo, 'uploads/trainees/photos/');
        $this->deleteUpload($trainee->id_proof, 'uploads/trainees/id-proofs/');
        $trainee->delete();

        return redirect()
            ->route('admin.trainees.index')
            ->with('status', 'Trainee deleted.');
    }

    private function storeUpload($file, string $folder, string $prefix): string
    {
        $directory = public_path("uploads/trainees/{$folder}");
        File::ensureDirectoryExists($directory);

        $filename = $prefix.'-'.Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return "uploads/trainees/{$folder}/{$filename}";
    }

    private function deleteUpload(?string $path, string $allowedPrefix): void
    {
        if ($path && str_starts_with($path, $allowedPrefix)) {
            File::delete(public_path($path));
        }
    }
}
