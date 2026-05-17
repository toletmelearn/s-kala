<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.product-categories.form', [
        'action' => route('admin.product-categories.store'),
        'method' => 'POST',
        'submitLabel' => 'Create Category',
    ])
</x-admin-layout>
