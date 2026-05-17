<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    <div class="space-y-6">
        <div class="flex items-center justify-between gap-3">
            <p class="text-sm text-stone-600">Manage CSR report publications and presentation-ready documentation.</p>
            <a href="{{ route('admin.csr-reports.create') }}" class="rounded-full bg-rose-900 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-800">Create Report</a>
        </div>

        <form method="GET" class="rounded-2xl border border-rose-100 bg-white p-4">
            <div class="grid gap-3 md:grid-cols-4">
                <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Search title / period" class="rounded-xl border border-rose-100 px-3 py-2 text-sm md:col-span-2">
                <select name="published" class="rounded-xl border border-rose-100 px-3 py-2 text-sm">
                    <option value="">All Publish States</option>
                    <option value="1" @selected($filters['published'] === '1')>Published</option>
                    <option value="0" @selected($filters['published'] === '0')>Unpublished</option>
                </select>
                <select name="featured" class="rounded-xl border border-rose-100 px-3 py-2 text-sm">
                    <option value="">All Featured States</option>
                    <option value="1" @selected($filters['featured'] === '1')>Featured</option>
                    <option value="0" @selected($filters['featured'] === '0')>Not Featured</option>
                </select>
            </div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-rose-100 bg-white">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-rose-50 text-stone-700">
                    <tr>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Period</th>
                        <th class="px-4 py-3">Featured</th>
                        <th class="px-4 py-3">Published</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-rose-50">
                    @forelse ($reports as $report)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-semibold text-stone-900">{{ $report->title }}</p>
                                <p class="text-xs text-stone-500">{{ $report->slug }}</p>
                            </td>
                            <td class="px-4 py-3 text-stone-700">{{ $report->report_period ?: '-' }}</td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('admin.csr-reports.toggle-featured', $report) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="rounded-full px-3 py-1 text-xs font-semibold {{ $report->is_featured ? 'bg-amber-100 text-amber-900' : 'bg-stone-100 text-stone-700' }}">
                                        {{ $report->is_featured ? 'Featured' : 'Not Featured' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('admin.csr-reports.toggle-published', $report) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="rounded-full px-3 py-1 text-xs font-semibold {{ $report->is_published ? 'bg-emerald-100 text-emerald-900' : 'bg-stone-100 text-stone-700' }}">
                                        {{ $report->is_published ? 'Published' : 'Unpublished' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.csr-reports.edit', $report) }}" class="rounded-full border border-rose-200 px-3 py-1 text-xs font-semibold text-rose-900 hover:bg-rose-50">Edit</a>
                                    <form method="POST" action="{{ route('admin.csr-reports.destroy', $report) }}" onsubmit="return confirm('Delete this report?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="rounded-full border border-red-200 px-3 py-1 text-xs font-semibold text-red-700 hover:bg-red-50">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-stone-500">No reports found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $reports->links() }}
    </div>
</x-admin-layout>
