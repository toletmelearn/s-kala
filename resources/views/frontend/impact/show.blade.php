@extends('layouts.frontend', ['title' => $report->title, 'settings' => $settings])

@section('content')
    <section class="py-16">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <article class="rounded-[2rem] border border-rose-100 bg-white p-8 shadow-xl shadow-rose-100/40">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">{{ $report->report_period ?: 'CSR Report' }}</p>
                <h1 class="mt-3 text-3xl font-bold text-stone-950">{{ $report->title }}</h1>

                <div class="mt-6">
                    @if ($report->cover_image && file_exists(public_path($report->cover_image)))
                        <img src="{{ asset($report->cover_image) }}" alt="{{ $report->title }}" class="h-72 w-full rounded-3xl object-cover">
                    @else
                        <div class="flex h-72 items-center justify-center rounded-3xl bg-[#fbf7f0] text-sm font-semibold text-stone-500">
                            Cover image not available
                        </div>
                    @endif
                </div>

                <div class="mt-8 space-y-6 text-sm leading-7 text-stone-700">
                    <div>
                        <h2 class="text-lg font-semibold text-stone-950">Summary</h2>
                        <p class="mt-2">{{ $report->summary ?: 'Not provided.' }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-stone-950">Highlights</h2>
                        <p class="mt-2">{{ $report->highlights ?: 'Not provided.' }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-stone-950">Challenges</h2>
                        <p class="mt-2">{{ $report->challenges ?: 'Not provided.' }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-stone-950">Future Plan</h2>
                        <p class="mt-2">{{ $report->future_plan ?: 'Not provided.' }}</p>
                    </div>
                </div>

                @if ($report->report_file && file_exists(public_path($report->report_file)))
                    <a href="{{ asset($report->report_file) }}" target="_blank" class="mt-8 inline-flex rounded-full bg-rose-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-rose-800">
                        Download PDF Report
                    </a>
                @endif
            </article>
        </div>
    </section>
@endsection
