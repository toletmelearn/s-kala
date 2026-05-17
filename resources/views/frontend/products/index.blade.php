@extends('layouts.frontend', [
    'title' => 'Made at S-kala',
    'settings' => $settings,
])

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="max-w-4xl">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Made at S-kala</p>
                <h1 class="mt-4 text-4xl font-bold tracking-normal text-stone-950 sm:text-5xl">Handmade products created through skill, confidence, and care.</h1>
                <p class="mt-5 max-w-3xl text-base leading-8 text-stone-600">A showcase of women-made work shaped through practical training, creativity, and livelihood-focused craft development.</p>
            </div>
        </div>
    </section>

    <section class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('products.index') }}" class="rounded-full px-4 py-2 text-sm font-semibold {{ $activeCategory ? 'border border-rose-100 bg-white text-stone-700' : 'bg-rose-900 text-white' }}">All</a>
                @foreach ($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="rounded-full px-4 py-2 text-sm font-semibold {{ $activeCategory?->id === $category->id ? 'bg-rose-900 text-white' : 'border border-rose-100 bg-white text-stone-700 hover:bg-rose-50' }}">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="pb-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-stone-950">Featured Products</h2>
            <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($featuredProducts as $product)
                    @php
                        $imageExists = $product->image && file_exists(public_path($product->image));
                    @endphp
                    <article class="overflow-hidden rounded-[2rem] border border-rose-100 bg-white shadow-xl shadow-rose-100/40">
                        @if ($imageExists)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-60 w-full object-cover">
                        @else
                            <div class="flex h-60 items-center justify-center bg-[#fbf7f0] text-sm font-semibold text-stone-500">No image uploaded</div>
                        @endif
                        <div class="p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-rose-700">{{ $product->category?->name ?: 'Made at S-kala' }}</p>
                            <h3 class="mt-2 text-lg font-semibold text-stone-950">{{ $product->name }}</h3>
                            <p class="mt-2 text-sm text-stone-600">{{ $product->short_description ?: '-' }}</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <a href="{{ route('products.show', $product->slug) }}" class="rounded-full bg-rose-900 px-4 py-2 text-xs font-semibold text-white hover:bg-rose-800">View Details</a>
                                <a href="{{ route('products.show', $product->slug) }}#enquiry-form" class="rounded-full border border-rose-200 px-4 py-2 text-xs font-semibold text-rose-900 hover:bg-rose-50">Enquire</a>
                            </div>
                        </div>
                    </article>
                @empty
                    @foreach (['Embroidered Bag', 'Handmade Craft Item', 'Stitched Garment'] as $fallback)
                        <article class="rounded-[2rem] border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-rose-700">Made at S-kala</p>
                            <h3 class="mt-2 text-lg font-semibold text-stone-950">{{ $fallback }}</h3>
                            <p class="mt-2 text-sm text-stone-600">Featured products will appear here once published from admin.</p>
                        </article>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-stone-950">Product Catalogue</h2>
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($products as $product)
                    @php
                        $imageExists = $product->image && file_exists(public_path($product->image));
                    @endphp
                    <article class="overflow-hidden rounded-3xl border border-rose-100 bg-white shadow-sm">
                        @if ($imageExists)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-44 w-full object-cover">
                        @else
                            <div class="flex h-44 items-center justify-center bg-[#fbf7f0] text-sm font-semibold text-stone-500">No image</div>
                        @endif
                        <div class="p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-rose-700">{{ $product->category?->name ?: 'Made at S-kala' }}</p>
                            <h3 class="mt-2 text-sm font-semibold text-stone-900">{{ $product->name }}</h3>
                            <p class="mt-1 text-xs text-stone-600">{{ $product->skill_used ?: 'Skill details coming soon' }}</p>
                            @if (!is_null($product->price))
                                <p class="mt-2 text-sm font-semibold text-stone-900">INR {{ number_format((float) $product->price, 2) }}</p>
                            @endif
                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('products.show', $product->slug) }}" class="rounded-full bg-rose-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-rose-800">View Details</a>
                                <a href="{{ route('products.show', $product->slug) }}#enquiry-form" class="rounded-full border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-900 hover:bg-rose-50">Enquire</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-rose-200 bg-white p-8 text-sm text-stone-500 sm:col-span-2 lg:col-span-3 xl:col-span-4">Products will appear here once published.</div>
                @endforelse
            </div>
            <div class="mt-6">{{ $products->links() }}</div>
        </div>
    </section>
@endsection
