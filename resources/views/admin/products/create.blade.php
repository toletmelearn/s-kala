<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.products.form', [
        'action' => route('admin.products.store'),
        'method' => 'POST',
        'submitLabel' => 'Create Product',
    ])
</x-admin-layout>
