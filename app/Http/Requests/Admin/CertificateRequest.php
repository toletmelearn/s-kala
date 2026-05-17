<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CertificateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('certificates.manage') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'trainee_id' => ['required', 'integer', 'exists:trainees,id'],
            'training_program_id' => ['nullable', 'integer', 'exists:training_programs,id'],
            'title' => ['required', 'string', 'max:255'],
            'issue_date' => ['required', 'date'],
            'completion_date' => ['nullable', 'date'],
            'remarks' => ['nullable', 'string', 'max:5000'],
            'issued_by' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(['draft', 'issued', 'revoked'])],
        ];
    }
}
