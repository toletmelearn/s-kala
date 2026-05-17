<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    <div class="space-y-6">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="max-w-2xl text-sm leading-6 text-stone-600">Manage hero content, vision, leadership, and future homepage blocks. These records are not exposed publicly until the public website phase is built.</p>
            <a href="{{ route('admin.website.sections.create') }}" class="inline-flex items-center justify-center rounded-xl bg-rose-900 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-rose-900/15">
                Add Section
            </a>
        </div>

        <section class="grid gap-4 lg:grid-cols-2">
            @forelse ($sections as $section)
                <article class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-rose-700">{{ $section->section_key }}</p>
                            <h2 class="mt-2 text-xl font-semibold text-stone-950">{{ $section->title ?? 'Untitled section' }}</h2>
                            <p class="mt-2 text-sm leading-6 text-stone-500">{{ $section->subtitle ?? 'No subtitle added.' }}</p>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $section->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-100 text-stone-500' }}">
                            {{ $section->is_active ? 'Active' : 'Hidden' }}
                        </span>
                    </div>

                    @if ($section->image)
                        <img src="{{ asset($section->image) }}" alt="{{ $section->title }}" class="mt-5 h-40 w-full rounded-2xl object-cover">
                    @endif

                    <p class="mt-5 text-sm leading-6 text-stone-600">{{ Str::limit($section->content ?? 'No content added yet.', 180) }}</p>

                    <div class="mt-5 flex flex-wrap gap-2">
                        <a href="{{ route('admin.website.sections.edit', $section) }}" class="rounded-xl border border-rose-100 px-4 py-2 text-sm font-semibold text-rose-900 hover:bg-rose-50">Edit</a>
                        <form method="POST" action="{{ route('admin.website.sections.destroy', $section) }}" onsubmit="return confirm('Delete this homepage section?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-xl border border-red-100 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Delete</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-rose-200 bg-white p-8 text-sm text-stone-500 lg:col-span-2">
                    No homepage sections yet.
                </div>
            @endforelse
        </section>
    </div>
</x-admin-layout>
