<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @php
        $statusStyles = [
            'pending' => 'bg-amber-100 text-amber-900',
            'contacted' => 'bg-sky-100 text-sky-900',
            'enrolled' => 'bg-emerald-100 text-emerald-900',
            'completed' => 'bg-indigo-100 text-indigo-900',
            'rejected' => 'bg-rose-100 text-rose-900',
        ];

        $timeline = [
            ['label' => 'Applied', 'date' => $trainee->created_at],
            ['label' => 'Contacted', 'date' => $trainee->status === 'contacted' || $trainee->status === 'enrolled' || $trainee->status === 'completed' ? $trainee->updated_at : null],
            ['label' => 'Enrolled', 'date' => $trainee->joined_at],
            ['label' => 'Completed', 'date' => $trainee->completed_at],
        ];
    @endphp

    <div class="space-y-6">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex flex-wrap items-center gap-3">
            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusStyles[$trainee->status] ?? 'bg-stone-100 text-stone-700' }}">
                {{ ucfirst($trainee->status) }}
            </span>
            <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-900">{{ $trainee->registration_no }}</span>
            <a href="{{ route('admin.trainees.edit', $trainee) }}" class="rounded-xl border border-rose-100 px-4 py-2 text-sm font-semibold text-rose-900 hover:bg-rose-50">Edit</a>
            <form method="POST" action="{{ route('admin.trainees.destroy', $trainee) }}" onsubmit="return confirm('Delete this trainee record?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-xl border border-red-100 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Delete</button>
            </form>
        </div>

        <section class="grid gap-6 xl:grid-cols-[1fr_0.42fr]">
            <div class="space-y-6">
                <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                    <h2 class="text-lg font-semibold text-stone-950">Personal Details</h2>
                    <dl class="mt-4 grid gap-4 md:grid-cols-2">
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Name</dt><dd class="mt-1 text-sm text-stone-800">{{ $trainee->name }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Guardian</dt><dd class="mt-1 text-sm text-stone-800">{{ $trainee->guardian_name ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Gender</dt><dd class="mt-1 text-sm text-stone-800">{{ $trainee->gender ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Date of Birth</dt><dd class="mt-1 text-sm text-stone-800">{{ $trainee->date_of_birth?->format('d M Y') ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Age</dt><dd class="mt-1 text-sm text-stone-800">{{ $trainee->age ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Education Level</dt><dd class="mt-1 text-sm text-stone-800">{{ $trainee->education_level ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Occupation</dt><dd class="mt-1 text-sm text-stone-800">{{ $trainee->occupation ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Preferred Program</dt><dd class="mt-1 text-sm text-stone-800">{{ $trainee->preferredProgram?->name ?: '-' }}</dd></div>
                    </dl>
                </div>

                <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                    <h2 class="text-lg font-semibold text-stone-950">Contact Details</h2>
                    <dl class="mt-4 grid gap-4 md:grid-cols-2">
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Phone</dt><dd class="mt-1 text-sm text-stone-800">{{ $trainee->phone }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Alternate Phone</dt><dd class="mt-1 text-sm text-stone-800">{{ $trainee->alternate_phone ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Email</dt><dd class="mt-1 text-sm text-stone-800">{{ $trainee->email ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">City</dt><dd class="mt-1 text-sm text-stone-800">{{ $trainee->city ?: '-' }}</dd></div>
                        <div class="md:col-span-2"><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Address</dt><dd class="mt-1 text-sm text-stone-800">{{ $trainee->address ?: '-' }}</dd></div>
                    </dl>
                </div>

                <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                    <h2 class="text-lg font-semibold text-stone-950">Application Notes</h2>
                    <p class="mt-4 text-sm leading-7 text-stone-700">{{ $trainee->reason_for_joining ?: 'No reason submitted.' }}</p>
                    <p class="mt-4 text-sm leading-7 text-stone-700">{{ $trainee->notes ?: 'No internal notes added.' }}</p>
                </div>

                <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                    <div class="flex items-center justify-between gap-3">
                        <h2 class="text-lg font-semibold text-stone-950">Certificates</h2>
                        @can('certificates.manage')
                            <a href="{{ route('admin.certificates.create', ['trainee' => $trainee->id]) }}" class="rounded-xl border border-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-900 hover:bg-rose-50">Create Certificate</a>
                        @endcan
                    </div>

                    <div class="mt-4 space-y-3">
                        @forelse ($trainee->certificates as $certificate)
                            <a href="{{ route('admin.certificates.show', $certificate) }}" class="flex items-center justify-between rounded-2xl border border-rose-100 bg-rose-50/40 px-4 py-3 text-sm">
                                <div>
                                    <p class="font-semibold text-stone-900">{{ $certificate->certificate_no }}</p>
                                    <p class="text-xs text-stone-600">{{ $certificate->trainingProgram?->name ?: 'Program not assigned' }}</p>
                                </div>
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold
                                    {{ $certificate->status === 'draft' ? 'bg-amber-100 text-amber-900' : '' }}
                                    {{ $certificate->status === 'issued' ? 'bg-emerald-100 text-emerald-900' : '' }}
                                    {{ $certificate->status === 'revoked' ? 'bg-rose-100 text-rose-900' : '' }}">
                                    {{ ucfirst($certificate->status) }}
                                </span>
                            </a>
                        @empty
                            <p class="text-sm text-stone-500">No certificates linked yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="rounded-3xl border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-6 shadow-xl shadow-amber-100/40">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-800">Profile</p>
                    @if ($trainee->photo && file_exists(public_path($trainee->photo)))
                        <img src="{{ asset($trainee->photo) }}" alt="{{ $trainee->name }}" class="mt-5 h-44 w-full rounded-2xl object-cover">
                    @else
                        <div class="mt-5 flex h-44 items-center justify-center rounded-2xl bg-white text-lg font-semibold text-stone-600">No photo uploaded</div>
                    @endif
                    @if ($trainee->id_proof && file_exists(public_path($trainee->id_proof)))
                        <a href="{{ asset($trainee->id_proof) }}" target="_blank" rel="noopener" class="mt-4 inline-flex rounded-xl border border-rose-100 bg-white px-4 py-2 text-sm font-semibold text-rose-900 hover:bg-rose-50">
                            View ID Proof
                        </a>
                    @endif
                </div>

                <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Timeline</p>
                    <div class="mt-4 space-y-4">
                        @foreach ($timeline as $item)
                            <div class="flex items-start gap-3">
                                <span class="mt-1 h-2.5 w-2.5 rounded-full {{ $item['date'] ? 'bg-emerald-500' : 'bg-stone-300' }}"></span>
                                <div>
                                    <p class="text-sm font-semibold text-stone-800">{{ $item['label'] }}</p>
                                    <p class="text-xs text-stone-500">{{ $item['date'] ? $item['date']->format('d M Y, h:i A') : 'Not reached yet' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </section>
    </div>
</x-admin-layout>
