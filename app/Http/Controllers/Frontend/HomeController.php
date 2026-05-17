<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\HomepageSection;
use App\Models\ImpactCounter;
use App\Models\Product;
use App\Models\TrainingProgram;
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
            'featuredPrograms' => $this->featuredPrograms(),
            'featuredGalleryItems' => $this->featuredGalleryItems(),
            'featuredEvents' => $this->featuredEvents(),
            'featuredProducts' => $this->featuredProducts(),
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

    private function featuredPrograms(): Collection
    {
        if (! Schema::hasTable('training_programs')) {
            return collect();
        }

        return TrainingProgram::query()
            ->with(['trainers' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order')])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();
    }

    private function featuredGalleryItems(): Collection
    {
        if (! Schema::hasTable('gallery_items')) {
            return collect();
        }

        return GalleryItem::query()
            ->with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();
    }

    private function featuredEvents(): Collection
    {
        if (! Schema::hasTable('events')) {
            return collect();
        }

        return Event::query()
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderByDesc('event_date')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();
    }

    private function featuredProducts(): Collection
    {
        if (! Schema::hasTable('products')) {
            return collect();
        }

        return Product::query()
            ->with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();
    }
}
