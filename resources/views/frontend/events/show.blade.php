@extends('layouts.frontend', [
    'title' => $event->title,
    'settings' => $settings,
])

@section('content')
    @php
        $coverExists = $event->cover_image && file_exists(public_path($event->cover_image));
    @endphp

    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
            <a href="{{ route('events.index') }}" class="text-sm font-semibold text-rose-800 hover:text-rose-900">Back to Events</a>
            <div class="mt-4 rounded-[2rem] border border-rose-100 bg-white shadow-xl shadow-rose-100/40">
                @if ($coverExists)
                    <img src="{{ asset($event->cover_image) }}" alt="{{ $event->title }}" class="h-80 w-full rounded-t-[2rem] object-cover">
                @else
                    <div class="flex h-80 items-center justify-center rounded-t-[2rem] bg-[#fbf7f0] text-sm font-semibold text-stone-500">No cover image uploaded</div>
                @endif
                <div class="p-8">
                    <h1 class="text-4xl font-bold text-stone-950">{{ $event->title }}</h1>
                    <p class="mt-4 text-sm text-stone-600">
                        {{ $event->event_date?->format('d M Y') ?: 'Date TBD' }}
                        @if ($event->event_time)
                            • {{ $event->event_time }}
                        @endif
                        @if ($event->location)
                            • {{ $event->location }}
                        @endif
                    </p>
                    @if ($event->short_description)
                        <p class="mt-4 text-lg text-stone-700">{{ $event->short_description }}</p>
                    @endif
                    <p class="mt-6 text-base leading-8 text-stone-700">{{ $event->description ?: 'Detailed event note will be published soon.' }}</p>
                </div>
            </div>
        </div>
    </section>

    @if ($relatedEvents->isNotEmpty())
        <section class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-stone-950">Other Events</h2>
                <div class="mt-6 grid gap-4 lg:grid-cols-3">
                    @foreach ($relatedEvents as $related)
                        @include('frontend.events.partials.card', ['event' => $related])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
