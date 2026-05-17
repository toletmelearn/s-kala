<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    <div class="space-y-6">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <section class="grid gap-6 xl:grid-cols-[1.35fr_0.65fr]">
            <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">CMS Foundation</p>
                <h2 class="mt-3 text-2xl font-semibold text-stone-950">{{ $settings?->site_name ?? 'S-kala Website' }}</h2>
                <p class="mt-3 max-w-3xl text-sm leading-6 text-stone-600">
                    Manage the public website identity, homepage story blocks, hero content, leadership messaging, and impact counters from one clean workspace.
                </p>

                <div class="mt-6 grid gap-3 sm:grid-cols-3">
                    <a href="{{ route('admin.website.settings.edit') }}" class="rounded-2xl border border-rose-100 bg-[#fffdf9] p-4 transition hover:border-rose-200 hover:bg-rose-50">
                        <p class="text-sm font-semibold text-stone-950">Website Settings</p>
                        <p class="mt-2 text-xs leading-5 text-stone-500">Name, contact, social links, logo, footer.</p>
                    </a>
                    <a href="{{ route('admin.website.sections.index') }}" class="rounded-2xl border border-rose-100 bg-[#fffdf9] p-4 transition hover:border-rose-200 hover:bg-rose-50">
                        <p class="text-sm font-semibold text-stone-950">Homepage Sections</p>
                        <p class="mt-2 text-xs leading-5 text-stone-500">Hero, vision, leadership, and page blocks.</p>
                    </a>
                    <a href="{{ route('admin.website.counters.index') }}" class="rounded-2xl border border-rose-100 bg-[#fffdf9] p-4 transition hover:border-rose-200 hover:bg-rose-50">
                        <p class="text-sm font-semibold text-stone-950">Impact Counters</p>
                        <p class="mt-2 text-xs leading-5 text-stone-500">Visible statistics for CSR and impact review.</p>
                    </a>
                </div>
            </div>

            <div class="rounded-3xl border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-6 shadow-xl shadow-amber-100/50">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-800">Hero Preview</p>
                <h3 class="mt-4 text-2xl font-semibold leading-8 text-stone-950">
                    {{ $heroSection?->title ?? 'A livelihood-centered ecosystem for women.' }}
                </h3>
                <p class="mt-3 text-sm leading-6 text-stone-600">
                    {{ $heroSection?->subtitle ?? 'Training, enterprise readiness, and community confidence.' }}
                </p>
                <div class="mt-5 rounded-2xl bg-white/75 p-4 text-xs leading-5 text-stone-500">
                    {{ Str::limit($heroSection?->content ?? 'S-kala supports women with practical skill-building, mentorship, product visibility, and transparent CSR impact documentation.', 180) }}
                </div>
            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-rose-100 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-stone-500">Homepage Sections</p>
                <p class="mt-3 text-3xl font-semibold text-stone-950">{{ $sections->count() }}</p>
            </div>
            <div class="rounded-2xl border border-rose-100 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-stone-500">Active Sections</p>
                <p class="mt-3 text-3xl font-semibold text-stone-950">{{ $sections->where('is_active', true)->count() }}</p>
            </div>
            <div class="rounded-2xl border border-rose-100 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-stone-500">Impact Counters</p>
                <p class="mt-3 text-3xl font-semibold text-stone-950">{{ $impactCounters->count() }}</p>
            </div>
            <div class="rounded-2xl border border-rose-100 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-stone-500">Active Counters</p>
                <p class="mt-3 text-3xl font-semibold text-stone-950">{{ $impactCounters->where('is_active', true)->count() }}</p>
            </div>
        </section>

        <section class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Preview Cards</p>
                    <h3 class="mt-2 text-xl font-semibold text-stone-950">Homepage content blocks</h3>
                </div>
                <a href="{{ route('admin.website.sections.create') }}" class="inline-flex items-center justify-center rounded-xl bg-rose-900 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-rose-900/15">
                    Add Section
                </a>
            </div>

            <div class="mt-6 grid gap-4 lg:grid-cols-3">
                @forelse ($sections as $section)
                    <article class="rounded-2xl border border-rose-100 bg-[#fffdf9] p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-rose-700">{{ $section->section_key }}</p>
                                <h4 class="mt-2 text-base font-semibold text-stone-950">{{ $section->title ?? 'Untitled section' }}</h4>
                            </div>
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $section->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-100 text-stone-500' }}">
                                {{ $section->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-stone-500">{{ Str::limit($section->subtitle ?? $section->content ?? 'No preview content yet.', 110) }}</p>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-rose-200 p-6 text-sm text-stone-500 lg:col-span-3">
                        No homepage sections have been created yet.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-admin-layout>
