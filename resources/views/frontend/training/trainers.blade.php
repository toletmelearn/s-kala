@extends('layouts.frontend', [
    'title' => 'Trainers',
    'settings' => $settings,
])

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="max-w-4xl">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Trainers</p>
                <h1 class="mt-4 text-4xl font-bold tracking-normal text-stone-950 sm:text-5xl">Guidance for practical skills, confidence, and livelihood readiness.</h1>
                <p class="mt-5 max-w-3xl text-base leading-8 text-stone-600">
                    S-kala trainers support women through patient, practical learning and program-focused mentorship.
                </p>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                @forelse ($trainers as $trainer)
                    <article class="rounded-[2rem] border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                        @if ($trainer->photo && file_exists(public_path($trainer->photo)))
                            <img src="{{ asset($trainer->photo) }}" alt="{{ $trainer->name }}" class="h-56 w-full rounded-3xl object-cover">
                        @else
                            <div class="flex h-56 items-center justify-center rounded-3xl bg-gradient-to-br from-rose-50 via-white to-amber-50">
                                <span class="flex h-20 w-20 items-center justify-center rounded-3xl bg-white text-xl font-bold text-rose-900 shadow-lg shadow-rose-100/60">
                                    {{ Str::of($trainer->name)->substr(0, 2)->upper() }}
                                </span>
                            </div>
                        @endif
                        <h2 class="mt-5 text-xl font-bold text-stone-950">{{ $trainer->name }}</h2>
                        <p class="mt-1 text-sm font-semibold text-rose-900">{{ $trainer->specialization ?: $trainer->designation }}</p>
                        <p class="mt-4 text-sm leading-6 text-stone-600">{{ Str::limit($trainer->bio ?: 'Trainer profile will be updated soon.', 140) }}</p>
                        <div class="mt-5 flex flex-wrap gap-2">
                            @foreach ($trainer->trainingPrograms as $program)
                                <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-900">{{ $program->name }}</span>
                            @endforeach
                        </div>
                    </article>
                @empty
                    @foreach (['Tailoring Trainer', 'Embroidery Trainer', 'Craft Trainer', 'Livelihood Skills Trainer'] as $trainer)
                        <article class="rounded-[2rem] border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                            <div class="flex h-56 items-center justify-center rounded-3xl bg-gradient-to-br from-rose-50 via-white to-amber-50">
                                <span class="flex h-20 w-20 items-center justify-center rounded-3xl bg-white text-xl font-bold text-rose-900 shadow-lg shadow-rose-100/60">Sk</span>
                            </div>
                            <h2 class="mt-5 text-xl font-bold text-stone-950">{{ $trainer }}</h2>
                            <p class="mt-4 text-sm leading-6 text-stone-600">Trainer profile will be updated from the admin panel.</p>
                        </article>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>
@endsection
