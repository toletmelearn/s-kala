<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    <div class="space-y-6">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="max-w-2xl text-sm leading-6 text-stone-600">Manage skill programs that move women from practice to confidence and livelihood readiness.</p>
            <a href="{{ route('admin.training-programs.create') }}" class="inline-flex items-center justify-center rounded-xl bg-rose-900 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-rose-900/15">
                Add Program
            </a>
        </div>

        <section class="grid gap-4 lg:grid-cols-2">
            @forelse ($programs as $program)
                @php
                    $imageExists = $program->image && file_exists(public_path($program->image));
                @endphp
                <article class="overflow-hidden rounded-3xl border border-rose-100 bg-white shadow-xl shadow-rose-100/40">
                    <div class="grid gap-0 sm:grid-cols-[15rem_1fr]">
                        <div class="bg-[#fbf7f0]">
                            @if ($imageExists)
                                <img src="{{ asset($program->image) }}" alt="{{ $program->name }}" class="h-full min-h-64 w-full object-cover">
                            @else
                                <div class="flex h-full min-h-64 items-center justify-center p-6">
                                    <div class="rounded-3xl bg-white p-6 text-center">
                                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">S-kala</p>
                                        <p class="mt-3 text-xl font-bold text-stone-950">{{ $program->name }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="flex flex-wrap gap-2">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $program->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-100 text-stone-500' }}">
                                    {{ $program->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if ($program->is_featured)
                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-900">Featured</span>
                                @endif
                            </div>
                            <h2 class="mt-4 text-xl font-semibold text-stone-950">{{ $program->name }}</h2>
                            <p class="mt-2 text-sm leading-6 text-stone-500">{{ $program->short_description ?: 'No short description added.' }}</p>

                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach ($program->trainers as $trainer)
                                    <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-900">{{ $trainer->name }}</span>
                                @endforeach
                            </div>

                            <div class="mt-5 flex flex-wrap gap-2">
                                <a href="{{ route('admin.training-programs.edit', $program) }}" class="rounded-xl border border-rose-100 px-4 py-2 text-sm font-semibold text-rose-900 hover:bg-rose-50">Edit</a>
                                <form method="POST" action="{{ route('admin.training-programs.toggle-status', $program) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded-xl border border-stone-200 px-4 py-2 text-sm font-semibold text-stone-700 hover:bg-stone-50">Toggle Status</button>
                                </form>
                                <form method="POST" action="{{ route('admin.training-programs.toggle-featured', $program) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded-xl border border-amber-100 px-4 py-2 text-sm font-semibold text-amber-800 hover:bg-amber-50">Toggle Featured</button>
                                </form>
                                <form method="POST" action="{{ route('admin.training-programs.destroy', $program) }}" onsubmit="return confirm('Delete this training program?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-xl border border-red-100 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-rose-200 bg-white p-8 text-sm text-stone-500 lg:col-span-2">
                    No training programs yet.
                </div>
            @endforelse
        </section>

        {{ $programs->links() }}
    </div>
</x-admin-layout>
