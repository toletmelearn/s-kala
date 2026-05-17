<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventRequest;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(): View
    {
        $status = request('status');
        $active = request('active');
        $featured = request('featured');

        return view('admin.events.index', [
            'pageTitle' => 'Events',
            'breadcrumb' => 'Events',
            'events' => Event::query()
                ->when($status, fn ($query) => $query->where('status', $status))
                ->when($active !== null && $active !== '', fn ($query) => $query->where('is_active', (bool) $active))
                ->when($featured !== null && $featured !== '', fn ($query) => $query->where('is_featured', (bool) $featured))
                ->orderBy('sort_order')
                ->paginate(15)
                ->withQueryString(),
            'filters' => compact('status', 'active', 'featured'),
            'statuses' => ['upcoming', 'completed', 'cancelled'],
        ]);
    }

    public function create(): View
    {
        return view('admin.events.create', [
            'pageTitle' => 'Create Event',
            'breadcrumb' => 'Events / Create',
            'event' => new Event(['is_active' => true, 'is_featured' => false, 'status' => 'completed', 'sort_order' => 0]),
            'statuses' => ['upcoming', 'completed', 'cancelled'],
        ]);
    }

    public function store(EventRequest $request): RedirectResponse
    {
        $data = $this->payload($request);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->storeUpload($request->file('cover_image'));
        }

        Event::query()->create($data);

        return redirect()->route('admin.events.index')->with('status', 'Event created.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.edit', [
            'pageTitle' => 'Edit Event',
            'breadcrumb' => 'Events / Edit',
            'event' => $event,
            'statuses' => ['upcoming', 'completed', 'cancelled'],
        ]);
    }

    public function update(EventRequest $request, Event $event): RedirectResponse
    {
        $data = $this->payload($request, $event);

        if ($request->hasFile('cover_image')) {
            $this->deleteUpload($event->cover_image);
            $data['cover_image'] = $this->storeUpload($request->file('cover_image'));
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('status', 'Event updated.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->deleteUpload($event->cover_image);
        $event->delete();

        return redirect()->route('admin.events.index')->with('status', 'Event deleted.');
    }

    public function toggleStatus(Event $event): RedirectResponse
    {
        $event->update(['is_active' => ! $event->is_active]);

        return back()->with('status', 'Event active status updated.');
    }

    public function toggleFeatured(Event $event): RedirectResponse
    {
        $event->update(['is_featured' => ! $event->is_featured]);

        return back()->with('status', 'Event featured status updated.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(EventRequest $request, ?Event $event = null): array
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title'], $event);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }

    private function uniqueSlug(string $value, ?Event $event = null): string
    {
        $slug = Str::slug($value);
        $base = $slug;
        $counter = 2;

        while (Event::query()
            ->where('slug', $slug)
            ->when($event, fn ($query) => $query->whereKeyNot($event->id))
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function storeUpload($file): string
    {
        $directory = public_path('uploads/events');
        File::ensureDirectoryExists($directory);

        $filename = 'event-'.Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'uploads/events/'.$filename;
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && str_starts_with($path, 'uploads/events/')) {
            File::delete(public_path($path));
        }
    }
}
