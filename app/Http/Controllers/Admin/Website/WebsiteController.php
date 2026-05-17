<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use App\Models\ImpactCounter;
use App\Models\WebsiteSetting;
use Illuminate\Contracts\View\View;

class WebsiteController extends Controller
{
    /**
     * Display the Website CMS overview.
     */
    public function index(): View
    {
        return view('admin.website.index', [
            'pageTitle' => 'Website CMS',
            'breadcrumb' => 'Website CMS',
            'settings' => WebsiteSetting::query()->first(),
            'heroSection' => HomepageSection::query()->where('section_key', 'hero')->first(),
            'sections' => HomepageSection::query()->orderBy('sort_order')->get(),
            'impactCounters' => ImpactCounter::query()->orderBy('sort_order')->get(),
        ]);
    }
}
