<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    <div class="space-y-6">
        <div class="flex items-center justify-between gap-3">
            <p class="text-sm text-stone-600">Manage certificate generation, issuing, revocation, and verification.</p>
            <a href="{{ route('admin.certificates.create') }}" class="rounded-full bg-rose-900 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-800">Create Certificate</a>
        </div>

        <form method="GET" class="rounded-2xl border border-rose-100 bg-white p-4">
            <div class="grid gap-3 md:grid-cols-4">
                <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Search trainee / phone / certificate" class="rounded-xl border border-rose-100 px-3 py-2 text-sm md:col-span-2">
                <select name="status" class="rounded-xl border border-rose-100 px-3 py-2 text-sm">
                    <option value="">All Statuses</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected($filters['status'] === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                    @endforeach
                </select>
                <select name="program" class="rounded-xl border border-rose-100 px-3 py-2 text-sm">
                    <option value="">All Programs</option>
                    @foreach ($programs as $program)
                        <option value="{{ $program->id }}" @selected((string) $filters['program'] === (string) $program->id)>{{ $program->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-rose-100 bg-white">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-rose-50 text-stone-700">
                    <tr>
                        <th class="px-4 py-3">Certificate No</th>
                        <th class="px-4 py-3">Trainee</th>
                        <th class="px-4 py-3">Program</th>
                        <th class="px-4 py-3">Issue Date</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-rose-50">
                    @forelse ($certificates as $certificate)
                        <tr>
                            <td class="px-4 py-3 font-semibold text-stone-900">{{ $certificate->certificate_no }}</td>
                            <td class="px-4 py-3 text-stone-700">{{ $certificate->trainee?->name }}</td>
                            <td class="px-4 py-3 text-stone-700">{{ $certificate->trainingProgram?->name ?: '-' }}</td>
                            <td class="px-4 py-3 text-stone-700">{{ $certificate->issue_date?->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold
                                    {{ $certificate->status === 'draft' ? 'bg-amber-100 text-amber-900' : '' }}
                                    {{ $certificate->status === 'issued' ? 'bg-emerald-100 text-emerald-900' : '' }}
                                    {{ $certificate->status === 'revoked' ? 'bg-rose-100 text-rose-900' : '' }}">
                                    {{ ucfirst($certificate->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.certificates.show', $certificate) }}" class="rounded-full border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-900 hover:bg-rose-50">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-8 text-center text-stone-500">No certificates found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $certificates->links() }}
    </div>
</x-admin-layout>
