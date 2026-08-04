<?php

namespace App\Modules\Clients\Http\Requests;

use App\Modules\Clients\DTOs\UpdatePlanDTO;
use App\Shared\Http\Request\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;


class UpdatePlanRequest extends BaseFormRequest
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
            'name' => ['sometimes', 'string', 'max:100', 'unique:plans,name'],
            'description' => ['sometimes', 'string'],
        ];
    }

    public function toDTO(): object
    {
        return UpdatePlanDTO::fromArray($this->validated());
    }
}
