<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTraineeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('trainees.manage') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'guardian_name' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'in:female,male,other'],
            'date_of_birth' => ['nullable', 'date'],
            'age' => ['nullable', 'integer', 'min:10', 'max:80'],
            'phone' => ['required', 'string', 'max:30'],
            'alternate_phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:2000'],
            'city' => ['nullable', 'string', 'max:120'],
            'preferred_program_id' => ['nullable', 'integer', 'exists:training_programs,id'],
            'education_level' => ['nullable', 'string', 'max:255'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'previous_skill_experience' => ['nullable', 'string', 'max:255'],
            'reason_for_joining' => ['nullable', 'string', 'max:4000'],
            'status' => ['required', Rule::in(['pending', 'contacted', 'enrolled', 'completed', 'rejected'])],
            'source' => ['nullable', 'string', 'max:120'],
            'notes' => ['nullable', 'string', 'max:4000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'id_proof' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
            'joined_at' => ['nullable', 'date'],
            'completed_at' => ['nullable', 'date'],
        ];
    }
}
