<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\ContactEnquiry;
use App\Models\CsrReport;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\Product;
use App\Models\Trainee;
use App\Models\WebsiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

class ImpactController extends Controller
{
    public function index(): View
    {
        return view('frontend.impact.index', [
            'settings' => $this->websiteSettings(),
            'stats' => [
                'completed_trainees' => $this->countWhere('trainees', 'status', 'completed'),
                'issued_certificates' => $this->countWhere('certificates', 'status', 'issued'),
                'products_showcased' => $this->count('products'),
                'events_documented' => $this->count('events'),
                'gallery_items' => $this->count('gallery_items'),
                'enquiries_received' => $this->count('contact_enquiries') + $this->count('product_enquiries'),
            ],
            'featuredReports' => Schema::hasTable('csr_reports')
                ? CsrReport::query()->where('is_published', true)->where('is_featured', true)->orderBy('sort_order')->limit(3)->get()
                : collect(),
        ]);
    }

    public function show(string $slug): View
    {
        abort_unless(Schema::hasTable('csr_reports'), 404);

        $report = CsrReport::query()
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        return view('frontend.impact.show', [
            'settings' => $this->websiteSettings(),
            'report' => $report,
        ]);
    }

    private function websiteSettings(): ?WebsiteSetting
    {
        if (! Schema::hasTable('website_settings')) {
            return null;
        }

        return WebsiteSetting::query()->first();
    }

    private function count(string $table): int
    {
        if (! Schema::hasTable($table)) {
            return 0;
        }

        return match ($table) {
            'products' => Product::query()->count(),
            'events' => Event::query()->count(),
            'gallery_items' => GalleryItem::query()->count(),
            'contact_enquiries' => ContactEnquiry::query()->count(),
            'product_enquiries' => \App\Models\ProductEnquiry::query()->count(),
            default => 0,
        };
    }

    private function countWhere(string $table, string $column, mixed $value): int
    {
        if (! Schema::hasTable($table)) {
            return 0;
        }

        return match ($table) {
            'trainees' => Trainee::query()->where($column, $value)->count(),
            'certificates' => Certificate::query()->where($column, $value)->count(),
            default => 0,
        };
    }
}
