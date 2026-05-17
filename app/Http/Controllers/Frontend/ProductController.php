<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\PublicProductEnquiryRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductEnquiry;
use App\Models\WebsiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    public function index(): View
    {
        $categorySlug = request('category');
        $categories = $this->categories();
        $activeCategory = $categorySlug ? $categories->firstWhere('slug', $categorySlug) : null;

        $products = $this->productsQuery()
            ->when($activeCategory, fn ($query) => $query->where('product_category_id', $activeCategory->id))
            ->paginate(16)
            ->withQueryString();

        return view('frontend.products.index', [
            'settings' => $this->websiteSettings(),
            'categories' => $categories,
            'activeCategory' => $activeCategory,
            'featuredProducts' => $this->productsQuery()->where('is_featured', true)->limit(6)->get(),
            'products' => $products,
        ]);
    }

    public function show(string $slug): View
    {
        abort_unless(Schema::hasTable('products'), 404);

        $product = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        return view('frontend.products.show', [
            'settings' => $this->websiteSettings(),
            'product' => $product,
            'relatedProducts' => Product::query()
                ->where('is_active', true)
                ->whereKeyNot($product->id)
                ->when($product->product_category_id, fn ($query) => $query->where('product_category_id', $product->product_category_id))
                ->orderBy('sort_order')
                ->limit(4)
                ->get(),
        ]);
    }

    public function enquiry(PublicProductEnquiryRequest $request, string $slug): RedirectResponse
    {
        abort_unless(Schema::hasTable('products') && Schema::hasTable('product_enquiries'), 404);

        $product = Product::query()
            ->where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $data = $request->validated();
        $data['product_id'] = $product->id;
        $data['status'] = 'new';

        ProductEnquiry::query()->create($data);

        return back()->with('success', 'Thank you for your interest. Our team will contact you soon.');
    }

    private function websiteSettings(): ?WebsiteSetting
    {
        if (! Schema::hasTable('website_settings')) {
            return null;
        }

        return WebsiteSetting::query()->first();
    }

    private function categories()
    {
        if (! Schema::hasTable('product_categories')) {
            return collect();
        }

        return ProductCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    private function productsQuery()
    {
        if (! Schema::hasTable('products')) {
            return Product::query()->whereRaw('1=0');
        }

        return Product::query()
            ->with('category')
            ->where('is_active', true)
            ->orderBy('sort_order');
    }
}
