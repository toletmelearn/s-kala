@extends('layouts.frontend', [
    'title' => 'Gallery',
    'settings' => $settings,
])

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="max-w-4xl">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Gallery</p>
                <h1 class="mt-4 text-4xl font-bold tracking-normal text-stone-950 sm:text-5xl">Moments of transformation, skill, and shared progress.</h1>
                <p class="mt-5 max-w-3xl text-base leading-8 text-stone-600">A visual story of training, confidence, community learning, and the evolving impact of S-kala.</p>
            </div>
        </div>
    </section>

    <section class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('gallery.index') }}" class="rounded-full px-4 py-2 text-sm font-semibold {{ $activeCategory ? 'bg-white text-stone-700 border border-rose-100' : 'bg-rose-900 text-white' }}">
                    All
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('gallery.index', ['category' => $category->slug]) }}" class="rounded-full px-4 py-2 text-sm font-semibold {{ $activeCategory?->id === $category->id ? 'bg-rose-900 text-white' : 'border border-rose-100 bg-white text-stone-700 hover:bg-rose-50' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="pb-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-stone-950">Featured Gallery</h2>
            <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($featuredItems as $item)
                    @php
                        $imageExists = $item->image && file_exists(public_path($item->image));
                    @endphp
                    <article class="overflow-hidden rounded-[2rem] border border-rose-100 bg-white shadow-xl shadow-rose-100/40">
                        @if ($imageExists)
                            <img src="{{ asset($item->image) }}" alt="{{ $item->alt_text ?: $item->title }}" class="h-60 w-full object-cover">
                        @else
                            <div class="flex h-60 items-center justify-center bg-[#fbf7f0] text-sm font-semibold text-stone-500">No image uploaded</div>
                        @endif
                        <div class="p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-rose-700">{{ $item->category?->name ?: ucfirst($item->type) }}</p>
                            <h3 class="mt-2 text-lg font-semibold text-stone-950">{{ $item->title }}</h3>
                            @if ($item->caption)
                                <p class="mt-2 text-sm text-stone-600">{{ $item->caption }}</p>
                            @endif
                            @if ($item->taken_on)
                                <p class="mt-2 text-xs text-stone-500">{{ $item->taken_on->format('d M Y') }}</p>
                            @endif
                        </div>
                    </article>
                @empty
                    @foreach (['Training Highlights', 'Transformation Journey', 'Community Moments'] as $fallback)
                        <article class="rounded-[2rem] border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-rose-700">S-kala Gallery</p>
                            <h3 class="mt-3 text-lg font-semibold text-stone-950">{{ $fallback }}</h3>
                            <p class="mt-2 text-sm text-stone-600">Featured visuals will appear here once gallery images are added.</p>
                        </article>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-stone-950">All Gallery Items</h2>
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($items as $item)
                    @php
                        $imageExists = $item->image && file_exists(public_path($item->image));
                    @endphp
                    <article class="overflow-hidden rounded-3xl border border-rose-100 bg-white shadow-sm">
                        @if ($imageExists)
                            <img src="{{ asset($item->image) }}" alt="{{ $item->alt_text ?: $item->title }}" class="h-44 w-full object-cover">
                        @else
                            <div class="flex h-44 items-center justify-center bg-[#fbf7f0] text-sm font-semibold text-stone-500">No image</div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-sm font-semibold text-stone-900">{{ $item->title }}</h3>
                            @if ($item->caption)
                                <p class="mt-1 text-xs text-stone-600">{{ $item->caption }}</p>
                            @endif
                            @if ($item->taken_on)
                                <p class="mt-2 text-xs text-stone-500">{{ $item->taken_on->format('d M Y') }}</p>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-rose-200 bg-white p-8 text-sm text-stone-500 sm:col-span-2 lg:col-span-3 xl:col-span-4">
                        Gallery will appear here once images are published.
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $items->links() }}
            </div>
        </div>
    </section>
@endsection
