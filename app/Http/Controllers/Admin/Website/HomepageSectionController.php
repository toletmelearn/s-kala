<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Website\HomepageSectionRequest;
use App\Models\HomepageSection;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class HomepageSectionController extends Controller
{
    /**
     * Display homepage sections.
     */
    public function index(): View
    {
        return view('admin.website.sections.index', [
            'pageTitle' => 'Homepage Sections',
            'breadcrumb' => 'Website CMS / Sections',
            'sections' => HomepageSection::query()->orderBy('sort_order')->get(),
        ]);
    }

    /**
     * Show the section creation form.
     */
    public function create(): View
    {
        return view('admin.website.sections.create', [
            'pageTitle' => 'Create Homepage Section',
            'breadcrumb' => 'Website CMS / Sections / Create',
            'section' => new HomepageSection(['is_active' => true, 'sort_order' => 0]),
        ]);
    }

    /**
     * Store a new homepage section.
     */
    public function store(HomepageSectionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeUpload($request->file('image'));
        }

        HomepageSection::query()->create($data);

        return redirect()
            ->route('admin.website.sections.index')
            ->with('status', 'Homepage section created.');
    }

    /**
     * Show the section edit form.
     */
    public function edit(HomepageSection $homepageSection): View
    {
        return view('admin.website.sections.edit', [
            'pageTitle' => 'Edit Homepage Section',
            'breadcrumb' => 'Website CMS / Sections / Edit',
            'section' => $homepageSection,
        ]);
    }

    /**
     * Update a homepage section.
     */
    public function update(HomepageSectionRequest $request, HomepageSection $homepageSection): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $this->deleteUpload($homepageSection->image);
            $data['image'] = $this->storeUpload($request->file('image'));
        }

        $homepageSection->update($data);

        return redirect()
            ->route('admin.website.sections.index')
            ->with('status', 'Homepage section updated.');
    }

    /**
     * Delete a homepage section.
     */
    public function destroy(HomepageSection $homepageSection): RedirectResponse
    {
        $this->deleteUpload($homepageSection->image);
        $homepageSection->delete();

        return redirect()
            ->route('admin.website.sections.index')
            ->with('status', 'Homepage section deleted.');
    }

    private function storeUpload($file): string
    {
        $directory = public_path('uploads/website');
        File::ensureDirectoryExists($directory);

        $filename = 'section-'.Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'uploads/website/'.$filename;
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && str_starts_with($path, 'uploads/website/')) {
            File::delete(public_path($path));
        }
    }
}
