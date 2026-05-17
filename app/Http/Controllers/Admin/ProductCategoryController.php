<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.product-categories.index', [
            'pageTitle' => 'Product Categories',
            'breadcrumb' => 'Product Categories',
            'categories' => ProductCategory::query()->orderBy('sort_order')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.product-categories.create', [
            'pageTitle' => 'Create Product Category',
            'breadcrumb' => 'Product Categories / Create',
            'category' => new ProductCategory(['is_active' => true, 'sort_order' => 0]),
        ]);
    }

    public function store(ProductCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name']);
        $data['is_active'] = $request->boolean('is_active');

        ProductCategory::query()->create($data);

        return redirect()->route('admin.product-categories.index')->with('status', 'Product category created.');
    }

    public function edit(ProductCategory $productCategory): View
    {
        return view('admin.product-categories.edit', [
            'pageTitle' => 'Edit Product Category',
            'breadcrumb' => 'Product Categories / Edit',
            'category' => $productCategory,
        ]);
    }

    public function update(ProductCategoryRequest $request, ProductCategory $productCategory): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name'], $productCategory);
        $data['is_active'] = $request->boolean('is_active');

        $productCategory->update($data);

        return redirect()->route('admin.product-categories.index')->with('status', 'Product category updated.');
    }

    public function destroy(ProductCategory $productCategory): RedirectResponse
    {
        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')->with('status', 'Product category deleted.');
    }

    public function toggleStatus(ProductCategory $productCategory): RedirectResponse
    {
        $productCategory->update(['is_active' => ! $productCategory->is_active]);

        return back()->with('status', 'Product category status updated.');
    }

    private function uniqueSlug(string $value, ?ProductCategory $category = null): string
    {
        $slug = Str::slug($value);
        $base = $slug;
        $counter = 2;

        while (ProductCategory::query()
            ->where('slug', $slug)
            ->when($category, fn ($query) => $query->whereKeyNot($category->id))
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
