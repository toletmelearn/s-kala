<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.trainees.form', [
        'action' => route('admin.trainees.store'),
        'method' => 'POST',
        'submitLabel' => 'Create Trainee',
    ])
</x-admin-layout>
