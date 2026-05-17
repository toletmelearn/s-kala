<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
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
        ]);
    }

    private function issuedCertificatesCount(): string
    {
        if (! Schema::hasTable('certificates')) {
            return '0';
        }

        return (string) Certificate::query()->where('status', 'issued')->count();
    }
}
