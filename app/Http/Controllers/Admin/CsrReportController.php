<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CsrReportRequest;
use App\Models\CsrReport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CsrReportController extends Controller
{
    public function index(): View
    {
        $published = request('published');
        $featured = request('featured');
        $search = trim((string) request('search'));

        $reports = CsrReport::query()
            ->when($published !== null && $published !== '', fn ($query) => $query->where('is_published', (bool) $published))
            ->when($featured !== null && $featured !== '', fn ($query) => $query->where('is_featured', (bool) $featured))
            ->when($search !== '', fn ($query) => $query->where(function ($innerQuery) use ($search): void {
                $innerQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('report_period', 'like', "%{$search}%");
            }))
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.csr-reports.index', [
            'pageTitle' => 'CSR Reports',
            'breadcrumb' => 'CSR Reports',
            'reports' => $reports,
            'filters' => compact('published', 'featured', 'search'),
        ]);
    }

    public function create(): View
    {
        return view('admin.csr-reports.create', [
            'pageTitle' => 'Create CSR Report',
            'breadcrumb' => 'CSR Reports / Create',
            'report' => new CsrReport(['is_featured' => false, 'is_published' => false, 'sort_order' => 0]),
        ]);
    }

    public function store(CsrReportRequest $request): RedirectResponse
    {
        $data = $this->payload($request);

        if ($request->hasFile('report_file')) {
            $data['report_file'] = $this->storeUpload($request->file('report_file'), 'uploads/csr-reports', 'report');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->storeUpload($request->file('cover_image'), 'uploads/csr-reports/covers', 'cover');
        }

        CsrReport::query()->create($data);

        return redirect()->route('admin.csr-reports.index')->with('status', 'CSR report created.');
    }

    public function edit(CsrReport $csrReport): View
    {
        return view('admin.csr-reports.edit', [
            'pageTitle' => 'Edit CSR Report',
            'breadcrumb' => 'CSR Reports / Edit',
            'report' => $csrReport,
        ]);
    }

    public function update(CsrReportRequest $request, CsrReport $csrReport): RedirectResponse
    {
        $data = $this->payload($request, $csrReport);

        if ($request->hasFile('report_file')) {
            $this->deleteUpload($csrReport->report_file, 'uploads/csr-reports/');
            $data['report_file'] = $this->storeUpload($request->file('report_file'), 'uploads/csr-reports', 'report');
        }

        if ($request->hasFile('cover_image')) {
            $this->deleteUpload($csrReport->cover_image, 'uploads/csr-reports/covers/');
            $data['cover_image'] = $this->storeUpload($request->file('cover_image'), 'uploads/csr-reports/covers', 'cover');
        }

        $csrReport->update($data);

        return redirect()->route('admin.csr-reports.index')->with('status', 'CSR report updated.');
    }

    public function destroy(CsrReport $csrReport): RedirectResponse
    {
        $this->deleteUpload($csrReport->report_file, 'uploads/csr-reports/');
        $this->deleteUpload($csrReport->cover_image, 'uploads/csr-reports/covers/');
        $csrReport->delete();

        return redirect()->route('admin.csr-reports.index')->with('status', 'CSR report deleted.');
    }

    public function toggleFeatured(CsrReport $csrReport): RedirectResponse
    {
        $csrReport->update(['is_featured' => ! $csrReport->is_featured]);
        return back()->with('status', 'Featured status updated.');
    }

    public function togglePublished(CsrReport $csrReport): RedirectResponse
    {
        $isPublished = ! $csrReport->is_published;
        $csrReport->update([
            'is_published' => $isPublished,
            'published_at' => $isPublished ? now() : null,
        ]);

        return back()->with('status', 'Published status updated.');
    }

    private function payload(CsrReportRequest $request, ?CsrReport $report = null): array
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title'], $report);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? ($report?->published_at ?? now()) : null;

        return $data;
    }

    private function uniqueSlug(string $value, ?CsrReport $report = null): string
    {
        $slug = Str::slug($value);
        $base = $slug;
        $counter = 2;

        while (CsrReport::query()->where('slug', $slug)->when($report, fn ($query) => $query->whereKeyNot($report->id))->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function storeUpload($file, string $directoryRelative, string $prefix): string
    {
        $directory = public_path($directoryRelative);
        File::ensureDirectoryExists($directory);
        $filename = $prefix.'-'.Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return $directoryRelative.'/'.$filename;
    }

    private function deleteUpload(?string $path, string $allowedPrefix): void
    {
        if ($path && str_starts_with($path, $allowedPrefix)) {
            File::delete(public_path($path));
        }
    }
}
