<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CsrReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('csr_reports.manage') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $reportId = $this->route('csr_report')?->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9-]+$/', Rule::unique('csr_reports', 'slug')->ignore($reportId)],
            'report_period' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'highlights' => ['nullable', 'string'],
            'challenges' => ['nullable', 'string'],
            'future_plan' => ['nullable', 'string'],
            'report_file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ];
    }
}
