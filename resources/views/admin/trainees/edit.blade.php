<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.trainees.form', [
        'action' => route('admin.trainees.update', $trainee),
        'method' => 'PUT',
        'submitLabel' => 'Update Trainee',
    ])
</x-admin-layout>
