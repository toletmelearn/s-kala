<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="grid gap-6 xl:grid-cols-[1fr_0.42fr]">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <section class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <x-input-label for="section_key" value="Section Key" />
                <x-text-input id="section_key" name="section_key" class="mt-2 block w-full" :value="old('section_key', $section->section_key)" required />
                <x-input-error :messages="$errors->get('section_key')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="sort_order" value="Sort Order" />
                <x-text-input id="sort_order" type="number" min="0" name="sort_order" class="mt-2 block w-full" :value="old('sort_order', $section->sort_order ?? 0)" required />
                <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="title" value="Title" />
                <x-text-input id="title" name="title" class="mt-2 block w-full" :value="old('title', $section->title)" />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="subtitle" value="Subtitle" />
                <x-text-input id="subtitle" name="subtitle" class="mt-2 block w-full" :value="old('subtitle', $section->subtitle)" />
                <x-input-error :messages="$errors->get('subtitle')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="content" value="Content" />
                <textarea id="content" name="content" rows="8" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('content', $section->content) }}</textarea>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="button_text" value="Button Text" />
                <x-text-input id="button_text" name="button_text" class="mt-2 block w-full" :value="old('button_text', $section->button_text)" />
                <x-input-error :messages="$errors->get('button_text')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="button_url" value="Button URL" />
                <x-text-input id="button_url" name="button_url" class="mt-2 block w-full" :value="old('button_url', $section->button_url)" />
                <x-input-error :messages="$errors->get('button_url')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="image" value="Section Image" />
                <input id="image" name="image" type="file" accept="image/*" class="mt-2 block w-full rounded-md border border-gray-300 bg-white text-sm text-stone-600 file:mr-4 file:border-0 file:bg-rose-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-rose-900">
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <input type="hidden" name="is_active" value="0">
                <label class="inline-flex items-center gap-3 rounded-2xl border border-rose-100 bg-[#fffdf9] px-4 py-3 text-sm font-semibold text-stone-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-rose-900 shadow-sm focus:ring-rose-500" @checked(old('is_active', $section->is_active ?? true))>
                    Active on website content plan
                </label>
                <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
            </div>
        </div>
    </section>

    <aside class="space-y-6">
        <div class="rounded-3xl border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-6 shadow-xl shadow-amber-100/50">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-800">Preview</p>
            @if ($section->image)
                <img src="{{ asset($section->image) }}" alt="{{ $section->title }}" class="mt-5 h-40 w-full rounded-2xl object-cover">
            @endif
            <h3 class="mt-5 text-xl font-semibold text-stone-950">{{ $section->title ?: 'Section title' }}</h3>
            <p class="mt-2 text-sm leading-6 text-stone-600">{{ $section->subtitle ?: 'Section subtitle preview' }}</p>
        </div>

        <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
            <x-primary-button class="w-full justify-center bg-rose-900 hover:bg-rose-800">
                {{ $submitLabel }}
            </x-primary-button>
            <a href="{{ route('admin.website.sections.index') }}" class="mt-3 inline-flex w-full justify-center rounded-md border border-rose-100 px-4 py-2 text-sm font-semibold text-stone-600 hover:bg-rose-50">
                Back to Sections
            </a>
        </div>
    </aside>
</form>
