<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.gallery-categories.form', [
        'action' => route('admin.gallery-categories.store'),
        'method' => 'POST',
        'submitLabel' => 'Create Category',
    ])
</x-admin-layout>
