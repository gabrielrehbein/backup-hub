<?php

namespace App\Modules\Backups\Http\Requests;

use App\Modules\Backups\DTOs\FilterLastBackupByIntenceDTO;
use App\Modules\Backups\Enums\SizeTypeEnum;
use App\Modules\Risks\Enums\RiskTypeEnum;
use App\Shared\Http\Request\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class FilterLastBackupByIntenceRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Os tamanhos (min_size / max_size) são sempre em KB.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'plan_id' => ['sometimes', 'nullable', 'integer'],
            'client_id' => ['sometimes', 'nullable', 'integer'],
            'risk_name' => ['sometimes', 'nullable', 'string', 'max:50'],
            'risk_type' => ['sometimes', 'nullable', Rule::enum(RiskTypeEnum::class)],
            'generated_at_start' => ['sometimes', 'nullable', 'date'],
            'generated_at_end' => ['sometimes', 'nullable', 'date'],
            'min_size' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'max_size' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'return_in_size_type' => ['sometimes', 'nullable', Rule::enum(SizeTypeEnum::class)],
            'version' => ['sometimes', 'nullable', 'string', 'max:20']
        ];
    }

    public function toDTO(): FilterLastBackupByIntenceDTO
    {
        return FilterLastBackupByIntenceDTO::fromArray($this->validated());
    }
}
