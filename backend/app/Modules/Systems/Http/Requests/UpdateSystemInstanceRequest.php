<?php

namespace App\Modules\Systems\Http\Requests;

use App\Modules\Systems\DTOs\UpdateSystemInstanceDTO;
use App\Modules\Systems\Enums\SystemCategoryEnum;
use App\Shared\Http\Request\BaseFormRequest;
use App\Shared\Utils\ArrayHelper;
use Illuminate\Contracts\Validation\ValidationRule;


class UpdateSystemInstanceRequest extends BaseFormRequest
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
            'name' => ['sometimes', 'string', 'max:100'],
            'description' => ['sometimes', 'string'],
            'category' => ['sometimes', 'string', 'in:'.ArrayHelper::arrayToFormRequestValidation(SystemCategoryEnum::cases())],
        ];
    }

    public function toDTO(): object
    {
        return UpdateSystemInstanceDTO::fromArray($this->validated());
    }
}
