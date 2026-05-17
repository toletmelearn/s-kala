@extends('layouts.frontend', [
    'title' => $product->name,
    'settings' => $settings,
])

@section('content')
    @php
        $imageExists = $product->image && file_exists(public_path($product->image));
    @endphp

    <section class="bg-white py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-rose-800 hover:text-rose-900">Back to Products</a>
            <div class="mt-4 grid gap-8 rounded-[2rem] border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40 lg:grid-cols-[0.9fr_1.1fr]">
                <div>
                    @if ($imageExists)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-96 w-full rounded-3xl object-cover">
                    @else
                        <div class="flex h-96 items-center justify-center rounded-3xl bg-[#fbf7f0] text-sm font-semibold text-stone-500">No image uploaded</div>
                    @endif
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-rose-700">{{ $product->category?->name ?: 'Made at S-kala' }}</p>
                    <h1 class="mt-2 text-4xl font-bold text-stone-950">{{ $product->name }}</h1>
                    <p class="mt-4 text-base leading-8 text-stone-700">{{ $product->description ?: $product->short_description ?: 'Product details will be updated soon.' }}</p>
                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl bg-[#fbf7f0] p-4 text-sm"><span class="font-semibold text-stone-900">Material:</span> {{ $product->material ?: '-' }}</div>
                        <div class="rounded-2xl bg-[#fbf7f0] p-4 text-sm"><span class="font-semibold text-stone-900">Size:</span> {{ $product->size ?: '-' }}</div>
                        <div class="rounded-2xl bg-[#fbf7f0] p-4 text-sm"><span class="font-semibold text-stone-900">Color:</span> {{ $product->color ?: '-' }}</div>
                        <div class="rounded-2xl bg-[#fbf7f0] p-4 text-sm"><span class="font-semibold text-stone-900">Skill Used:</span> {{ $product->skill_used ?: '-' }}</div>
                        <div class="rounded-2xl bg-[#fbf7f0] p-4 text-sm"><span class="font-semibold text-stone-900">Made By:</span> {{ $product->made_by ?: '-' }}</div>
                        <div class="rounded-2xl bg-[#fbf7f0] p-4 text-sm"><span class="font-semibold text-stone-900">Price:</span> {{ is_null($product->price) ? '-' : 'INR '.number_format((float) $product->price, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="enquiry-form" class="py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-[2rem] border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40 sm:p-8">
                <h2 class="text-2xl font-bold text-stone-950">Enquire About This Product</h2>
                @if (session('success'))
                    <div class="mt-4 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('products.enquiry', $product->slug) }}" class="mt-6 grid gap-4 md:grid-cols-2">
                    @csrf
                    <div>
                        <x-input-label for="name" value="Name" />
                        <x-text-input id="name" name="name" class="mt-2 block w-full" :value="old('name')" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="phone" value="Phone" />
                        <x-text-input id="phone" name="phone" class="mt-2 block w-full" :value="old('phone')" required />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" type="email" name="email" class="mt-2 block w-full" :value="old('email')" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="message" value="Message" />
                        <textarea id="message" name="message" rows="4" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('message') }}</textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                    </div>
                    <div class="md:col-span-2">
                        <x-primary-button class="bg-rose-900 px-6 py-3 hover:bg-rose-800">Submit Enquiry</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @if ($relatedProducts->isNotEmpty())
        <section class="pb-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-stone-950">Related Products</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($relatedProducts as $related)
                        <article class="rounded-3xl border border-rose-100 bg-white p-5 shadow-sm">
                            <h3 class="text-sm font-semibold text-stone-900">{{ $related->name }}</h3>
                            <p class="mt-2 text-xs text-stone-600">{{ $related->short_description ?: '-' }}</p>
                            <a href="{{ route('products.show', $related->slug) }}" class="mt-3 inline-flex rounded-full bg-rose-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-rose-800">View</a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
