<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="grid gap-6 xl:grid-cols-[1fr_0.42fr]">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <section class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <x-input-label for="name" value="Trainer Name" />
                <x-text-input id="name" name="name" class="mt-2 block w-full" :value="old('name', $trainer->name)" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="designation" value="Designation" />
                <x-text-input id="designation" name="designation" class="mt-2 block w-full" :value="old('designation', $trainer->designation)" />
                <x-input-error :messages="$errors->get('designation')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="specialization" value="Specialization" />
                <x-text-input id="specialization" name="specialization" class="mt-2 block w-full" :value="old('specialization', $trainer->specialization)" />
                <x-input-error :messages="$errors->get('specialization')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="sort_order" value="Sort Order" />
                <x-text-input id="sort_order" type="number" min="0" name="sort_order" class="mt-2 block w-full" :value="old('sort_order', $trainer->sort_order ?? 0)" required />
                <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="phone" value="Phone" />
                <x-text-input id="phone" name="phone" class="mt-2 block w-full" :value="old('phone', $trainer->phone)" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" type="email" name="email" class="mt-2 block w-full" :value="old('email', $trainer->email)" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="bio" value="Bio" />
                <textarea id="bio" name="bio" rows="7" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('bio', $trainer->bio) }}</textarea>
                <x-input-error :messages="$errors->get('bio')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="photo" value="Photo" />
                <input id="photo" name="photo" type="file" accept="image/*" class="mt-2 block w-full rounded-md border border-gray-300 bg-white text-sm text-stone-600 file:mr-4 file:border-0 file:bg-rose-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-rose-900">
                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <input type="hidden" name="is_active" value="0">
                <label class="inline-flex items-center gap-3 rounded-2xl border border-rose-100 bg-[#fffdf9] px-4 py-3 text-sm font-semibold text-stone-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-rose-900 shadow-sm focus:ring-rose-500" @checked(old('is_active', $trainer->is_active ?? true))>
                    Active
                </label>
            </div>
        </div>
    </section>

    <aside class="space-y-6">
        <div class="rounded-3xl border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-6 shadow-xl shadow-amber-100/50">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-800">Preview</p>
            @if ($trainer->photo && file_exists(public_path($trainer->photo)))
                <img src="{{ asset($trainer->photo) }}" alt="{{ $trainer->name }}" class="mt-5 h-40 w-full rounded-2xl object-cover">
            @endif
            <h3 class="mt-5 text-xl font-semibold text-stone-950">{{ $trainer->name ?: 'Trainer name' }}</h3>
            <p class="mt-2 text-sm font-semibold text-rose-900">{{ $trainer->specialization ?: 'Specialization' }}</p>
            @if ($trainer->exists)
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($trainer->trainingPrograms as $program)
                        <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-stone-700">{{ $program->name }}</span>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
            <x-primary-button class="w-full justify-center bg-rose-900 hover:bg-rose-800">
                {{ $submitLabel }}
            </x-primary-button>
            <a href="{{ route('admin.trainers.index') }}" class="mt-3 inline-flex w-full justify-center rounded-md border border-rose-100 px-4 py-2 text-sm font-semibold text-stone-600 hover:bg-rose-50">
                Back to Trainers
            </a>
        </div>
    </aside>
</form>
