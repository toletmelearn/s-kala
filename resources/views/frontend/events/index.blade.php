@extends('layouts.frontend', [
    'title' => 'Events',
    'settings' => $settings,
])

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="max-w-4xl">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Events</p>
                <h1 class="mt-4 text-4xl font-bold tracking-normal text-stone-950 sm:text-5xl">S-kala milestones and community-learning moments.</h1>
                <p class="mt-5 max-w-3xl text-base leading-8 text-stone-600">Featured programs, workshops, and events that shape institutional growth and women empowerment visibility.</p>
            </div>
        </div>
    </section>

    <section class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-stone-950">Featured Events</h2>
            <div class="mt-6 grid gap-4 lg:grid-cols-3">
                @forelse ($featuredEvents as $event)
                    @include('frontend.events.partials.card', ['event' => $event])
                @empty
                    @foreach ([
                        ['title' => 'S-kala Inauguration', 'text' => 'A new beginning for women empowerment and skill development in Dhampur.'],
                        ['title' => 'Training Orientation', 'text' => 'A focused preparation program to strengthen training quality.'],
                        ['title' => 'Women Skill Workshop', 'text' => 'Hands-on learning for tailoring, embroidery, craft, and confidence-building.'],
                    ] as $fallback)
                        <article class="rounded-[2rem] border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                            <p class="text-sm font-semibold uppercase tracking-[0.16em] text-rose-700">Featured</p>
                            <h3 class="mt-3 text-xl font-semibold text-stone-950">{{ $fallback['title'] }}</h3>
                            <p class="mt-3 text-sm text-stone-600">{{ $fallback['text'] }}</p>
                        </article>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-stone-950">Upcoming Events</h2>
            <div class="mt-6 grid gap-4 lg:grid-cols-2">
                @forelse ($upcomingEvents as $event)
                    @include('frontend.events.partials.card', ['event' => $event])
                @empty
                    <div class="rounded-3xl border border-dashed border-rose-200 bg-white p-8 text-sm text-stone-500 lg:col-span-2">
                        No upcoming events currently listed.
                    </div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $upcomingEvents->links() }}
            </div>
        </div>
    </section>

    <section class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-stone-950">Completed Events</h2>
            <div class="mt-6 grid gap-4 lg:grid-cols-3">
                @forelse ($completedEvents as $event)
                    @include('frontend.events.partials.card', ['event' => $event])
                @empty
                    <div class="rounded-3xl border border-dashed border-rose-200 bg-white p-8 text-sm text-stone-500 lg:col-span-3">
                        Completed events will appear here.
                    </div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $completedEvents->links() }}
            </div>
        </div>
    </section>
@endsection
