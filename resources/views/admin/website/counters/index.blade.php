<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    <div class="space-y-6">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="max-w-2xl text-sm leading-6 text-stone-600">Prepare public-facing impact statistics for CSR visibility and leadership presentations.</p>
            <a href="{{ route('admin.website.counters.create') }}" class="inline-flex items-center justify-center rounded-xl bg-rose-900 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-rose-900/15">
                Add Counter
            </a>
        </div>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @forelse ($counters as $counter)
                <article class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                    <div class="flex items-center justify-between gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-rose-50 text-sm font-semibold text-rose-900">{{ $counter->icon ?: 'Sk' }}</span>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $counter->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-100 text-stone-500' }}">
                            {{ $counter->is_active ? 'Active' : 'Hidden' }}
                        </span>
                    </div>
                    <p class="mt-5 text-3xl font-semibold text-stone-950">{{ $counter->value }}{{ $counter->suffix }}</p>
                    <h2 class="mt-2 text-sm font-semibold text-stone-800">{{ $counter->label }}</h2>
                    <p class="mt-3 text-sm leading-6 text-stone-500">{{ $counter->description ?: 'No description added.' }}</p>
                    <div class="mt-5 flex flex-wrap gap-2">
                        <a href="{{ route('admin.website.counters.edit', $counter) }}" class="rounded-xl border border-rose-100 px-4 py-2 text-sm font-semibold text-rose-900 hover:bg-rose-50">Edit</a>
                        <form method="POST" action="{{ route('admin.website.counters.destroy', $counter) }}" onsubmit="return confirm('Delete this impact counter?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-xl border border-red-100 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Delete</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-rose-200 bg-white p-8 text-sm text-stone-500 sm:col-span-2 xl:col-span-4">
                    No impact counters yet.
                </div>
            @endforelse
        </section>
    </div>
</x-admin-layout>
