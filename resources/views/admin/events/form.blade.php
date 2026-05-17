<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="grid gap-6 xl:grid-cols-[1fr_0.42fr]">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <section class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <x-input-label for="title" value="Title" />
                <x-text-input id="title" name="title" class="mt-2 block w-full" :value="old('title', $event->title)" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="slug" value="Slug" />
                <x-text-input id="slug" name="slug" class="mt-2 block w-full" :value="old('slug', $event->slug)" placeholder="Auto-generated if blank" />
                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="event_date" value="Event Date" />
                <x-text-input id="event_date" type="date" name="event_date" class="mt-2 block w-full" :value="old('event_date', $event->event_date?->format('Y-m-d'))" />
                <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="event_time" value="Event Time" />
                <x-text-input id="event_time" name="event_time" class="mt-2 block w-full" :value="old('event_time', $event->event_time)" />
                <x-input-error :messages="$errors->get('event_time')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="location" value="Location" />
                <x-text-input id="location" name="location" class="mt-2 block w-full" :value="old('location', $event->location)" />
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="status" value="Status" />
                <select id="status" name="status" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500" required>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected(old('status', $event->status) === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="sort_order" value="Sort Order" />
                <x-text-input id="sort_order" type="number" min="0" name="sort_order" class="mt-2 block w-full" :value="old('sort_order', $event->sort_order ?? 0)" required />
                <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="short_description" value="Short Description" />
                <x-text-input id="short_description" name="short_description" class="mt-2 block w-full" :value="old('short_description', $event->short_description)" />
                <x-input-error :messages="$errors->get('short_description')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="description" value="Description" />
                <textarea id="description" name="description" rows="7" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('description', $event->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="cover_image" value="Cover Image" />
                <input id="cover_image" name="cover_image" type="file" accept="image/*" class="mt-2 block w-full rounded-md border border-gray-300 bg-white text-sm text-stone-600 file:mr-4 file:border-0 file:bg-rose-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-rose-900">
                <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
            </div>
            <div class="md:col-span-2 flex flex-wrap gap-3">
                <input type="hidden" name="is_active" value="0">
                <label class="inline-flex items-center gap-3 rounded-2xl border border-rose-100 bg-[#fffdf9] px-4 py-3 text-sm font-semibold text-stone-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-rose-900 shadow-sm focus:ring-rose-500" @checked(old('is_active', $event->is_active ?? true))>
                    Active
                </label>
                <input type="hidden" name="is_featured" value="0">
                <label class="inline-flex items-center gap-3 rounded-2xl border border-amber-100 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-900">
                    <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-rose-900 shadow-sm focus:ring-rose-500" @checked(old('is_featured', $event->is_featured ?? false))>
                    Featured
                </label>
            </div>
        </div>
    </section>

    <aside class="space-y-6">
        <div class="rounded-3xl border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-6 shadow-xl shadow-amber-100/50">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-800">Preview</p>
            @if ($event->cover_image && file_exists(public_path($event->cover_image)))
                <img src="{{ asset($event->cover_image) }}" alt="{{ $event->title }}" class="mt-5 h-40 w-full rounded-2xl object-cover">
            @endif
            <h3 class="mt-5 text-xl font-semibold text-stone-950">{{ $event->title ?: 'Event title' }}</h3>
            <p class="mt-2 text-sm text-stone-600">{{ $event->short_description ?: 'Short event summary for public viewers.' }}</p>
        </div>
        <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
            <x-primary-button class="w-full justify-center bg-rose-900 hover:bg-rose-800">
                {{ $submitLabel }}
            </x-primary-button>
            <a href="{{ route('admin.events.index') }}" class="mt-3 inline-flex w-full justify-center rounded-md border border-rose-100 px-4 py-2 text-sm font-semibold text-stone-600 hover:bg-rose-50">
                Back
            </a>
        </div>
    </aside>
</form>
