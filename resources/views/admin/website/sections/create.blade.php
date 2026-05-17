<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.website.sections.form', [
        'action' => route('admin.website.sections.store'),
        'method' => 'POST',
        'submitLabel' => 'Create Section',
    ])
</x-admin-layout>
