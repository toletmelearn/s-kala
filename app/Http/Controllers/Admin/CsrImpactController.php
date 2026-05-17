<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\ContactEnquiry;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\Product;
use App\Models\ProductEnquiry;
use App\Models\Trainee;
use App\Models\TrainingProgram;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

class CsrImpactController extends Controller
{
    public function index(): View
    {
        $programWiseTrainees = collect();

        if (Schema::hasTable('training_programs') && Schema::hasTable('trainees')) {
            $programWiseTrainees = TrainingProgram::query()
                ->where('is_active', true)
                ->withCount('trainees')
                ->orderBy('sort_order')
                ->get(['id', 'name']);
        }

        return view('admin.csr-impact.index', [
            'pageTitle' => 'CSR Impact Dashboard',
            'breadcrumb' => 'CSR Impact',
            'stats' => [
                'trainees_total' => $this->count('trainees'),
                'trainees_pending' => $this->countWhere('trainees', 'status', 'pending'),
                'trainees_enrolled' => $this->countWhere('trainees', 'status', 'enrolled'),
                'trainees_completed' => $this->countWhere('trainees', 'status', 'completed'),
                'trainees_rejected' => $this->countWhere('trainees', 'status', 'rejected'),
                'programs_active' => $this->countWhere('training_programs', 'is_active', true),
                'programs_featured' => $this->countWhere('training_programs', 'is_featured', true),
                'certificates_total' => $this->count('certificates'),
                'certificates_issued' => $this->countWhere('certificates', 'status', 'issued'),
                'certificates_draft' => $this->countWhere('certificates', 'status', 'draft'),
                'certificates_revoked' => $this->countWhere('certificates', 'status', 'revoked'),
                'products_total' => $this->count('products'),
                'products_featured' => $this->countWhere('products', 'is_featured', true),
                'product_enquiries_total' => $this->count('product_enquiries'),
                'product_enquiries_new' => $this->countWhere('product_enquiries', 'status', 'new'),
                'contact_enquiries_total' => $this->count('contact_enquiries'),
                'contact_enquiries_csr' => $this->countWhere('contact_enquiries', 'type', 'csr_partner'),
                'contact_enquiries_volunteer' => $this->countWhere('contact_enquiries', 'type', 'volunteer'),
                'contact_enquiries_visit' => $this->countWhere('contact_enquiries', 'type', 'visit_request'),
                'contact_enquiries_new' => $this->countWhere('contact_enquiries', 'status', 'new'),
                'gallery_total' => $this->count('gallery_items'),
                'gallery_featured' => $this->countWhere('gallery_items', 'is_featured', true),
                'events_total' => $this->count('events'),
                'events_completed' => $this->countWhere('events', 'status', 'completed'),
                'events_upcoming' => $this->countWhere('events', 'status', 'upcoming'),
            ],
            'programWiseTrainees' => $programWiseTrainees,
        ]);
    }

    private function count(string $table): int
    {
        if (! Schema::hasTable($table)) {
            return 0;
        }

        return match ($table) {
            'trainees' => Trainee::query()->count(),
            'certificates' => Certificate::query()->count(),
            'products' => Product::query()->count(),
            'product_enquiries' => ProductEnquiry::query()->count(),
            'contact_enquiries' => ContactEnquiry::query()->count(),
            'gallery_items' => GalleryItem::query()->count(),
            'events' => Event::query()->count(),
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
            'training_programs' => TrainingProgram::query()->where($column, $value)->count(),
            'certificates' => Certificate::query()->where($column, $value)->count(),
            'products' => Product::query()->where($column, $value)->count(),
            'product_enquiries' => ProductEnquiry::query()->where($column, $value)->count(),
            'contact_enquiries' => ContactEnquiry::query()->where($column, $value)->count(),
            'gallery_items' => GalleryItem::query()->where($column, $value)->count(),
            'events' => Event::query()->where($column, $value)->count(),
            default => 0,
        };
    }
}
