@extends('layouts.frontend', ['title' => 'CSR Impact', 'settings' => $settings])

@section('content')
    <section class="bg-white py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Impact</p>
            <h1 class="mt-3 text-4xl font-bold text-stone-950 sm:text-5xl">Visible CSR Impact, Ready for Presentation.</h1>
            <p class="mt-4 max-w-3xl text-base leading-8 text-stone-600">From training to confidence, from confidence to livelihood.</p>
        </div>
    </section>

    <section class="pb-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['Completed Trainees', $stats['completed_trainees']],
                    ['Issued Certificates', $stats['issued_certificates']],
                    ['Products Showcased', $stats['products_showcased']],
                    ['Events Documented', $stats['events_documented']],
                    ['Gallery Items', $stats['gallery_items']],
                    ['Enquiries Received', $stats['enquiries_received']],
                ] as [$label, $value])
                    <article class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                        <p class="text-sm font-medium text-stone-500">{{ $label }}</p>
                        <p class="mt-3 text-4xl font-bold text-stone-950">{{ $value }}</p>
                    </article>
                @endforeach
            </div>

            <div class="mt-10 grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
                <article class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                    <h2 class="text-2xl font-semibold text-stone-950">Impact Story</h2>
                    <p class="mt-4 text-base leading-8 text-stone-600">
                        S-kala documents real progress across women skill development, product visibility, certification, and community support.
                        This impact view is designed for transparent CSR communication and leadership presentation readiness.
                    </p>
                </article>
                <article class="rounded-3xl border border-stone-200 bg-stone-950 p-6 text-white">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-200">Director Panel</p>
                    <div class="mt-4 grid gap-3">
                        @foreach (['Skill Development', 'Women Empowerment', 'Product Visibility', 'Certification', 'CSR Documentation', 'Community Education Support'] as $item)
                            <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-medium">{{ $item }}</div>
                        @endforeach
                    </div>
                </article>
            </div>

            <div class="mt-10">
                <h2 class="text-2xl font-semibold text-stone-950">Featured Reports</h2>
                <div class="mt-5 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($featuredReports as $report)
                        <article class="rounded-3xl border border-rose-100 bg-white p-5 shadow-sm">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-rose-700">{{ $report->report_period ?: 'CSR Report' }}</p>
                            <h3 class="mt-2 text-lg font-semibold text-stone-950">{{ $report->title }}</h3>
                            <p class="mt-2 text-sm text-stone-600">{{ \Illuminate\Support\Str::limit($report->summary, 120) }}</p>
                            <a href="{{ route('impact.show', $report->slug) }}" class="mt-4 inline-flex rounded-full bg-rose-900 px-4 py-2 text-xs font-semibold text-white hover:bg-rose-800">View Report</a>
                        </article>
                    @empty
                        <p class="text-sm text-stone-500">No featured published reports yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-10">
                <a href="{{ route('contact.create') }}" class="inline-flex rounded-full bg-rose-900 px-6 py-3 text-sm font-semibold text-white hover:bg-rose-800">
                    Contact for CSR Collaboration
                </a>
            </div>
        </div>
    </section>
@endsection
