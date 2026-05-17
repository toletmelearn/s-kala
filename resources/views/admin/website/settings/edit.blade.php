<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    <form method="POST" action="{{ route('admin.website.settings.update') }}" enctype="multipart/form-data" class="grid gap-6 xl:grid-cols-[1fr_0.42fr]">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            @if (session('status'))
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            <section class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
                <h2 class="text-xl font-semibold text-stone-950">Core Identity</h2>
                <div class="mt-6 grid gap-5 md:grid-cols-2">
                    <div>
                        <x-input-label for="site_name" value="Website Name" />
                        <x-text-input id="site_name" name="site_name" class="mt-2 block w-full" :value="old('site_name', $settings->site_name)" required />
                        <x-input-error :messages="$errors->get('site_name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="tagline" value="Tagline" />
                        <x-text-input id="tagline" name="tagline" class="mt-2 block w-full" :value="old('tagline', $settings->tagline)" required />
                        <x-input-error :messages="$errors->get('tagline')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" type="email" name="email" class="mt-2 block w-full" :value="old('email', $settings->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="phone" value="Phone" />
                        <x-text-input id="phone" name="phone" class="mt-2 block w-full" :value="old('phone', $settings->phone)" required />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="address" value="Address" />
                        <textarea id="address" name="address" rows="4" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500" required>{{ old('address', $settings->address) }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                </div>
            </section>

            <section class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
                <h2 class="text-xl font-semibold text-stone-950">Social Links & Footer</h2>
                <div class="mt-6 grid gap-5 md:grid-cols-2">
                    <div>
                        <x-input-label for="facebook_url" value="Facebook URL" />
                        <x-text-input id="facebook_url" name="facebook_url" class="mt-2 block w-full" :value="old('facebook_url', $settings->facebook_url)" />
                        <x-input-error :messages="$errors->get('facebook_url')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="instagram_url" value="Instagram URL" />
                        <x-text-input id="instagram_url" name="instagram_url" class="mt-2 block w-full" :value="old('instagram_url', $settings->instagram_url)" />
                        <x-input-error :messages="$errors->get('instagram_url')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="youtube_url" value="YouTube URL" />
                        <x-text-input id="youtube_url" name="youtube_url" class="mt-2 block w-full" :value="old('youtube_url', $settings->youtube_url)" />
                        <x-input-error :messages="$errors->get('youtube_url')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="logo" value="Logo" />
                        <input id="logo" name="logo" type="file" accept="image/*" class="mt-2 block w-full rounded-md border border-gray-300 bg-white text-sm text-stone-600 file:mr-4 file:border-0 file:bg-rose-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-rose-900">
                        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="footer_text" value="Footer Text" />
                        <textarea id="footer_text" name="footer_text" rows="3" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('footer_text', $settings->footer_text) }}</textarea>
                        <x-input-error :messages="$errors->get('footer_text')" class="mt-2" />
                    </div>
                </div>
            </section>
        </div>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-6 shadow-xl shadow-amber-100/50">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-800">Preview</p>
                <div class="mt-5 rounded-2xl bg-white p-5">
                    @if ($settings->logo)
                        <img src="{{ asset($settings->logo) }}" alt="{{ $settings->site_name }}" class="mb-4 h-14 w-auto">
                    @endif
                    <h3 class="text-lg font-semibold text-stone-950">{{ $settings->site_name }}</h3>
                    <p class="mt-2 text-sm text-stone-500">{{ $settings->tagline }}</p>
                    <p class="mt-4 text-xs leading-5 text-stone-500">{{ $settings->address }}</p>
                </div>
            </div>

            <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
                <x-primary-button class="w-full justify-center bg-rose-900 hover:bg-rose-800">
                    Save Website Settings
                </x-primary-button>
                <a href="{{ route('admin.website.index') }}" class="mt-3 inline-flex w-full justify-center rounded-md border border-rose-100 px-4 py-2 text-sm font-semibold text-stone-600 hover:bg-rose-50">
                    Back to CMS
                </a>
            </div>
        </aside>
    </form>
</x-admin-layout>
