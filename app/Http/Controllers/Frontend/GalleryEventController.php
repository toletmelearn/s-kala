<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use App\Models\WebsiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

class GalleryEventController extends Controller
{
    public function gallery(): View
    {
        $categorySlug = request('category');

        $categories = $this->galleryCategories();
        $activeCategory = $categorySlug ? $categories->firstWhere('slug', $categorySlug) : null;

        $items = $this->galleryItemsQuery()
            ->when($activeCategory, fn ($query) => $query->where('gallery_category_id', $activeCategory->id))
            ->paginate(18)
            ->withQueryString();

        return view('frontend.gallery.index', [
            'settings' => $this->websiteSettings(),
            'categories' => $categories,
            'activeCategory' => $activeCategory,
            'featuredItems' => $this->galleryItemsQuery()->where('is_featured', true)->limit(6)->get(),
            'items' => $items,
        ]);
    }

    public function events(): View
    {
        return view('frontend.events.index', [
            'settings' => $this->websiteSettings(),
            'featuredEvents' => $this->eventsQuery()->where('is_featured', true)->limit(3)->get(),
            'upcomingEvents' => $this->eventsQuery()->where('status', 'upcoming')->paginate(6, ['*'], 'upcoming_page'),
            'completedEvents' => $this->eventsQuery()->where('status', 'completed')->paginate(9, ['*'], 'completed_page'),
        ]);
    }

    public function eventDetail(string $slug): View
    {
        abort_unless(Schema::hasTable('events'), 404);

        $event = Event::query()
            ->where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedEvents = Event::query()
            ->where('is_active', true)
            ->whereKeyNot($event->id)
            ->orderByDesc('event_date')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('frontend.events.show', [
            'settings' => $this->websiteSettings(),
            'event' => $event,
            'relatedEvents' => $relatedEvents,
        ]);
    }

    private function websiteSettings(): ?WebsiteSetting
    {
        if (! Schema::hasTable('website_settings')) {
            return null;
        }

        return WebsiteSetting::query()->first();
    }

    private function galleryCategories()
    {
        if (! Schema::hasTable('gallery_categories')) {
            return collect();
        }

        return GalleryCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    private function galleryItemsQuery()
    {
        if (! Schema::hasTable('gallery_items')) {
            return GalleryItem::query()->whereRaw('1 = 0');
        }

        return GalleryItem::query()
            ->with('category')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('taken_on');
    }

    private function eventsQuery()
    {
        if (! Schema::hasTable('events')) {
            return Event::query()->whereRaw('1 = 0');
        }

        return Event::query()
            ->where('is_active', true)
            ->orderByDesc('event_date')
            ->orderBy('sort_order');
    }
}
