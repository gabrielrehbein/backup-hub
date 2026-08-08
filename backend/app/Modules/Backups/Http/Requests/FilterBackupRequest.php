<?php

namespace App\Modules\Backups\Http\Requests;

use App\Modules\Backups\DTOs\BackupFilterDTO;
use App\Shared\Http\Request\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FilterBackupRequest extends BaseFormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_generatedAt' => ['sometimes', 'date'],
            'end_generatedAt' => ['sometimes', 'date'],
            'min_size' => ['sometimes', 'integer', 'min:0'],
            'max_size' => ['sometimes', 'integer', 'min:0'],
            'is_local' => ['sometimes', 'boolean'],
            'system_instance_id' => ['sometimes', 'integer'],
            'risk_id' => ['sometimes', 'integer'],
            'client_id' => ['sometimes', 'integer'],
            'risk_type' => ['sometimes', 'string'],
            'per_page' => ['sometimes', 'integer', 'min:1'],
        ];
    }

    public function toDTO(): BackupFilterDTO
    {
        return new BackupFilterDTO(
            startGeneratedAt: $this->validated('start_generatedAt'),
            endGeneratedAt: $this->validated('end_generatedAt'),
            minSize: $this->validated('min_size'),
            maxSize: $this->validated('max_size'),
            isLocal: $this->validated('is_local'),
            systemInstanceId: $this->validated('system_instance_id'),
            riskId: $this->validated('risk_id'),
            clientId: $this->validated('client_id'),
            riskType: $this->validated('risk_type'),
            perPage: $this->validated('per_page'),
        );
    }


}
