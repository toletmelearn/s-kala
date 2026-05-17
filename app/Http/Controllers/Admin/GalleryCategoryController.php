<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryCategoryRequest;
use App\Models\GalleryCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class GalleryCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.gallery-categories.index', [
            'pageTitle' => 'Gallery Categories',
            'breadcrumb' => 'Gallery Categories',
            'categories' => GalleryCategory::query()->orderBy('sort_order')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery-categories.create', [
            'pageTitle' => 'Create Gallery Category',
            'breadcrumb' => 'Gallery Categories / Create',
            'category' => new GalleryCategory(['is_active' => true, 'sort_order' => 0]),
        ]);
    }

    public function store(GalleryCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name']);
        $data['is_active'] = $request->boolean('is_active');

        GalleryCategory::query()->create($data);

        return redirect()->route('admin.gallery-categories.index')->with('status', 'Gallery category created.');
    }

    public function edit(GalleryCategory $galleryCategory): View
    {
        return view('admin.gallery-categories.edit', [
            'pageTitle' => 'Edit Gallery Category',
            'breadcrumb' => 'Gallery Categories / Edit',
            'category' => $galleryCategory,
        ]);
    }

    public function update(GalleryCategoryRequest $request, GalleryCategory $galleryCategory): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name'], $galleryCategory);
        $data['is_active'] = $request->boolean('is_active');

        $galleryCategory->update($data);

        return redirect()->route('admin.gallery-categories.index')->with('status', 'Gallery category updated.');
    }

    public function destroy(GalleryCategory $galleryCategory): RedirectResponse
    {
        $galleryCategory->delete();

        return redirect()->route('admin.gallery-categories.index')->with('status', 'Gallery category deleted.');
    }

    public function toggleStatus(GalleryCategory $galleryCategory): RedirectResponse
    {
        $galleryCategory->update(['is_active' => ! $galleryCategory->is_active]);

        return back()->with('status', 'Gallery category status updated.');
    }

    private function uniqueSlug(string $value, ?GalleryCategory $category = null): string
    {
        $slug = Str::slug($value);
        $base = $slug;
        $counter = 2;

        while (GalleryCategory::query()
            ->where('slug', $slug)
            ->when($category, fn ($query) => $query->whereKeyNot($category->id))
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
