<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    <div class="space-y-8">
        <section class="rounded-[2rem] border border-rose-100 bg-white p-8 shadow-xl shadow-rose-100/40">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">S-kala Digital Vision</p>
            <h1 class="mt-3 text-4xl font-bold text-stone-950">Skill, Strength &amp; Self-Reliance</h1>
            <p class="mt-3 text-lg text-stone-600">From training to confidence, from confidence to livelihood.</p>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-7">
            @foreach ([
                ['Total Trainees', $stats['total_trainees']],
                ['Enrolled', $stats['enrolled_trainees']],
                ['Completed', $stats['completed_trainees']],
                ['Certificates Issued', $stats['certificates_issued']],
                ['Products', $stats['products_showcased']],
                ['Events', $stats['events_documented']],
                ['Enquiries', $stats['enquiries_received']],
            ] as [$label, $value])
                <article class="rounded-2xl border border-rose-100 bg-white p-5 text-center shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">{{ $label }}</p>
                    <p class="mt-3 text-3xl font-bold text-stone-950">{{ $value }}</p>
                </article>
            @endforeach
        </section>

        <section class="grid gap-4 md:grid-cols-3">
            @foreach (['Vision', 'Training', 'Product Visibility', 'Certification', 'CSR Impact', 'Future Expansion'] as $item)
                <div class="rounded-2xl border border-rose-100 bg-white p-5 text-sm font-semibold text-stone-800 shadow-sm">{{ $item }}</div>
            @endforeach
        </section>

        <section class="rounded-[2rem] border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-8 shadow-xl shadow-amber-100/40">
            <h2 class="text-2xl font-bold text-stone-950">Transformation Story</h2>
            <p class="mt-3 text-base leading-8 text-stone-700">
                From a dilapidated orphanage space to a modern women empowerment and learning centre.
            </p>
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            <article class="rounded-3xl border border-rose-100 bg-white p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-stone-950">Leadership Acknowledgement</h3>
                <div class="mt-4 space-y-2 text-sm text-stone-700">
                    <p><strong>Vision:</strong> Mrs. Pranjali Goyal</p>
                    <p><strong>Direction:</strong> Mrs. Rashmi Rekha</p>
                    <p><strong>Incharge:</strong> Ms. Neetu Singh</p>
                </div>
            </article>
            <article class="rounded-3xl border border-stone-200 bg-stone-950 p-6 text-white shadow-sm">
                <h3 class="text-xl font-semibold">Future-Ready Roadmap</h3>
                <div class="mt-4 grid gap-2 text-sm">
                    @foreach (['Women skill tracking', 'Digital product catalogue', 'Certificate verification', 'CSR report publishing', 'Director impact dashboard', 'Community education support'] as $item)
                        <div class="rounded-xl border border-white/10 bg-white/5 px-3 py-2">{{ $item }}</div>
                    @endforeach
                </div>
            </article>
        </section>

        <section class="rounded-[2rem] border border-rose-100 bg-white p-8 shadow-sm">
            <p class="text-xl font-semibold text-stone-950">This platform positions S-kala as a documented, scalable, and presentation-ready women empowerment model.</p>
        </section>
    </div>
</x-admin-layout>
