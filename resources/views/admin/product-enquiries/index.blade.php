<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @php
        $statusStyles = ['new' => 'bg-amber-100 text-amber-900', 'contacted' => 'bg-sky-100 text-sky-900', 'closed' => 'bg-emerald-100 text-emerald-900'];
    @endphp

    <div class="space-y-6">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
        @endif

        <form method="GET" action="{{ route('admin.product-enquiries.index') }}" class="rounded-3xl border border-rose-100 bg-white p-5 shadow-sm">
            <div class="grid gap-3 md:grid-cols-4">
                <x-text-input name="search" :value="$filters['search']" placeholder="Search name/phone" class="block w-full" />
                <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    <option value="">All statuses</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected($filters['status'] === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <select name="product" class="rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    <option value="">All products</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" @selected((string) $filters['productId'] === (string) $product->id)>{{ $product->name }}</option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="w-full rounded-xl bg-rose-900 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-800">Filter</button>
                    <a href="{{ route('admin.product-enquiries.index') }}" class="rounded-xl border border-rose-100 px-4 py-2 text-sm font-semibold text-stone-600 hover:bg-rose-50">Reset</a>
                </div>
            </div>
        </form>

        <section class="overflow-hidden rounded-3xl border border-rose-100 bg-white shadow-xl shadow-rose-100/40">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-rose-100">
                    <thead class="bg-[#fffdf9]">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Phone</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Product</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rose-100">
                        @forelse ($enquiries as $enquiry)
                            <tr>
                                <td class="px-4 py-3 text-sm font-semibold text-stone-800">{{ $enquiry->name }}</td>
                                <td class="px-4 py-3 text-sm text-stone-700">{{ $enquiry->phone }}</td>
                                <td class="px-4 py-3 text-sm text-stone-700">{{ $enquiry->product?->name ?: 'General enquiry' }}</td>
                                <td class="px-4 py-3 text-sm"><span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusStyles[$enquiry->status] }}">{{ ucfirst($enquiry->status) }}</span></td>
                                <td class="px-4 py-3 text-sm text-stone-600">{{ $enquiry->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('admin.product-enquiries.show', $enquiry) }}" class="rounded-xl border border-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-900 hover:bg-rose-50">View</a>
                                        <form method="POST" action="{{ route('admin.product-enquiries.destroy', $enquiry) }}" onsubmit="return confirm('Delete this enquiry?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-xl border border-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-10 text-center text-sm text-stone-500">No enquiries yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{ $enquiries->links() }}
    </div>
</x-admin-layout>
