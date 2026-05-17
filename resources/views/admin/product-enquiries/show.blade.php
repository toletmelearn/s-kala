<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @php
        $statusStyles = ['new' => 'bg-amber-100 text-amber-900', 'contacted' => 'bg-sky-100 text-sky-900', 'closed' => 'bg-emerald-100 text-emerald-900'];
    @endphp

    <div class="space-y-6">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
        @endif

        <section class="grid gap-6 xl:grid-cols-[1fr_0.42fr]">
            <div class="space-y-6">
                <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                    <h2 class="text-lg font-semibold text-stone-950">Enquiry Details</h2>
                    <dl class="mt-4 grid gap-4 md:grid-cols-2">
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Name</dt><dd class="mt-1 text-sm text-stone-800">{{ $enquiry->name }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Phone</dt><dd class="mt-1 text-sm text-stone-800">{{ $enquiry->phone }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Email</dt><dd class="mt-1 text-sm text-stone-800">{{ $enquiry->email ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Product</dt><dd class="mt-1 text-sm text-stone-800">{{ $enquiry->product?->name ?: 'General enquiry' }}</dd></div>
                        <div class="md:col-span-2"><dt class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Message</dt><dd class="mt-1 text-sm text-stone-800">{{ $enquiry->message ?: 'No message provided.' }}</dd></div>
                    </dl>
                </div>
            </div>
            <aside class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                <form method="POST" action="{{ route('admin.product-enquiries.update', $enquiry) }}">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected(old('status', $enquiry->status) === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="admin_notes" value="Admin Notes" />
                        <textarea id="admin_notes" name="admin_notes" rows="6" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('admin_notes', $enquiry->admin_notes) }}</textarea>
                        <x-input-error :messages="$errors->get('admin_notes')" class="mt-2" />
                    </div>
                    <x-primary-button class="mt-5 w-full justify-center bg-rose-900 hover:bg-rose-800">Update Enquiry</x-primary-button>
                </form>
                <div class="mt-4">
                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusStyles[$enquiry->status] }}">{{ ucfirst($enquiry->status) }}</span>
                </div>
            </aside>
        </section>
    </div>
</x-admin-layout>
