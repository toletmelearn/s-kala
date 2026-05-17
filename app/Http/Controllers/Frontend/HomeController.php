<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use App\Models\ImpactCounter;
use App\Models\WebsiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    /**
     * Display the public S-kala homepage.
     */
    public function __invoke(): View
    {
        $sections = $this->homepageSections();

        return view('frontend.home', [
            'settings' => $this->websiteSettings(),
            'hero' => $sections->get('hero'),
            'vision' => $sections->get('vision'),
            'leadership' => $sections->get('leadership'),
            'transformation' => $sections->get('transformation'),
            'impactCounters' => $this->impactCounters(),
        ]);
    }

    private function websiteSettings(): ?WebsiteSetting
    {
        if (! Schema::hasTable('website_settings')) {
            return null;
        }

        return WebsiteSetting::query()->first();
    }

    private function homepageSections(): Collection
    {
        if (! Schema::hasTable('homepage_sections')) {
            return collect();
        }

        return HomepageSection::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('section_key');
    }

    private function impactCounters(): Collection
    {
        if (! Schema::hasTable('impact_counters')) {
            return collect();
        }

        return ImpactCounter::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}
