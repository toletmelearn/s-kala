<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @php
        $typeOptions = ['image', 'transformation', 'training', 'product', 'event'];
    @endphp

    <div class="space-y-6">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <form method="GET" action="{{ route('admin.gallery.index') }}" class="rounded-3xl border border-rose-100 bg-white p-5 shadow-sm">
            <div class="grid gap-3 md:grid-cols-5">
                <select name="category" class="rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) $filters['category'] === (string) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <select name="type" class="rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    <option value="">All types</option>
                    @foreach ($typeOptions as $type)
                        <option value="{{ $type }}" @selected($filters['type'] === $type)>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
                <select name="active" class="rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    <option value="">Any active state</option>
                    <option value="1" @selected((string) $filters['active'] === '1')>Active</option>
                    <option value="0" @selected((string) $filters['active'] === '0')>Inactive</option>
                </select>
                <select name="featured" class="rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    <option value="">Any featured state</option>
                    <option value="1" @selected((string) $filters['featured'] === '1')>Featured</option>
                    <option value="0" @selected((string) $filters['featured'] === '0')>Not Featured</option>
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="w-full rounded-xl bg-rose-900 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-800">Filter</button>
                    <a href="{{ route('admin.gallery.index') }}" class="rounded-xl border border-rose-100 px-4 py-2 text-sm font-semibold text-stone-600 hover:bg-rose-50">Reset</a>
                </div>
            </div>
        </form>

        <div class="flex justify-end">
            <a href="{{ route('admin.gallery.create') }}" class="inline-flex rounded-xl bg-rose-900 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-rose-900/15 hover:bg-rose-800">
                Add Gallery Item
            </a>
        </div>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @forelse ($items as $item)
                @php
                    $imageExists = $item->image && file_exists(public_path($item->image));
                @endphp
                <article class="overflow-hidden rounded-3xl border border-rose-100 bg-white shadow-xl shadow-rose-100/40">
                    @if ($imageExists)
                        <img src="{{ asset($item->image) }}" alt="{{ $item->alt_text ?: $item->title }}" class="h-52 w-full object-cover">
                    @else
                        <div class="flex h-52 items-center justify-center bg-[#fbf7f0] p-4 text-center text-sm font-semibold text-stone-500">No image uploaded</div>
                    @endif
                    <div class="p-5">
                        <div class="flex flex-wrap gap-2">
                            <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-900">{{ ucfirst($item->type) }}</span>
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $item->is_active ? 'bg-emerald-100 text-emerald-900' : 'bg-stone-100 text-stone-600' }}">{{ $item->is_active ? 'Active' : 'Inactive' }}</span>
                            @if ($item->is_featured)
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-900">Featured</span>
                            @endif
                        </div>
                        <h3 class="mt-3 text-base font-semibold text-stone-950">{{ $item->title }}</h3>
                        <p class="mt-2 text-sm text-stone-600">{{ $item->caption ?: '-' }}</p>
                        <p class="mt-2 text-xs text-stone-500">{{ $item->category?->name ?: 'Uncategorized' }} @if($item->taken_on) • {{ $item->taken_on->format('d M Y') }} @endif</p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="{{ route('admin.gallery.edit', $item) }}" class="rounded-xl border border-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-900 hover:bg-rose-50">Edit</a>
                            <form method="POST" action="{{ route('admin.gallery.toggle-status', $item) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="rounded-xl border border-stone-200 px-3 py-1.5 text-xs font-semibold text-stone-700 hover:bg-stone-50">Toggle</button>
                            </form>
                            <form method="POST" action="{{ route('admin.gallery.toggle-featured', $item) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="rounded-xl border border-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-800 hover:bg-amber-50">Feature</button>
                            </form>
                            <form method="POST" action="{{ route('admin.gallery.destroy', $item) }}" onsubmit="return confirm('Delete this gallery item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-xl border border-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50">Delete</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-rose-200 bg-white p-8 text-sm text-stone-500 sm:col-span-2 xl:col-span-4">
                    No gallery items yet.
                </div>
            @endforelse
        </section>

        {{ $items->links() }}
    </div>
</x-admin-layout>
