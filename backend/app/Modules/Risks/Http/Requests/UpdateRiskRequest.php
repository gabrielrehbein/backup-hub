<?php

namespace App\Modules\Risks\Http\Requests;

use App\Modules\Risks\DTOs\UpdateRiskConfigDTO;
use App\Shared\Http\Request\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;


class UpdateRiskRequest extends BaseFormRequest
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
            'description' => ['sometimes', 'string'],
            'max_delay_limit_in_minutes' => ['sometimes', 'integer', 'min:0'],
            'max_size_loss_in_percent' => ['sometimes', 'integer', 'between:0,100'],
            'notifiable' => ['sometimes', 'boolean'],
        ];
    }
    public function toDTO(): object
    {
        return UpdateRiskConfigDTO::fromArray($this->validated());
    }
}
