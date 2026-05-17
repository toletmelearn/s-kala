<form method="POST" action="{{ $action }}" class="grid gap-6 xl:grid-cols-[1fr_0.42fr]">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <section class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <x-input-label for="label" value="Label" />
                <x-text-input id="label" name="label" class="mt-2 block w-full" :value="old('label', $counter->label)" required />
                <x-input-error :messages="$errors->get('label')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="value" value="Value" />
                <x-text-input id="value" name="value" class="mt-2 block w-full" :value="old('value', $counter->value)" required />
                <x-input-error :messages="$errors->get('value')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="suffix" value="Suffix" />
                <x-text-input id="suffix" name="suffix" class="mt-2 block w-full" :value="old('suffix', $counter->suffix)" />
                <x-input-error :messages="$errors->get('suffix')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="icon" value="Icon Text" />
                <x-text-input id="icon" name="icon" class="mt-2 block w-full" :value="old('icon', $counter->icon)" />
                <x-input-error :messages="$errors->get('icon')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="sort_order" value="Sort Order" />
                <x-text-input id="sort_order" type="number" min="0" name="sort_order" class="mt-2 block w-full" :value="old('sort_order', $counter->sort_order ?? 0)" required />
                <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
            </div>
            <div class="flex items-end">
                <input type="hidden" name="is_active" value="0">
                <label class="inline-flex w-full items-center gap-3 rounded-2xl border border-rose-100 bg-[#fffdf9] px-4 py-3 text-sm font-semibold text-stone-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-rose-900 shadow-sm focus:ring-rose-500" @checked(old('is_active', $counter->is_active ?? true))>
                    Active counter
                </label>
            </div>
            <div class="md:col-span-2">
                <x-input-label for="description" value="Description" />
                <textarea id="description" name="description" rows="5" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('description', $counter->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
        </div>
    </section>

    <aside class="space-y-6">
        <div class="rounded-3xl border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-6 shadow-xl shadow-amber-100/50">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-800">Preview</p>
            <div class="mt-5 rounded-2xl bg-white p-5">
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-rose-50 text-sm font-semibold text-rose-900">{{ $counter->icon ?: 'Sk' }}</span>
                <p class="mt-5 text-3xl font-semibold text-stone-950">{{ $counter->value ?: '0' }}{{ $counter->suffix }}</p>
                <p class="mt-2 text-sm font-semibold text-stone-800">{{ $counter->label ?: 'Impact label' }}</p>
            </div>
        </div>

        <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
            <x-primary-button class="w-full justify-center bg-rose-900 hover:bg-rose-800">
                {{ $submitLabel }}
            </x-primary-button>
            <a href="{{ route('admin.website.counters.index') }}" class="mt-3 inline-flex w-full justify-center rounded-md border border-rose-100 px-4 py-2 text-sm font-semibold text-stone-600 hover:bg-rose-50">
                Back to Counters
            </a>
        </div>
    </aside>
</form>
