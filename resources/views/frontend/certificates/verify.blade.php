@extends('layouts.frontend', [
    'title' => 'Certificate Verification',
    'settings' => $settings,
])

@section('content')
    <section class="py-16">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-[2rem] border border-rose-100 bg-white p-8 shadow-xl shadow-rose-100/40">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Certificate Verification</p>
                <h1 class="mt-3 text-3xl font-bold text-stone-950">S-kala Certificate Authenticity</h1>

                @if (! $certificate)
                    <div class="mt-6 rounded-2xl border border-rose-100 bg-rose-50 p-5 text-sm font-semibold text-rose-800">
                        Certificate not found for the provided verification code.
                    </div>
                @else
                    <div class="mt-6 rounded-2xl p-5 text-sm font-semibold
                        {{ $isValid ? 'border border-emerald-100 bg-emerald-50 text-emerald-800' : '' }}
                        {{ $isRevoked ? 'border border-rose-100 bg-rose-50 text-rose-800' : '' }}
                        {{ ! $isValid && ! $isRevoked ? 'border border-amber-100 bg-amber-50 text-amber-800' : '' }}">
                        @if ($isValid)
                            Authentic certificate. This certificate has been issued by S-kala - Shakuntala Shishu Lok.
                        @elseif ($isRevoked)
                            This certificate has been revoked.
                        @else
                            This certificate is not issued yet.
                        @endif
                    </div>

                    <dl class="mt-7 grid gap-4 sm:grid-cols-2">
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Certificate Number</dt><dd class="mt-1 text-sm text-stone-900">{{ $certificate->certificate_no }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Status</dt><dd class="mt-1 text-sm text-stone-900">{{ ucfirst($certificate->status) }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Trainee Name</dt><dd class="mt-1 text-sm text-stone-900">{{ $certificate->trainee?->name }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Training Program</dt><dd class="mt-1 text-sm text-stone-900">{{ $certificate->trainingProgram?->name ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Issue Date</dt><dd class="mt-1 text-sm text-stone-900">{{ $certificate->issue_date?->format('d M Y') }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Completion Date</dt><dd class="mt-1 text-sm text-stone-900">{{ $certificate->completion_date?->format('d M Y') ?: '-' }}</dd></div>
                    </dl>
                @endif
            </div>
        </div>
    </section>
@endsection
