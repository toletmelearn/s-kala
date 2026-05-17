<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    <div class="space-y-6">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="max-w-2xl text-sm leading-6 text-stone-600">Manage trainers and their program assignments with a clean public-ready profile foundation.</p>
            <a href="{{ route('admin.trainers.create') }}" class="inline-flex items-center justify-center rounded-xl bg-rose-900 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-rose-900/15">
                Add Trainer
            </a>
        </div>

        <section class="grid gap-4 lg:grid-cols-2">
            @forelse ($trainers as $trainer)
                <article class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                    <div class="flex gap-5">
                        @if ($trainer->photo && file_exists(public_path($trainer->photo)))
                            <img src="{{ asset($trainer->photo) }}" alt="{{ $trainer->name }}" class="h-24 w-24 rounded-3xl object-cover">
                        @else
                            <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-3xl bg-rose-100 text-lg font-bold text-rose-900">
                                {{ Str::of($trainer->name)->substr(0, 2)->upper() }}
                            </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap gap-2">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $trainer->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-100 text-stone-500' }}">
                                    {{ $trainer->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <h2 class="mt-3 text-xl font-semibold text-stone-950">{{ $trainer->name }}</h2>
                            <p class="mt-1 text-sm font-semibold text-rose-900">{{ $trainer->specialization ?: $trainer->designation }}</p>
                            <p class="mt-3 text-sm leading-6 text-stone-500">{{ Str::limit($trainer->bio ?: 'No trainer bio added yet.', 130) }}</p>
                        </div>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-2">
                        @foreach ($trainer->trainingPrograms as $program)
                            <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-900">{{ $program->name }}</span>
                        @endforeach
                    </div>

                    <div class="mt-5 flex flex-wrap gap-2">
                        <a href="{{ route('admin.trainers.edit', $trainer) }}" class="rounded-xl border border-rose-100 px-4 py-2 text-sm font-semibold text-rose-900 hover:bg-rose-50">Edit</a>
                        <form method="POST" action="{{ route('admin.trainers.toggle-status', $trainer) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="rounded-xl border border-stone-200 px-4 py-2 text-sm font-semibold text-stone-700 hover:bg-stone-50">Toggle Status</button>
                        </form>
                        <form method="POST" action="{{ route('admin.trainers.destroy', $trainer) }}" onsubmit="return confirm('Delete this trainer?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-xl border border-red-100 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Delete</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-rose-200 bg-white p-8 text-sm text-stone-500 lg:col-span-2">
                    No trainers yet.
                </div>
            @endforelse
        </section>

        {{ $trainers->links() }}
    </div>
</x-admin-layout>
