<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(): View
    {
        $category = request('category');
        $active = request('active');
        $featured = request('featured');
        $search = trim((string) request('search'));

        $products = Product::query()
            ->with('category')
            ->when($category, fn ($query) => $query->where('product_category_id', $category))
            ->when($active !== null && $active !== '', fn ($query) => $query->where('is_active', (bool) $active))
            ->when($featured !== null && $featured !== '', fn ($query) => $query->where('is_featured', (bool) $featured))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('skill_used', 'like', "%{$search}%")
                        ->orWhere('material', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->paginate(16)
            ->withQueryString();

        return view('admin.products.index', [
            'pageTitle' => 'Products',
            'breadcrumb' => 'Products',
            'products' => $products,
            'categories' => ProductCategory::query()->orderBy('sort_order')->get(),
            'filters' => compact('category', 'active', 'featured', 'search'),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'pageTitle' => 'Create Product',
            'breadcrumb' => 'Products / Create',
            'product' => new Product(['is_active' => true, 'is_featured' => false, 'sort_order' => 0]),
            'categories' => ProductCategory::query()->where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $this->payload($request);

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeUpload($request->file('image'), 'product');
        }

        if ($request->hasFile('gallery_files')) {
            $data['gallery'] = collect($request->file('gallery_files'))
                ->map(fn ($file) => $this->storeUpload($file, 'gallery'))
                ->values()
                ->all();
        }

        Product::query()->create($data);

        return redirect()->route('admin.products.index')->with('status', 'Product created.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'pageTitle' => 'Edit Product',
            'breadcrumb' => 'Products / Edit',
            'product' => $product,
            'categories' => ProductCategory::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $this->payload($request, $product);

        if ($request->hasFile('image')) {
            $this->deleteUpload($product->image);
            $data['image'] = $this->storeUpload($request->file('image'), 'product');
        }

        if ($request->hasFile('gallery_files')) {
            foreach ((array) $product->gallery as $path) {
                $this->deleteUpload($path);
            }

            $data['gallery'] = collect($request->file('gallery_files'))
                ->map(fn ($file) => $this->storeUpload($file, 'gallery'))
                ->values()
                ->all();
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->deleteUpload($product->image);

        foreach ((array) $product->gallery as $path) {
            $this->deleteUpload($path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Product deleted.');
    }

    public function toggleStatus(Product $product): RedirectResponse
    {
        $product->update(['is_active' => ! $product->is_active]);

        return back()->with('status', 'Product status updated.');
    }

    public function toggleFeatured(Product $product): RedirectResponse
    {
        $product->update(['is_featured' => ! $product->is_featured]);

        return back()->with('status', 'Product featured status updated.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(ProductRequest $request, ?Product $product = null): array
    {
        $data = $request->validated();
        unset($data['gallery_files']);

        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name'], $product);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }

    private function uniqueSlug(string $value, ?Product $product = null): string
    {
        $slug = Str::slug($value);
        $base = $slug;
        $counter = 2;

        while (Product::query()
            ->where('slug', $slug)
            ->when($product, fn ($query) => $query->whereKeyNot($product->id))
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function storeUpload($file, string $prefix): string
    {
        $directory = public_path('uploads/products');
        File::ensureDirectoryExists($directory);

        $filename = $prefix.'-'.Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'uploads/products/'.$filename;
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && str_starts_with($path, 'uploads/products/')) {
            File::delete(public_path($path));
        }
    }
}
