<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="grid gap-6 xl:grid-cols-[1fr_0.42fr]">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <section class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <x-input-label for="name" value="Program Name" />
                <x-text-input id="name" name="name" class="mt-2 block w-full" :value="old('name', $program->name)" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="slug" value="Slug" />
                <x-text-input id="slug" name="slug" class="mt-2 block w-full" :value="old('slug', $program->slug)" placeholder="Auto-generated if blank" />
                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="category" value="Category" />
                <x-text-input id="category" name="category" class="mt-2 block w-full" :value="old('category', $program->category)" />
                <x-input-error :messages="$errors->get('category')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="duration" value="Duration" />
                <x-text-input id="duration" name="duration" class="mt-2 block w-full" :value="old('duration', $program->duration)" />
                <x-input-error :messages="$errors->get('duration')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="level" value="Level" />
                <x-text-input id="level" name="level" class="mt-2 block w-full" :value="old('level', $program->level)" />
                <x-input-error :messages="$errors->get('level')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="sort_order" value="Sort Order" />
                <x-text-input id="sort_order" type="number" min="0" name="sort_order" class="mt-2 block w-full" :value="old('sort_order', $program->sort_order ?? 0)" required />
                <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="short_description" value="Short Description" />
                <x-text-input id="short_description" name="short_description" class="mt-2 block w-full" :value="old('short_description', $program->short_description)" />
                <x-input-error :messages="$errors->get('short_description')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="description" value="Description" />
                <textarea id="description" name="description" rows="7" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('description', $program->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="outcome" value="Outcome" />
                <textarea id="outcome" name="outcome" rows="4" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('outcome', $program->outcome) }}</textarea>
                <x-input-error :messages="$errors->get('outcome')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="image" value="Program Image" />
                <input id="image" name="image" type="file" accept="image/*" class="mt-2 block w-full rounded-md border border-gray-300 bg-white text-sm text-stone-600 file:mr-4 file:border-0 file:bg-rose-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-rose-900">
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label value="Assign Trainers" />
                <div class="mt-2 grid gap-2 sm:grid-cols-2">
                    @forelse ($trainers as $trainer)
                        <label class="flex items-center gap-3 rounded-2xl border border-rose-100 bg-[#fffdf9] px-4 py-3 text-sm font-semibold text-stone-700">
                            <input type="checkbox" name="trainer_ids[]" value="{{ $trainer->id }}" class="rounded border-gray-300 text-rose-900 shadow-sm focus:ring-rose-500" @checked(in_array($trainer->id, old('trainer_ids', $selectedTrainers), true))>
                            {{ $trainer->name }}
                        </label>
                    @empty
                        <p class="rounded-2xl border border-dashed border-rose-200 px-4 py-3 text-sm text-stone-500">Create trainers first to assign them here.</p>
                    @endforelse
                </div>
                <x-input-error :messages="$errors->get('trainer_ids')" class="mt-2" />
            </div>
            <div class="md:col-span-2 flex flex-wrap gap-3">
                <input type="hidden" name="is_active" value="0">
                <label class="inline-flex items-center gap-3 rounded-2xl border border-rose-100 bg-[#fffdf9] px-4 py-3 text-sm font-semibold text-stone-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-rose-900 shadow-sm focus:ring-rose-500" @checked(old('is_active', $program->is_active ?? true))>
                    Active
                </label>
                <input type="hidden" name="is_featured" value="0">
                <label class="inline-flex items-center gap-3 rounded-2xl border border-amber-100 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-900">
                    <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-rose-900 shadow-sm focus:ring-rose-500" @checked(old('is_featured', $program->is_featured ?? false))>
                    Featured on homepage
                </label>
            </div>
        </div>
    </section>

    <aside class="space-y-6">
        <div class="rounded-3xl border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-6 shadow-xl shadow-amber-100/50">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-800">Preview</p>
            @if ($program->image && file_exists(public_path($program->image)))
                <img src="{{ asset($program->image) }}" alt="{{ $program->name }}" class="mt-5 h-40 w-full rounded-2xl object-cover">
            @endif
            <h3 class="mt-5 text-xl font-semibold text-stone-950">{{ $program->name ?: 'Program name' }}</h3>
            <p class="mt-2 text-sm leading-6 text-stone-600">{{ $program->short_description ?: 'Skill-to-confidence-to-livelihood journey.' }}</p>
        </div>

        <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
            <x-primary-button class="w-full justify-center bg-rose-900 hover:bg-rose-800">
                {{ $submitLabel }}
            </x-primary-button>
            <a href="{{ route('admin.training-programs.index') }}" class="mt-3 inline-flex w-full justify-center rounded-md border border-rose-100 px-4 py-2 text-sm font-semibold text-stone-600 hover:bg-rose-50">
                Back to Programs
            </a>
        </div>
    </aside>
</form>
