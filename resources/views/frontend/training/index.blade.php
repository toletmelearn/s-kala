@extends('layouts.frontend', [
    'title' => 'Training Programs',
    'settings' => $settings,
])

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="max-w-4xl">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Training Programs</p>
                <h1 class="mt-4 text-4xl font-bold tracking-normal text-stone-950 sm:text-5xl">Skill-to-confidence-to-livelihood journeys at S-kala.</h1>
                <p class="mt-5 max-w-3xl text-base leading-8 text-stone-600">
                    Explore practical programs designed to help women build capability, self-belief, enterprise readiness, and a path toward livelihood.
                </p>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-2">
                @forelse ($programs as $program)
                    @php
                        $imageExists = $program->image && file_exists(public_path($program->image));
                    @endphp
                    <article class="overflow-hidden rounded-[2rem] border border-rose-100 bg-white shadow-xl shadow-rose-100/40">
                        @if ($imageExists)
                            <img src="{{ asset($program->image) }}" alt="{{ $program->name }}" class="h-72 w-full object-cover">
                        @else
                            <div class="flex h-72 items-center justify-center bg-gradient-to-br from-rose-50 via-white to-amber-50 p-8">
                                <div class="rounded-3xl bg-white p-6 text-center shadow-lg shadow-rose-100/60">
                                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">S-kala Program</p>
                                    <p class="mt-3 text-2xl font-bold text-stone-950">{{ $program->name }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="p-6">
                            <div class="flex flex-wrap gap-2">
                                @if ($program->category)
                                    <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-900">{{ $program->category }}</span>
                                @endif
                                @if ($program->duration)
                                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-900">{{ $program->duration }}</span>
                                @endif
                                @if ($program->level)
                                    <span class="rounded-full bg-stone-100 px-3 py-1 text-xs font-semibold text-stone-700">{{ $program->level }}</span>
                                @endif
                            </div>
                            <h2 class="mt-4 text-2xl font-bold text-stone-950">{{ $program->name }}</h2>
                            <p class="mt-3 text-sm leading-6 text-stone-600">{{ $program->short_description ?: $program->description }}</p>

                            @if ($program->outcome)
                                <p class="mt-4 rounded-2xl bg-[#fbf7f0] p-4 text-sm font-medium leading-6 text-stone-700">{{ $program->outcome }}</p>
                            @endif

                            <div class="mt-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-rose-700">Trainers</p>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @forelse ($program->trainers as $trainer)
                                        <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-900">{{ $trainer->name }}</span>
                                    @empty
                                        <span class="text-sm text-stone-500">Trainer details will be updated soon.</span>
                                    @endforelse
                                </div>
                            </div>

                            <a href="{{ route('join.create', ['program' => $program->slug]) }}" class="mt-6 inline-flex rounded-full bg-rose-900 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-rose-900/20 hover:bg-rose-800">
                                Apply for this Program
                            </a>
                        </div>
                    </article>
                @empty
                    @foreach (['Tailoring', 'Embroidery', 'Craft', 'Future Livelihood Skills'] as $program)
                        <article class="rounded-[2rem] border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">S-kala Program</p>
                            <h2 class="mt-4 text-2xl font-bold text-stone-950">{{ $program }}</h2>
                            <p class="mt-3 text-sm leading-6 text-stone-600">A practical learning path focused on confidence, dignity, and livelihood readiness.</p>
                        </article>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Join S-kala</p>
            <h2 class="mt-3 text-3xl font-bold text-stone-950">Begin a journey where skills become confidence and confidence becomes livelihood.</h2>
            <a href="{{ route('join.create') }}" class="mt-8 inline-flex rounded-full bg-rose-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-rose-900/20 hover:bg-rose-800">
                Join S-kala
            </a>
        </div>
    </section>
@endsection
