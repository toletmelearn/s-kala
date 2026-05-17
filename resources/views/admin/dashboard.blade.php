<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @php
        $impactCards = [
            ['label' => 'Women Trained', 'value' => '240+', 'accent' => 'bg-rose-100 text-rose-900'],
            ['label' => 'Active Trainees', 'value' => '68', 'accent' => 'bg-amber-100 text-amber-900'],
            ['label' => 'Training Programs', 'value' => '04', 'accent' => 'bg-emerald-100 text-emerald-900'],
            ['label' => 'Handmade Products', 'value' => '120+', 'accent' => 'bg-pink-100 text-pink-900'],
            ['label' => 'Certificates Issued', 'value' => '92', 'accent' => 'bg-yellow-100 text-yellow-900'],
            ['label' => 'Enquiries', 'value' => '31', 'accent' => 'bg-stone-200 text-stone-900'],
        ];

        $quickActions = [
            ['label' => 'Manage Website', 'permission' => 'website.manage'],
            ['label' => 'Training Programs', 'permission' => 'programs.manage'],
            ['label' => 'Trainers', 'permission' => 'trainers.manage'],
            ['label' => 'Trainees', 'permission' => 'trainees.manage'],
            ['label' => 'Product Showcase', 'permission' => 'products.manage'],
            ['label' => 'Gallery', 'permission' => 'gallery.manage'],
            ['label' => 'CSR Reports', 'permission' => 'csr_reports.manage'],
            ['label' => 'Certificates', 'permission' => 'certificates.manage'],
            ['label' => 'Enquiries', 'permission' => 'enquiries.manage'],
        ];

        $directorItems = [
            'S-kala Digital Vision',
            'CSR Impact',
            'Women Empowerment Journey',
            'Product Visibility',
            'Future-Ready Documentation',
        ];
    @endphp

    <div class="space-y-6">
        <section class="grid gap-6 xl:grid-cols-[1.5fr_1fr]">
            <div class="overflow-hidden rounded-3xl border border-rose-100 bg-white shadow-xl shadow-rose-100/60">
                <div class="grid gap-6 p-6 sm:p-8 lg:grid-cols-[1.3fr_0.7fr]">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-rose-700">Welcome back</p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-normal text-stone-950">
                            {{ Auth::user()->name }}
                        </h2>
                        <p class="mt-3 max-w-2xl text-base leading-7 text-stone-600">
                            You are signed in as <span class="font-semibold text-rose-900">{{ $roleName }}</span>.
                            This workspace keeps S-kala's training, documentation, and impact story ready for leadership review.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-[#fbf7f0] p-5">
                        <p class="text-sm font-semibold text-stone-500">Leadership</p>
                        <dl class="mt-4 space-y-3 text-sm">
                            <div class="flex justify-between gap-4">
                                <dt class="text-stone-500">Vision</dt>
                                <dd class="font-semibold text-stone-950">Mrs. Pranjali Goyal</dd>
                            </div>
                            <div class="flex justify-between gap-4">
                                <dt class="text-stone-500">Direction</dt>
                                <dd class="font-semibold text-stone-950">Mrs. Rashmi Rekha</dd>
                            </div>
                            <div class="flex justify-between gap-4">
                                <dt class="text-stone-500">Incharge</dt>
                                <dd class="font-semibold text-stone-950">Ms. Neetu Singh</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-6 shadow-xl shadow-amber-100/50">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-200 text-amber-950">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3.75l2.25 5.25 5.25.45-4 3.45 1.2 5.1L12 15.3 7.3 18l1.2-5.1-4-3.45 5.25-.45L12 3.75z" />
                    </svg>
                </div>
                <p class="mt-6 text-sm font-semibold uppercase tracking-[0.2em] text-amber-800">Vision</p>
                <p class="mt-3 text-2xl font-semibold leading-9 text-stone-950">
                    Transforming skills into dignity, confidence, and livelihood.
                </p>
            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-6">
            @foreach ($impactCards as $card)
                <div class="rounded-2xl border border-rose-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-sm font-medium text-stone-500">{{ $card['label'] }}</p>
                        <span class="h-3 w-3 rounded-full {{ $card['accent'] }}"></span>
                    </div>
                    <p class="mt-4 text-3xl font-semibold text-stone-950">{{ $card['value'] }}</p>
                </div>
            @endforeach
        </section>

        <section class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
            <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Quick actions</p>
                        <h3 class="mt-2 text-xl font-semibold text-stone-950">Operational shortcuts</h3>
                    </div>
                </div>

                <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($quickActions as $action)
                        @can($action['permission'])
                            <a href="#"
                                class="group rounded-2xl border border-rose-100 bg-[#fffdf9] p-4 transition hover:-translate-y-0.5 hover:border-rose-200 hover:bg-rose-50">
                                <div class="flex items-center justify-between gap-3">
                                    <span class="text-sm font-semibold text-stone-800 group-hover:text-rose-950">{{ $action['label'] }}</span>
                                    <svg class="h-4 w-4 text-rose-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M7 17L17 7M9 7h8v8" />
                                    </svg>
                                </div>
                            </a>
                        @endcan
                    @endforeach
                </div>
            </div>

            <div class="rounded-3xl border border-stone-200 bg-stone-950 p-6 text-white shadow-xl shadow-stone-300/40">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-amber-200">Director View</p>
                <h3 class="mt-3 text-2xl font-semibold">Presentation panel</h3>
                <div class="mt-6 space-y-3">
                    @foreach ($directorItems as $item)
                        <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                            <span class="h-2.5 w-2.5 rounded-full bg-amber-200"></span>
                            <span class="text-sm font-medium text-stone-100">{{ $item }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</x-admin-layout>
