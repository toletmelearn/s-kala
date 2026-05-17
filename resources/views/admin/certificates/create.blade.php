<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
        <form method="POST" action="{{ route('admin.certificates.store') }}" class="space-y-5">
            @csrf
            @include('admin.certificates.form')
            <div class="pt-2">
                <button type="submit" class="rounded-full bg-rose-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-rose-800">Save Certificate</button>
            </div>
        </form>
    </div>
</x-admin-layout>
