<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.training-programs.form', [
        'action' => route('admin.training-programs.update', $program),
        'method' => 'PUT',
        'submitLabel' => 'Update Program',
    ])
</x-admin-layout>
