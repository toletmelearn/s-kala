<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryItemRequest;
use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GalleryItemController extends Controller
{
    public function index(): View
    {
        $category = request('category');
        $type = request('type');
        $active = request('active');
        $featured = request('featured');

        return view('admin.gallery.index', [
            'pageTitle' => 'Gallery Items',
            'breadcrumb' => 'Gallery Items',
            'categories' => GalleryCategory::query()->orderBy('sort_order')->get(),
            'items' => GalleryItem::query()
                ->with('category')
                ->when($category, fn ($query) => $query->where('gallery_category_id', $category))
                ->when($type, fn ($query) => $query->where('type', $type))
                ->when($active !== null && $active !== '', fn ($query) => $query->where('is_active', (bool) $active))
                ->when($featured !== null && $featured !== '', fn ($query) => $query->where('is_featured', (bool) $featured))
                ->orderBy('sort_order')
                ->paginate(16)
                ->withQueryString(),
            'filters' => compact('category', 'type', 'active', 'featured'),
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery.create', [
            'pageTitle' => 'Create Gallery Item',
            'breadcrumb' => 'Gallery / Create',
            'item' => new GalleryItem(['is_active' => true, 'is_featured' => false, 'sort_order' => 0, 'type' => 'image']),
            'categories' => GalleryCategory::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'types' => ['image', 'transformation', 'training', 'product', 'event'],
        ]);
    }

    public function store(GalleryItemRequest $request): RedirectResponse
    {
        $data = $this->payload($request);

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeUpload($request->file('image'));
        }

        GalleryItem::query()->create($data);

        return redirect()->route('admin.gallery.index')->with('status', 'Gallery item created.');
    }

    public function edit(GalleryItem $galleryItem): View
    {
        return view('admin.gallery.edit', [
            'pageTitle' => 'Edit Gallery Item',
            'breadcrumb' => 'Gallery / Edit',
            'item' => $galleryItem,
            'categories' => GalleryCategory::query()->orderBy('sort_order')->get(),
            'types' => ['image', 'transformation', 'training', 'product', 'event'],
        ]);
    }

    public function update(GalleryItemRequest $request, GalleryItem $galleryItem): RedirectResponse
    {
        $data = $this->payload($request, $galleryItem);

        if ($request->hasFile('image')) {
            $this->deleteUpload($galleryItem->image);
            $data['image'] = $this->storeUpload($request->file('image'));
        }

        $galleryItem->update($data);

        return redirect()->route('admin.gallery.index')->with('status', 'Gallery item updated.');
    }

    public function destroy(GalleryItem $galleryItem): RedirectResponse
    {
        $this->deleteUpload($galleryItem->image);
        $galleryItem->delete();

        return redirect()->route('admin.gallery.index')->with('status', 'Gallery item deleted.');
    }

    public function toggleStatus(GalleryItem $galleryItem): RedirectResponse
    {
        $galleryItem->update(['is_active' => ! $galleryItem->is_active]);

        return back()->with('status', 'Gallery item status updated.');
    }

    public function toggleFeatured(GalleryItem $galleryItem): RedirectResponse
    {
        $galleryItem->update(['is_featured' => ! $galleryItem->is_featured]);

        return back()->with('status', 'Gallery item featured status updated.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(GalleryItemRequest $request, ?GalleryItem $item = null): array
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title'], $item);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }

    private function uniqueSlug(string $value, ?GalleryItem $item = null): string
    {
        $slug = Str::slug($value);
        $base = $slug;
        $counter = 2;

        while (GalleryItem::query()
            ->where('slug', $slug)
            ->when($item, fn ($query) => $query->whereKeyNot($item->id))
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function storeUpload($file): string
    {
        $directory = public_path('uploads/gallery');
        File::ensureDirectoryExists($directory);

        $filename = 'gallery-'.Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'uploads/gallery/'.$filename;
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && str_starts_with($path, 'uploads/gallery/')) {
            File::delete(public_path($path));
        }
    }
}
