<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
        ]);
    }
}
