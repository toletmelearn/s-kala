<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="grid gap-6 xl:grid-cols-[1fr_0.42fr]">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <section class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <x-input-label for="title" value="Title" />
                <x-text-input id="title" name="title" class="mt-2 block w-full" :value="old('title', $item->title)" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="slug" value="Slug" />
                <x-text-input id="slug" name="slug" class="mt-2 block w-full" :value="old('slug', $item->slug)" placeholder="Auto-generated if blank" />
                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="gallery_category_id" value="Category" />
                <select id="gallery_category_id" name="gallery_category_id" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    <option value="">No category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((int) old('gallery_category_id', $item->gallery_category_id) === $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('gallery_category_id')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="type" value="Type" />
                <select id="type" name="type" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500" required>
                    @foreach ($types as $type)
                        <option value="{{ $type }}" @selected(old('type', $item->type) === $type)>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('type')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="sort_order" value="Sort Order" />
                <x-text-input id="sort_order" type="number" min="0" name="sort_order" class="mt-2 block w-full" :value="old('sort_order', $item->sort_order ?? 0)" required />
                <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="taken_on" value="Taken On" />
                <x-text-input id="taken_on" type="date" name="taken_on" class="mt-2 block w-full" :value="old('taken_on', $item->taken_on?->format('Y-m-d'))" />
                <x-input-error :messages="$errors->get('taken_on')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="caption" value="Caption" />
                <x-text-input id="caption" name="caption" class="mt-2 block w-full" :value="old('caption', $item->caption)" />
                <x-input-error :messages="$errors->get('caption')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="alt_text" value="Alt Text" />
                <x-text-input id="alt_text" name="alt_text" class="mt-2 block w-full" :value="old('alt_text', $item->alt_text)" />
                <x-input-error :messages="$errors->get('alt_text')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="image" value="Image" />
                <input id="image" name="image" type="file" accept="image/*" class="mt-2 block w-full rounded-md border border-gray-300 bg-white text-sm text-stone-600 file:mr-4 file:border-0 file:bg-rose-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-rose-900">
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>
            <div class="md:col-span-2 flex flex-wrap gap-3">
                <input type="hidden" name="is_active" value="0">
                <label class="inline-flex items-center gap-3 rounded-2xl border border-rose-100 bg-[#fffdf9] px-4 py-3 text-sm font-semibold text-stone-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-rose-900 shadow-sm focus:ring-rose-500" @checked(old('is_active', $item->is_active ?? true))>
                    Active
                </label>
                <input type="hidden" name="is_featured" value="0">
                <label class="inline-flex items-center gap-3 rounded-2xl border border-amber-100 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-900">
                    <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-rose-900 shadow-sm focus:ring-rose-500" @checked(old('is_featured', $item->is_featured ?? false))>
                    Featured
                </label>
            </div>
        </div>
    </section>

    <aside class="space-y-6">
        <div class="rounded-3xl border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-6 shadow-xl shadow-amber-100/50">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-800">Preview</p>
            @if ($item->image && file_exists(public_path($item->image)))
                <img src="{{ asset($item->image) }}" alt="{{ $item->alt_text ?: $item->title }}" class="mt-5 h-40 w-full rounded-2xl object-cover">
            @endif
            <h3 class="mt-5 text-xl font-semibold text-stone-950">{{ $item->title ?: 'Gallery title' }}</h3>
            <p class="mt-2 text-sm text-stone-600">{{ $item->caption ?: 'Caption goes here.' }}</p>
        </div>
        <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
            <x-primary-button class="w-full justify-center bg-rose-900 hover:bg-rose-800">
                {{ $submitLabel }}
            </x-primary-button>
            <a href="{{ route('admin.gallery.index') }}" class="mt-3 inline-flex w-full justify-center rounded-md border border-rose-100 px-4 py-2 text-sm font-semibold text-stone-600 hover:bg-rose-50">
                Back
            </a>
        </div>
    </aside>
</form>
