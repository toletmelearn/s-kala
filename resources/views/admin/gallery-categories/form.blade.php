<form method="POST" action="{{ $action }}" class="grid gap-6 xl:grid-cols-[1fr_0.42fr]">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <section class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <x-input-label for="name" value="Category Name" />
                <x-text-input id="name" name="name" class="mt-2 block w-full" :value="old('name', $category->name)" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="slug" value="Slug" />
                <x-text-input id="slug" name="slug" class="mt-2 block w-full" :value="old('slug', $category->slug)" placeholder="Auto-generated if blank" />
                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="sort_order" value="Sort Order" />
                <x-text-input id="sort_order" type="number" min="0" name="sort_order" class="mt-2 block w-full" :value="old('sort_order', $category->sort_order ?? 0)" required />
                <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
            </div>
            <div class="flex items-end">
                <input type="hidden" name="is_active" value="0">
                <label class="inline-flex items-center gap-3 rounded-2xl border border-rose-100 bg-[#fffdf9] px-4 py-3 text-sm font-semibold text-stone-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-rose-900 shadow-sm focus:ring-rose-500" @checked(old('is_active', $category->is_active ?? true))>
                    Active
                </label>
            </div>
            <div class="md:col-span-2">
                <x-input-label for="description" value="Description" />
                <textarea id="description" name="description" rows="4" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('description', $category->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
        </div>
    </section>

    <aside class="space-y-6">
        <div class="rounded-3xl border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-6 shadow-xl shadow-amber-100/50">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-800">Preview</p>
            <h3 class="mt-4 text-xl font-semibold text-stone-950">{{ $category->name ?: 'Category Name' }}</h3>
            <p class="mt-2 text-sm text-stone-600">{{ $category->description ?: 'Category description for public gallery filter.' }}</p>
        </div>
        <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
            <x-primary-button class="w-full justify-center bg-rose-900 hover:bg-rose-800">
                {{ $submitLabel }}
            </x-primary-button>
            <a href="{{ route('admin.gallery-categories.index') }}" class="mt-3 inline-flex w-full justify-center rounded-md border border-rose-100 px-4 py-2 text-sm font-semibold text-stone-600 hover:bg-rose-50">
                Back
            </a>
        </div>
    </aside>
</form>
