<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="grid gap-6 xl:grid-cols-[1fr_0.42fr]">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <section class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <x-input-label for="name" value="Name" />
                <x-text-input id="name" name="name" class="mt-2 block w-full" :value="old('name', $trainee->name)" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="guardian_name" value="Guardian Name" />
                <x-text-input id="guardian_name" name="guardian_name" class="mt-2 block w-full" :value="old('guardian_name', $trainee->guardian_name)" />
                <x-input-error :messages="$errors->get('guardian_name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="gender" value="Gender" />
                <select id="gender" name="gender" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    <option value="">Select gender</option>
                    @foreach (['female' => 'Female', 'male' => 'Male', 'other' => 'Other'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('gender', $trainee->gender) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="date_of_birth" value="Date of Birth" />
                <x-text-input id="date_of_birth" type="date" name="date_of_birth" class="mt-2 block w-full" :value="old('date_of_birth', $trainee->date_of_birth?->format('Y-m-d'))" />
                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="age" value="Age" />
                <x-text-input id="age" type="number" min="10" max="80" name="age" class="mt-2 block w-full" :value="old('age', $trainee->age)" />
                <x-input-error :messages="$errors->get('age')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="status" value="Status" />
                <select id="status" name="status" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500" required>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected(old('status', $trainee->status) === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="phone" value="Phone" />
                <x-text-input id="phone" name="phone" class="mt-2 block w-full" :value="old('phone', $trainee->phone)" required />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="alternate_phone" value="Alternate Phone" />
                <x-text-input id="alternate_phone" name="alternate_phone" class="mt-2 block w-full" :value="old('alternate_phone', $trainee->alternate_phone)" />
                <x-input-error :messages="$errors->get('alternate_phone')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" type="email" name="email" class="mt-2 block w-full" :value="old('email', $trainee->email)" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="city" value="City" />
                <x-text-input id="city" name="city" class="mt-2 block w-full" :value="old('city', $trainee->city)" />
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="address" value="Address" />
                <textarea id="address" name="address" rows="3" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('address', $trainee->address) }}</textarea>
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="preferred_program_id" value="Preferred Program" />
                <select id="preferred_program_id" name="preferred_program_id" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    <option value="">Select program</option>
                    @foreach ($programs as $program)
                        <option value="{{ $program->id }}" @selected((int) old('preferred_program_id', $trainee->preferred_program_id) === $program->id)>
                            {{ $program->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('preferred_program_id')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="education_level" value="Education Level" />
                <x-text-input id="education_level" name="education_level" class="mt-2 block w-full" :value="old('education_level', $trainee->education_level)" />
                <x-input-error :messages="$errors->get('education_level')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="occupation" value="Occupation" />
                <x-text-input id="occupation" name="occupation" class="mt-2 block w-full" :value="old('occupation', $trainee->occupation)" />
                <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="source" value="Source" />
                <x-text-input id="source" name="source" class="mt-2 block w-full" :value="old('source', $trainee->source)" />
                <x-input-error :messages="$errors->get('source')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="previous_skill_experience" value="Previous Skill Experience" />
                <x-text-input id="previous_skill_experience" name="previous_skill_experience" class="mt-2 block w-full" :value="old('previous_skill_experience', $trainee->previous_skill_experience)" />
                <x-input-error :messages="$errors->get('previous_skill_experience')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="joined_at" value="Joined At" />
                <x-text-input id="joined_at" type="date" name="joined_at" class="mt-2 block w-full" :value="old('joined_at', $trainee->joined_at?->format('Y-m-d'))" />
                <x-input-error :messages="$errors->get('joined_at')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="completed_at" value="Completed At" />
                <x-text-input id="completed_at" type="date" name="completed_at" class="mt-2 block w-full" :value="old('completed_at', $trainee->completed_at?->format('Y-m-d'))" />
                <x-input-error :messages="$errors->get('completed_at')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="reason_for_joining" value="Reason for Joining" />
                <textarea id="reason_for_joining" name="reason_for_joining" rows="4" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('reason_for_joining', $trainee->reason_for_joining) }}</textarea>
                <x-input-error :messages="$errors->get('reason_for_joining')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="notes" value="Notes" />
                <textarea id="notes" name="notes" rows="4" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('notes', $trainee->notes) }}</textarea>
                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="photo" value="Photo" />
                <input id="photo" name="photo" type="file" accept="image/*" class="mt-2 block w-full rounded-md border border-gray-300 bg-white text-sm text-stone-600 file:mr-4 file:border-0 file:bg-rose-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-rose-900">
                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="id_proof" value="ID Proof" />
                <input id="id_proof" name="id_proof" type="file" accept=".jpg,.jpeg,.png,.webp,.pdf" class="mt-2 block w-full rounded-md border border-gray-300 bg-white text-sm text-stone-600 file:mr-4 file:border-0 file:bg-rose-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-rose-900">
                <x-input-error :messages="$errors->get('id_proof')" class="mt-2" />
            </div>
        </div>
    </section>

    <aside class="space-y-6">
        <div class="rounded-3xl border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-6 shadow-xl shadow-amber-100/50">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-800">Profile Preview</p>
            @if ($trainee->photo && file_exists(public_path($trainee->photo)))
                <img src="{{ asset($trainee->photo) }}" alt="{{ $trainee->name }}" class="mt-5 h-40 w-full rounded-2xl object-cover">
            @endif
            <h3 class="mt-5 text-xl font-semibold text-stone-950">{{ $trainee->name ?: 'Trainee name' }}</h3>
            <p class="mt-2 text-sm text-stone-600">{{ $trainee->phone ?: 'Phone not added' }}</p>
            @if ($trainee->registration_no)
                <p class="mt-2 text-xs font-semibold uppercase tracking-[0.16em] text-rose-700">{{ $trainee->registration_no }}</p>
            @endif
        </div>

        <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
            <x-primary-button class="w-full justify-center bg-rose-900 hover:bg-rose-800">
                {{ $submitLabel }}
            </x-primary-button>
            <a href="{{ route('admin.trainees.index') }}" class="mt-3 inline-flex w-full justify-center rounded-md border border-rose-100 px-4 py-2 text-sm font-semibold text-stone-600 hover:bg-rose-50">
                Back to Trainees
            </a>
        </div>
    </aside>
</form>
