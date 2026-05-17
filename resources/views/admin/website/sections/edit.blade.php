<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.website.sections.form', [
        'action' => route('admin.website.sections.update', $section),
        'method' => 'PUT',
        'submitLabel' => 'Update Section',
    ])
</x-admin-layout>
