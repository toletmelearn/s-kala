<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @php
        $statusStyles = [
            'upcoming' => 'bg-sky-100 text-sky-900',
            'completed' => 'bg-emerald-100 text-emerald-900',
            'cancelled' => 'bg-rose-100 text-rose-900',
        ];
    @endphp

    <div class="space-y-6">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <form method="GET" action="{{ route('admin.events.index') }}" class="rounded-3xl border border-rose-100 bg-white p-5 shadow-sm">
            <div class="grid gap-3 md:grid-cols-4">
                <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    <option value="">All statuses</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected($filters['status'] === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <select name="active" class="rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    <option value="">Any active state</option>
                    <option value="1" @selected((string) $filters['active'] === '1')>Active</option>
                    <option value="0" @selected((string) $filters['active'] === '0')>Inactive</option>
                </select>
                <select name="featured" class="rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    <option value="">Any featured state</option>
                    <option value="1" @selected((string) $filters['featured'] === '1')>Featured</option>
                    <option value="0" @selected((string) $filters['featured'] === '0')>Not Featured</option>
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="w-full rounded-xl bg-rose-900 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-800">Filter</button>
                    <a href="{{ route('admin.events.index') }}" class="rounded-xl border border-rose-100 px-4 py-2 text-sm font-semibold text-stone-600 hover:bg-rose-50">Reset</a>
                </div>
            </div>
        </form>

        <div class="flex justify-end">
            <a href="{{ route('admin.events.create') }}" class="inline-flex rounded-xl bg-rose-900 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-rose-900/15 hover:bg-rose-800">
                Add Event
            </a>
        </div>

        <section class="grid gap-4 lg:grid-cols-2">
            @forelse ($events as $event)
                @php
                    $imageExists = $event->cover_image && file_exists(public_path($event->cover_image));
                @endphp
                <article class="overflow-hidden rounded-3xl border border-rose-100 bg-white shadow-xl shadow-rose-100/40">
                    @if ($imageExists)
                        <img src="{{ asset($event->cover_image) }}" alt="{{ $event->title }}" class="h-48 w-full object-cover">
                    @else
                        <div class="flex h-48 items-center justify-center bg-[#fbf7f0] text-sm font-semibold text-stone-500">No cover image uploaded</div>
                    @endif
                    <div class="p-5">
                        <div class="flex flex-wrap gap-2">
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusStyles[$event->status] }}">{{ ucfirst($event->status) }}</span>
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $event->is_active ? 'bg-emerald-100 text-emerald-900' : 'bg-stone-100 text-stone-600' }}">{{ $event->is_active ? 'Active' : 'Inactive' }}</span>
                            @if ($event->is_featured)
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-900">Featured</span>
                            @endif
                        </div>
                        <h3 class="mt-3 text-lg font-semibold text-stone-950">{{ $event->title }}</h3>
                        <p class="mt-2 text-sm text-stone-600">{{ $event->short_description ?: '-' }}</p>
                        <p class="mt-2 text-xs text-stone-500">
                            {{ $event->event_date?->format('d M Y') ?: 'Date TBD' }}
                            @if ($event->event_time)
                                • {{ $event->event_time }}
                            @endif
                            @if ($event->location)
                                • {{ $event->location }}
                            @endif
                        </p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="{{ route('admin.events.edit', $event) }}" class="rounded-xl border border-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-900 hover:bg-rose-50">Edit</a>
                            <form method="POST" action="{{ route('admin.events.toggle-status', $event) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="rounded-xl border border-stone-200 px-3 py-1.5 text-xs font-semibold text-stone-700 hover:bg-stone-50">Toggle</button>
                            </form>
                            <form method="POST" action="{{ route('admin.events.toggle-featured', $event) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="rounded-xl border border-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-800 hover:bg-amber-50">Feature</button>
                            </form>
                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Delete this event?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-xl border border-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50">Delete</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-rose-200 bg-white p-8 text-sm text-stone-500 lg:col-span-2">
                    No events yet.
                </div>
            @endforelse
        </section>

        {{ $events->links() }}
    </div>
</x-admin-layout>
