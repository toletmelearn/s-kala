@php
    $imageExists = $event->cover_image && file_exists(public_path($event->cover_image));
@endphp

<article class="overflow-hidden rounded-[2rem] border border-rose-100 bg-white shadow-xl shadow-rose-100/40">
    @if ($imageExists)
        <img src="{{ asset($event->cover_image) }}" alt="{{ $event->title }}" class="h-48 w-full object-cover">
    @else
        <div class="flex h-48 items-center justify-center bg-[#fbf7f0] text-sm font-semibold text-stone-500">No cover image</div>
    @endif
    <div class="p-5">
        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-rose-700">{{ ucfirst($event->status) }}</p>
        <h3 class="mt-2 text-lg font-semibold text-stone-950">{{ $event->title }}</h3>
        <p class="mt-2 text-sm text-stone-600">{{ $event->short_description ?: 'Event summary will be updated soon.' }}</p>
        <p class="mt-2 text-xs text-stone-500">
            {{ $event->event_date?->format('d M Y') ?: 'Date TBD' }}
            @if ($event->location)
                • {{ $event->location }}
            @endif
        </p>
        <a href="{{ route('events.show', $event->slug) }}" class="mt-4 inline-flex rounded-full bg-rose-900 px-4 py-2 text-xs font-semibold text-white hover:bg-rose-800">
            View Details
        </a>
    </div>
</article>
