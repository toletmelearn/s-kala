@extends('layouts.frontend', [
    'title' => 'Join S-kala',
    'settings' => $settings,
])

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="max-w-4xl">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Trainee Registration</p>
                <h1 class="mt-4 text-4xl font-bold tracking-normal text-stone-950 sm:text-5xl">Join S-kala and begin your skill-to-confidence journey.</h1>
                <p class="mt-5 max-w-3xl text-base leading-8 text-stone-600">
                    Fill this form to register your interest. Our team will review your details and contact you with the next steps.
                </p>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-[1fr_0.4fr] lg:px-8">
            <form method="POST" action="{{ route('join.store') }}" enctype="multipart/form-data" class="rounded-[2rem] border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40 sm:p-8">
                @csrf

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <x-input-label for="name" value="Name" />
                        <x-text-input id="name" name="name" class="mt-2 block w-full" :value="old('name')" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="guardian_name" value="Guardian Name" />
                        <x-text-input id="guardian_name" name="guardian_name" class="mt-2 block w-full" :value="old('guardian_name')" />
                        <x-input-error :messages="$errors->get('guardian_name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="phone" value="Phone" />
                        <x-text-input id="phone" name="phone" class="mt-2 block w-full" :value="old('phone')" required />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="alternate_phone" value="Alternate Phone" />
                        <x-text-input id="alternate_phone" name="alternate_phone" class="mt-2 block w-full" :value="old('alternate_phone')" />
                        <x-input-error :messages="$errors->get('alternate_phone')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" type="email" name="email" class="mt-2 block w-full" :value="old('email')" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="age" value="Age" />
                        <x-text-input id="age" type="number" min="10" max="80" name="age" class="mt-2 block w-full" :value="old('age')" />
                        <x-input-error :messages="$errors->get('age')" class="mt-2" />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="address" value="Address" />
                        <textarea id="address" name="address" rows="3" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('address') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="city" value="City" />
                        <x-text-input id="city" name="city" class="mt-2 block w-full" :value="old('city')" />
                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="preferred_program_id" value="Preferred Training Program" />
                        <select id="preferred_program_id" name="preferred_program_id" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                            <option value="">Select program</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}" @selected((int) old('preferred_program_id', $selectedProgramId) === $program->id)>
                                    {{ $program->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('preferred_program_id')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="education_level" value="Education Level" />
                        <x-text-input id="education_level" name="education_level" class="mt-2 block w-full" :value="old('education_level')" />
                        <x-input-error :messages="$errors->get('education_level')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="previous_skill_experience" value="Previous Skill Experience" />
                        <x-text-input id="previous_skill_experience" name="previous_skill_experience" class="mt-2 block w-full" :value="old('previous_skill_experience')" />
                        <x-input-error :messages="$errors->get('previous_skill_experience')" class="mt-2" />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="reason_for_joining" value="Reason for Joining" />
                        <textarea id="reason_for_joining" name="reason_for_joining" rows="4" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('reason_for_joining') }}</textarea>
                        <x-input-error :messages="$errors->get('reason_for_joining')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="photo" value="Photo (Optional)" />
                        <input id="photo" name="photo" type="file" accept="image/*" class="mt-2 block w-full rounded-md border border-gray-300 bg-white text-sm text-stone-600 file:mr-4 file:border-0 file:bg-rose-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-rose-900">
                        <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="id_proof" value="ID Proof (Optional)" />
                        <input id="id_proof" name="id_proof" type="file" accept=".jpg,.jpeg,.png,.webp,.pdf" class="mt-2 block w-full rounded-md border border-gray-300 bg-white text-sm text-stone-600 file:mr-4 file:border-0 file:bg-rose-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-rose-900">
                        <x-input-error :messages="$errors->get('id_proof')" class="mt-2" />
                    </div>
                </div>

                <x-primary-button class="mt-8 bg-rose-900 px-6 py-3 hover:bg-rose-800">
                    Submit Registration
                </x-primary-button>
            </form>

            <aside class="space-y-5">
                <div class="rounded-[2rem] border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-6 shadow-xl shadow-amber-100/40">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-800">What happens next</p>
                    <ol class="mt-4 space-y-3 text-sm leading-6 text-stone-700">
                        <li>1. Your application is received with status pending.</li>
                        <li>2. Our team reviews and contacts you.</li>
                        <li>3. Program guidance and enrollment support follows.</li>
                    </ol>
                </div>
                <div class="rounded-[2rem] border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">S-kala Promise</p>
                    <p class="mt-3 text-sm leading-6 text-stone-600">
                        A respectful, supportive learning space focused on confidence, dignity, and livelihood.
                    </p>
                </div>
            </aside>
        </div>
    </section>
@endsection
