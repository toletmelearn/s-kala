<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="grid gap-6 xl:grid-cols-[1fr_0.42fr]">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif
    <section class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
        <div class="grid gap-5 md:grid-cols-2">
            <div><x-input-label for="name" value="Name" /><x-text-input id="name" name="name" class="mt-2 block w-full" :value="old('name', $product->name)" required /><x-input-error :messages="$errors->get('name')" class="mt-2" /></div>
            <div><x-input-label for="slug" value="Slug" /><x-text-input id="slug" name="slug" class="mt-2 block w-full" :value="old('slug', $product->slug)" placeholder="Auto-generated if blank" /><x-input-error :messages="$errors->get('slug')" class="mt-2" /></div>
            <div>
                <x-input-label for="product_category_id" value="Category" />
                <select id="product_category_id" name="product_category_id" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    <option value="">Uncategorized</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((int) old('product_category_id', $product->product_category_id) === $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('product_category_id')" class="mt-2" />
            </div>
            <div><x-input-label for="sort_order" value="Sort Order" /><x-text-input id="sort_order" type="number" min="0" name="sort_order" class="mt-2 block w-full" :value="old('sort_order', $product->sort_order ?? 0)" required /><x-input-error :messages="$errors->get('sort_order')" class="mt-2" /></div>
            <div><x-input-label for="material" value="Material" /><x-text-input id="material" name="material" class="mt-2 block w-full" :value="old('material', $product->material)" /><x-input-error :messages="$errors->get('material')" class="mt-2" /></div>
            <div><x-input-label for="size" value="Size" /><x-text-input id="size" name="size" class="mt-2 block w-full" :value="old('size', $product->size)" /><x-input-error :messages="$errors->get('size')" class="mt-2" /></div>
            <div><x-input-label for="color" value="Color" /><x-text-input id="color" name="color" class="mt-2 block w-full" :value="old('color', $product->color)" /><x-input-error :messages="$errors->get('color')" class="mt-2" /></div>
            <div><x-input-label for="price" value="Price" /><x-text-input id="price" type="number" step="0.01" min="0" name="price" class="mt-2 block w-full" :value="old('price', $product->price)" /><x-input-error :messages="$errors->get('price')" class="mt-2" /></div>
            <div><x-input-label for="made_by" value="Made By" /><x-text-input id="made_by" name="made_by" class="mt-2 block w-full" :value="old('made_by', $product->made_by)" /><x-input-error :messages="$errors->get('made_by')" class="mt-2" /></div>
            <div><x-input-label for="skill_used" value="Skill Used" /><x-text-input id="skill_used" name="skill_used" class="mt-2 block w-full" :value="old('skill_used', $product->skill_used)" /><x-input-error :messages="$errors->get('skill_used')" class="mt-2" /></div>
            <div class="md:col-span-2"><x-input-label for="short_description" value="Short Description" /><x-text-input id="short_description" name="short_description" class="mt-2 block w-full" :value="old('short_description', $product->short_description)" /><x-input-error :messages="$errors->get('short_description')" class="mt-2" /></div>
            <div class="md:col-span-2"><x-input-label for="description" value="Description" /><textarea id="description" name="description" rows="6" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('description', $product->description) }}</textarea><x-input-error :messages="$errors->get('description')" class="mt-2" /></div>
            <div><x-input-label for="image" value="Main Image" /><input id="image" name="image" type="file" accept="image/*" class="mt-2 block w-full rounded-md border border-gray-300 bg-white text-sm text-stone-600 file:mr-4 file:border-0 file:bg-rose-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-rose-900"><x-input-error :messages="$errors->get('image')" class="mt-2" /></div>
            <div><x-input-label for="gallery_files" value="Gallery Images (Optional)" /><input id="gallery_files" name="gallery_files[]" type="file" accept="image/*" multiple class="mt-2 block w-full rounded-md border border-gray-300 bg-white text-sm text-stone-600 file:mr-4 file:border-0 file:bg-rose-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-rose-900"><x-input-error :messages="$errors->get('gallery_files')" class="mt-2" /><x-input-error :messages="$errors->get('gallery_files.*')" class="mt-2" /></div>
            <div class="md:col-span-2 flex flex-wrap gap-3">
                <input type="hidden" name="is_active" value="0">
                <label class="inline-flex items-center gap-3 rounded-2xl border border-rose-100 bg-[#fffdf9] px-4 py-3 text-sm font-semibold text-stone-700"><input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-rose-900 shadow-sm focus:ring-rose-500" @checked(old('is_active', $product->is_active ?? true))>Active</label>
                <input type="hidden" name="is_featured" value="0">
                <label class="inline-flex items-center gap-3 rounded-2xl border border-amber-100 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-900"><input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-rose-900 shadow-sm focus:ring-rose-500" @checked(old('is_featured', $product->is_featured ?? false))>Featured</label>
            </div>
        </div>
    </section>
    <aside class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
        <x-primary-button class="w-full justify-center bg-rose-900 hover:bg-rose-800">{{ $submitLabel }}</x-primary-button>
        <a href="{{ route('admin.products.index') }}" class="mt-3 inline-flex w-full justify-center rounded-md border border-rose-100 px-4 py-2 text-sm font-semibold text-stone-600 hover:bg-rose-50">Back</a>
    </aside>
</form>
