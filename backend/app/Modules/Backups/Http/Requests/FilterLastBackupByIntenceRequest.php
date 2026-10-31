<?php

namespace App\Modules\Backups\Http\Requests;

use App\Modules\Backups\DTOs\BackupFilterDTO;
use App\Modules\Backups\DTOs\FilterLastBackupByIntenceDTO;
use App\Modules\Backups\Enums\SizeTypeEnum;
use App\Shared\Http\Request\BaseFormRequest;
use App\Shared\Utils\ArrayHelper;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'plan_id' => ['sometimes', 'string'],
            'client_id' => ['sometimes', 'string'],
            'risk_name' => ['sometimes', 'string'],
            'risk_type' => ['sometimes', 'string'],
            'generated_at_start' => ['sometimes', 'date'],
            'generated_at_end' => ['sometimes', 'date'],
            'min_size' => ['sometimes', 'integer', 'min:0'],
            'max_size' => ['sometimes', 'integer', 'min:0']
        ];
    }

    public function toDTO(): FilterLastBackupByIntenceDTO
    {
        return new FilterLastBackupByIntenceDTO(
            plan_id: $this->validated('plan_id'),
            client_id: $this->validated('client_id'),
            riskName: $this->validated('risk_name'),
            riskType: $this->validated('risk_type'),
            generatedAtStart: $this->validated('generated_at_start'),
            generatedAtEnd: $this->validated('generated_at_end'),
            minSize: $this->validated('min_size'),
            maxSize: $this->validated('max_size'),
        );
    }


}
