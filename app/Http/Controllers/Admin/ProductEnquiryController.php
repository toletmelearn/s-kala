<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductEnquiryUpdateRequest;
use App\Models\Product;
use App\Models\ProductEnquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProductEnquiryController extends Controller
{
    public function index(): View
    {
        $status = request('status');
        $productId = request('product');
        $search = trim((string) request('search'));

        return view('admin.product-enquiries.index', [
            'pageTitle' => 'Product Enquiries',
            'breadcrumb' => 'Product Enquiries',
            'enquiries' => ProductEnquiry::query()
                ->with('product')
                ->when($status, fn ($query) => $query->where('status', $status))
                ->when($productId, fn ($query) => $query->where('product_id', $productId))
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($innerQuery) use ($search) {
                        $innerQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
                })
                ->latest()
                ->paginate(15)
                ->withQueryString(),
            'products' => Product::query()->where('is_active', true)->orderBy('name')->get(),
            'statuses' => ['new', 'contacted', 'closed'],
            'filters' => compact('status', 'productId', 'search'),
        ]);
    }

    public function show(ProductEnquiry $productEnquiry): View
    {
        return view('admin.product-enquiries.show', [
            'pageTitle' => 'Enquiry Details',
            'breadcrumb' => 'Product Enquiries / Details',
            'enquiry' => $productEnquiry->load('product'),
            'statuses' => ['new', 'contacted', 'closed'],
        ]);
    }

    public function update(ProductEnquiryUpdateRequest $request, ProductEnquiry $productEnquiry): RedirectResponse
    {
        $productEnquiry->update($request->validated());

        return redirect()->route('admin.product-enquiries.show', $productEnquiry)->with('status', 'Enquiry updated.');
    }

    public function destroy(ProductEnquiry $productEnquiry): RedirectResponse
    {
        $productEnquiry->delete();

        return redirect()->route('admin.product-enquiries.index')->with('status', 'Enquiry deleted.');
    }
}
