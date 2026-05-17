@extends('layouts.admin')

@section('content')
    <section class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <article class="rounded-2xl border border-rose-100 bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-bold text-stone-950">{{ $enquiry->enquiry_no }}</h2>
                <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-900">{{ $typeOptions[$enquiry->type] ?? ucfirst($enquiry->type) }}</span>
            </div>

            <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Name</dt>
                    <dd class="mt-1 text-sm font-medium text-stone-900">{{ $enquiry->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Organization</dt>
                    <dd class="mt-1 text-sm text-stone-700">{{ $enquiry->organization ?: '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Phone</dt>
                    <dd class="mt-1 text-sm text-stone-700">{{ $enquiry->phone }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Email</dt>
                    <dd class="mt-1 text-sm text-stone-700">{{ $enquiry->email ?: '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Preferred Contact Method</dt>
                    <dd class="mt-1 text-sm text-stone-700">{{ $enquiry->preferred_contact_method ?: '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Submitted</dt>
                    <dd class="mt-1 text-sm text-stone-700">{{ $enquiry->created_at?->format('d M Y, h:i A') }}</dd>
                </div>
            </dl>

            <div class="mt-6">
                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Subject</p>
                <p class="mt-1 text-sm text-stone-800">{{ $enquiry->subject ?: '—' }}</p>
            </div>

            <div class="mt-6">
                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Message</p>
                <p class="mt-2 whitespace-pre-line rounded-xl bg-rose-50 p-4 text-sm leading-7 text-stone-800">{{ $enquiry->message ?: 'No message submitted.' }}</p>
            </div>
        </article>

        <article class="rounded-2xl border border-rose-100 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('admin.enquiries.update', $enquiry) }}" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label for="status" class="mb-1.5 block text-sm font-semibold text-stone-700">Status</label>
                    <select id="status" name="status" class="w-full rounded-xl border border-rose-100 px-3 py-2 text-sm">
                        @foreach ($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $enquiry->status) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="admin_notes" class="mb-1.5 block text-sm font-semibold text-stone-700">Admin Notes</label>
                    <textarea id="admin_notes" name="admin_notes" rows="6" class="w-full rounded-xl border border-rose-100 px-3 py-2 text-sm">{{ old('admin_notes', $enquiry->admin_notes) }}</textarea>
                </div>
                <button type="submit" class="rounded-full bg-rose-900 px-4 py-2 text-sm font-semibold text-white">Save Update</button>
            </form>

            <div class="mt-6 rounded-xl bg-stone-50 p-4 text-xs text-stone-600">
                <p>Contacted At: {{ $enquiry->contacted_at?->format('d M Y, h:i A') ?: '—' }}</p>
                <p class="mt-1">Closed At: {{ $enquiry->closed_at?->format('d M Y, h:i A') ?: '—' }}</p>
            </div>

            <form method="POST" action="{{ route('admin.enquiries.destroy', $enquiry) }}" class="mt-5" onsubmit="return confirm('Delete this enquiry?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-full border border-rose-200 px-4 py-2 text-sm font-semibold text-rose-900 hover:bg-rose-50">
                    Delete Enquiry
                </button>
            </form>
        </article>
    </section>
@endsection
