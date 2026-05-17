<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.training-programs.form', [
        'action' => route('admin.training-programs.store'),
        'method' => 'POST',
        'submitLabel' => 'Create Program',
    ])
</x-admin-layout>
