@php
    $selectedTraineeId = old('trainee_id', $certificate->trainee_id);
@endphp

<div class="grid gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <label for="trainee_id" class="mb-1.5 block text-sm font-semibold text-stone-700">Trainee</label>
        <select id="trainee_id" name="trainee_id" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">
            <option value="">Select trainee</option>
            @foreach ($trainees as $trainee)
                <option value="{{ $trainee->id }}" data-program="{{ $trainee->preferred_program_id }}" @selected($selectedTraineeId == $trainee->id)>
                    {{ $trainee->name }} ({{ $trainee->registration_no }}) - {{ ucfirst($trainee->status) }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="training_program_id" class="mb-1.5 block text-sm font-semibold text-stone-700">Training Program</label>
        <select id="training_program_id" name="training_program_id" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">
            <option value="">Select program</option>
            @foreach ($programs as $program)
                <option value="{{ $program->id }}" @selected(old('training_program_id', $certificate->training_program_id) == $program->id)>{{ $program->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="title" class="mb-1.5 block text-sm font-semibold text-stone-700">Certificate Title</label>
        <input id="title" name="title" type="text" value="{{ old('title', $certificate->title) }}" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">
    </div>

    <div>
        <label for="issue_date" class="mb-1.5 block text-sm font-semibold text-stone-700">Issue Date</label>
        <input id="issue_date" name="issue_date" type="date" value="{{ old('issue_date', optional($certificate->issue_date)->format('Y-m-d') ?: $certificate->issue_date) }}" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">
    </div>

    <div>
        <label for="completion_date" class="mb-1.5 block text-sm font-semibold text-stone-700">Completion Date</label>
        <input id="completion_date" name="completion_date" type="date" value="{{ old('completion_date', optional($certificate->completion_date)->format('Y-m-d') ?: $certificate->completion_date) }}" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">
    </div>

    <div>
        <label for="issued_by" class="mb-1.5 block text-sm font-semibold text-stone-700">Issued By</label>
        <input id="issued_by" name="issued_by" type="text" value="{{ old('issued_by', $certificate->issued_by) }}" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">
    </div>

    <div>
        <label for="status" class="mb-1.5 block text-sm font-semibold text-stone-700">Status</label>
        <select id="status" name="status" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">
            @foreach (['draft' => 'Draft', 'issued' => 'Issued', 'revoked' => 'Revoked'] as $key => $label)
                <option value="{{ $key }}" @selected(old('status', $certificate->status) === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <label for="remarks" class="mb-1.5 block text-sm font-semibold text-stone-700">Remarks</label>
        <textarea id="remarks" name="remarks" rows="4" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">{{ old('remarks', $certificate->remarks) }}</textarea>
    </div>
</div>

@if ($errors->any())
    <div class="mt-4 rounded-xl border border-rose-100 bg-rose-50 px-4 py-3 text-sm text-rose-800">
        {{ $errors->first() }}
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const traineeSelect = document.getElementById('trainee_id');
        const programSelect = document.getElementById('training_program_id');

        if (!traineeSelect || !programSelect) return;

        traineeSelect.addEventListener('change', function () {
            if (programSelect.value) return;
            const selected = traineeSelect.options[traineeSelect.selectedIndex];
            const preferredProgramId = selected.getAttribute('data-program');
            if (preferredProgramId) {
                programSelect.value = preferredProgramId;
            }
        });
    });
</script>
