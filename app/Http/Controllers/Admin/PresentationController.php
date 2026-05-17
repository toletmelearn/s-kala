<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\ContactEnquiry;
use App\Models\Event;
use App\Models\Product;
use App\Models\Trainee;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

class PresentationController extends Controller
{
    public function index(): View
    {
        return view('admin.presentation.index', [
            'pageTitle' => 'Director Presentation Mode',
            'breadcrumb' => 'Presentation',
            'stats' => [
                'total_trainees' => $this->count('trainees'),
                'enrolled_trainees' => $this->countWhere('trainees', 'status', 'enrolled'),
                'completed_trainees' => $this->countWhere('trainees', 'status', 'completed'),
                'certificates_issued' => $this->countWhere('certificates', 'status', 'issued'),
                'products_showcased' => $this->count('products'),
                'events_documented' => $this->count('events'),
                'enquiries_received' => $this->count('contact_enquiries'),
            ],
        ]);
    }

    private function count(string $table): int
    {
        if (! Schema::hasTable($table)) {
            return 0;
        }

        return match ($table) {
            'trainees' => Trainee::query()->count(),
            'products' => Product::query()->count(),
            'events' => Event::query()->count(),
            'contact_enquiries' => ContactEnquiry::query()->count(),
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
