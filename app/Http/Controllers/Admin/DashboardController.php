<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\ContactEnquiry;
use App\Models\Event;
use App\Models\Product;
use App\Models\Trainee;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        return view('admin.dashboard', [
            'pageTitle' => 'Admin Dashboard',
            'breadcrumb' => 'Dashboard',
            'roleName' => $user->getRoleNames()->first() ?? 'Team Member',
            'certificatesIssuedCount' => $this->issuedCertificatesCount(),
            'realStats' => [
                'women_trained' => $this->tableCount('trainees'),
                'active_trainees' => $this->tableCountWhere('trainees', 'status', 'enrolled'),
                'products' => $this->tableCount('products'),
                'events' => $this->tableCount('events'),
                'enquiries' => $this->tableCount('contact_enquiries'),
            ],
        ]);
    }

    private function issuedCertificatesCount(): string
    {
        if (! Schema::hasTable('certificates')) {
            return '0';
        }

        return (string) Certificate::query()->where('status', 'issued')->count();
    }

    private function tableCount(string $table): int
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

    private function tableCountWhere(string $table, string $column, mixed $value): int
    {
        if (! Schema::hasTable($table)) {
            return 0;
        }

        return match ($table) {
            'trainees' => Trainee::query()->where($column, $value)->count(),
            default => 0,
        };
    }
}
