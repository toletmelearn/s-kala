<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    <div class="space-y-6">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
        @endif

        <div class="flex flex-wrap items-center gap-3">
            <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-900">{{ $certificate->certificate_no }}</span>
            <a href="{{ route('admin.certificates.edit', $certificate) }}" class="rounded-xl border border-rose-100 px-4 py-2 text-sm font-semibold text-rose-900 hover:bg-rose-50">Edit</a>
            <a href="{{ route('admin.certificates.download', $certificate) }}" class="rounded-xl border border-rose-100 px-4 py-2 text-sm font-semibold text-rose-900 hover:bg-rose-50">Download PDF</a>
            @if ($certificate->status !== 'issued')
                <form method="POST" action="{{ route('admin.certificates.issue', $certificate) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Issue</button>
                </form>
            @endif
            @if ($certificate->status === 'issued')
                <form method="POST" action="{{ route('admin.certificates.revoke', $certificate) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="rounded-xl bg-rose-700 px-4 py-2 text-sm font-semibold text-white">Revoke</button>
                </form>
            @endif
            @if ($certificate->status === 'draft')
                <form method="POST" action="{{ route('admin.certificates.destroy', $certificate) }}" onsubmit="return confirm('Delete this draft certificate?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="rounded-xl border border-red-100 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Delete</button>
                </form>
            @endif
        </div>

        <section class="grid gap-6 xl:grid-cols-[1fr_0.8fr]">
            <article class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                <h2 class="text-lg font-semibold text-stone-950">Certificate Details</h2>
                <dl class="mt-4 grid gap-4 md:grid-cols-2">
                    <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Trainee</dt><dd class="mt-1 text-sm text-stone-800">{{ $certificate->trainee?->name }}</dd></div>
                    <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Registration No</dt><dd class="mt-1 text-sm text-stone-800">{{ $certificate->trainee?->registration_no }}</dd></div>
                    <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Program</dt><dd class="mt-1 text-sm text-stone-800">{{ $certificate->trainingProgram?->name ?: '-' }}</dd></div>
                    <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Title</dt><dd class="mt-1 text-sm text-stone-800">{{ $certificate->title }}</dd></div>
                    <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Issue Date</dt><dd class="mt-1 text-sm text-stone-800">{{ $certificate->issue_date?->format('d M Y') }}</dd></div>
                    <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Completion Date</dt><dd class="mt-1 text-sm text-stone-800">{{ $certificate->completion_date?->format('d M Y') ?: '-' }}</dd></div>
                    <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Status</dt><dd class="mt-1 text-sm text-stone-800">{{ ucfirst($certificate->status) }}</dd></div>
                    <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Issued By</dt><dd class="mt-1 text-sm text-stone-800">{{ $certificate->issued_by ?: '-' }}</dd></div>
                </dl>
                <div class="mt-5 rounded-2xl bg-rose-50 p-4 text-sm text-stone-700">
                    <p class="font-semibold text-stone-900">Verification Code</p>
                    <p class="mt-1">{{ $certificate->verification_code }}</p>
                    <p class="mt-4 font-semibold text-stone-900">Verification URL</p>
                    <a href="{{ $verificationUrl }}" target="_blank" class="mt-1 inline-block break-all text-rose-900 underline">{{ $verificationUrl }}</a>
                    <button type="button" class="mt-3 inline-flex rounded-full border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-900 hover:bg-rose-100"
                        onclick="navigator.clipboard && navigator.clipboard.writeText('{{ $verificationUrl }}')">
                        Copy Verification URL
                    </button>
                </div>
                @if ($certificate->remarks)
                    <div class="mt-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Remarks</p>
                        <p class="mt-2 text-sm leading-7 text-stone-700">{{ $certificate->remarks }}</p>
                    </div>
                @endif
            </article>

            <aside class="rounded-3xl border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-6 shadow-xl shadow-amber-100/40">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-800">Verification</p>
                <p class="mt-3 text-sm leading-7 text-stone-700">
                    Public verification page confirms authenticity status. Revoked certificates are explicitly marked on verification.
                </p>
                <a href="{{ $verificationUrl }}" target="_blank" class="mt-4 inline-flex rounded-full bg-stone-950 px-5 py-2.5 text-sm font-semibold text-white">
                    Open Verification Page
                </a>
            </aside>
        </section>
    </div>
</x-admin-layout>
