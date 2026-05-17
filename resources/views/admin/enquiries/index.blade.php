@extends('layouts.admin')

@section('content')
    <section class="space-y-6">
        <form method="GET" class="rounded-2xl border border-rose-100 bg-white p-4 shadow-sm">
            <div class="grid gap-3 md:grid-cols-6">
                <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Search name / phone / enquiry no / organization" class="md:col-span-2 rounded-xl border border-rose-100 px-3 py-2 text-sm">
                <select name="type" class="rounded-xl border border-rose-100 px-3 py-2 text-sm">
                    <option value="">All Types</option>
                    @foreach ($typeOptions as $key => $label)
                        <option value="{{ $key }}" @selected($filters['type'] === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="status" class="rounded-xl border border-rose-100 px-3 py-2 text-sm">
                    <option value="">All Status</option>
                    @foreach ($statusOptions as $key => $label)
                        <option value="{{ $key }}" @selected($filters['status'] === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                <input type="date" name="from" value="{{ $filters['from'] }}" class="rounded-xl border border-rose-100 px-3 py-2 text-sm">
                <input type="date" name="to" value="{{ $filters['to'] }}" class="rounded-xl border border-rose-100 px-3 py-2 text-sm">
            </div>
            <div class="mt-3 flex gap-2">
                <button type="submit" class="rounded-full bg-rose-900 px-4 py-2 text-xs font-semibold text-white">Apply Filters</button>
                <a href="{{ route('admin.enquiries.index') }}" class="rounded-full border border-rose-200 px-4 py-2 text-xs font-semibold text-rose-900">Reset</a>
            </div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-rose-100 bg-white shadow-sm">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-rose-50 text-stone-700">
                    <tr>
                        <th class="px-4 py-3">Enquiry No</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Submitted</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-rose-50">
                    @forelse ($enquiries as $enquiry)
                        <tr>
                            <td class="px-4 py-3 font-semibold text-stone-900">{{ $enquiry->enquiry_no }}</td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-stone-900">{{ $enquiry->name }}</p>
                                @if ($enquiry->organization)
                                    <p class="text-xs text-stone-500">{{ $enquiry->organization }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-900">{{ $typeOptions[$enquiry->type] ?? ucfirst($enquiry->type) }}</span>
                            </td>
                            <td class="px-4 py-3 text-stone-700">{{ $enquiry->phone }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold
                                    {{ $enquiry->status === 'new' ? 'bg-blue-50 text-blue-800' : '' }}
                                    {{ $enquiry->status === 'contacted' ? 'bg-amber-50 text-amber-800' : '' }}
                                    {{ $enquiry->status === 'in_progress' ? 'bg-violet-50 text-violet-800' : '' }}
                                    {{ $enquiry->status === 'closed' ? 'bg-emerald-50 text-emerald-800' : '' }}
                                    {{ $enquiry->status === 'rejected' ? 'bg-rose-50 text-rose-800' : '' }}">
                                    {{ $statusOptions[$enquiry->status] ?? ucfirst($enquiry->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-stone-600">{{ $enquiry->created_at?->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.enquiries.show', $enquiry) }}" class="rounded-full border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-900 hover:bg-rose-50">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-stone-500">No enquiries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $enquiries->links() }}
        </div>
    </section>
@endsection
