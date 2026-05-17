@extends('layouts.frontend', [
    'title' => 'Connect with S-kala',
    'settings' => $settings,
])

@section('content')
    <section class="bg-white py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Contact</p>
            <h1 class="mt-3 text-4xl font-bold text-stone-950 sm:text-5xl">Connect with S-kala</h1>
            <p class="mt-4 max-w-3xl text-base leading-8 text-stone-600">
                For training, collaboration, CSR partnership, volunteering, and product visibility.
            </p>
        </div>
    </section>

    <section class="pb-16">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[1fr_0.9fr] lg:px-8">
            <div class="rounded-[2rem] border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40 sm:p-8">
                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="type" class="mb-1.5 block text-sm font-semibold text-stone-700">Enquiry Type</label>
                        <select id="type" name="type" class="w-full rounded-xl border border-rose-100 bg-white px-4 py-3 text-sm text-stone-700 focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100">
                            @foreach ($enquiryTypes as $value => $label)
                                <option value="{{ $value }}" @selected(old('type', 'general') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type') <p class="mt-1 text-sm text-rose-700">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="mb-1.5 block text-sm font-semibold text-stone-700">Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm text-stone-700 focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100">
                            @error('name') <p class="mt-1 text-sm text-rose-700">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="organization" class="mb-1.5 block text-sm font-semibold text-stone-700">Organization (optional)</label>
                            <input id="organization" name="organization" type="text" value="{{ old('organization') }}" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm text-stone-700 focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100">
                            @error('organization') <p class="mt-1 text-sm text-rose-700">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="phone" class="mb-1.5 block text-sm font-semibold text-stone-700">Phone</label>
                            <input id="phone" name="phone" type="text" value="{{ old('phone') }}" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm text-stone-700 focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100">
                            @error('phone') <p class="mt-1 text-sm text-rose-700">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-semibold text-stone-700">Email (optional)</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm text-stone-700 focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100">
                            @error('email') <p class="mt-1 text-sm text-rose-700">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="subject" class="mb-1.5 block text-sm font-semibold text-stone-700">Subject (optional)</label>
                            <input id="subject" name="subject" type="text" value="{{ old('subject') }}" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm text-stone-700 focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100">
                            @error('subject') <p class="mt-1 text-sm text-rose-700">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="preferred_contact_method" class="mb-1.5 block text-sm font-semibold text-stone-700">Preferred Contact Method</label>
                            <input id="preferred_contact_method" name="preferred_contact_method" type="text" value="{{ old('preferred_contact_method') }}" placeholder="Phone / Email / WhatsApp" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm text-stone-700 focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100">
                            @error('preferred_contact_method') <p class="mt-1 text-sm text-rose-700">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="message" class="mb-1.5 block text-sm font-semibold text-stone-700">Message</label>
                        <textarea id="message" name="message" rows="5" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm text-stone-700 focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100">{{ old('message') }}</textarea>
                        @error('message') <p class="mt-1 text-sm text-rose-700">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="inline-flex rounded-full bg-rose-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-rose-900/20 hover:bg-rose-800">
                        Submit Enquiry
                    </button>
                </form>
            </div>

            <div class="space-y-6">
                <article class="rounded-[2rem] border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Contact Information</p>
                    <div class="mt-4 space-y-3 text-sm text-stone-700">
                        <p><span class="font-semibold text-stone-900">Phone:</span> {{ $settings?->phone ?? '+91 00000 00000' }}</p>
                        <p><span class="font-semibold text-stone-900">Email:</span> {{ $settings?->email ?? 'info@skala.test' }}</p>
                        <p><span class="font-semibold text-stone-900">Address:</span> {{ $settings?->address ?? 'Dhampur, Uttar Pradesh' }}</p>
                    </div>
                    <div class="mt-5 flex flex-wrap gap-2">
                        @if ($settings?->facebook_url)
                            <a href="{{ $settings->facebook_url }}" class="rounded-full border border-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-900 hover:bg-rose-50">Facebook</a>
                        @endif
                        @if ($settings?->instagram_url)
                            <a href="{{ $settings->instagram_url }}" class="rounded-full border border-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-900 hover:bg-rose-50">Instagram</a>
                        @endif
                        @if ($settings?->youtube_url)
                            <a href="{{ $settings->youtube_url }}" class="rounded-full border border-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-900 hover:bg-rose-50">YouTube</a>
                        @endif
                    </div>
                </article>

                <article class="rounded-[2rem] border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-6 shadow-xl shadow-amber-100/40">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-800">Quick Access</p>
                    <div class="mt-4 space-y-3">
                        <a href="{{ route('join.create') }}" class="block rounded-xl bg-white px-4 py-3 text-sm font-semibold text-stone-900 shadow-sm hover:bg-rose-50">Join as Trainee</a>
                        <a href="{{ route('products.index') }}" class="block rounded-xl bg-white px-4 py-3 text-sm font-semibold text-stone-900 shadow-sm hover:bg-rose-50">Explore Products</a>
                        <a href="{{ route('gallery.index') }}" class="block rounded-xl bg-white px-4 py-3 text-sm font-semibold text-stone-900 shadow-sm hover:bg-rose-50">View Gallery</a>
                        <a href="{{ url('/#vision') }}" class="block rounded-xl bg-white px-4 py-3 text-sm font-semibold text-stone-900 shadow-sm hover:bg-rose-50">CSR Digital Vision</a>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection
