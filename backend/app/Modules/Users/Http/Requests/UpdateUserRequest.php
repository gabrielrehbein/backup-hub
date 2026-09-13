<?php

namespace App\Modules\Users\Http\Requests;

use App\Modules\Users\DTOs\UpdateUserDTO;
use App\Modules\Users\Enums\RoleUserEnum;
use App\Shared\Http\Request\BaseFormRequest;
use App\Shared\Utils\ArrayHelper;
use Illuminate\Contracts\Validation\ValidationRule;


class UpdateUserRequest extends BaseFormRequest
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
            'phone' => ['sometimes', 'phone:BR', 'unique:users'],
            'role' => ['sometimes', 'string', 'in:' . ArrayHelper::arrayToFormRequestValidation(RoleUserEnum::cases())],
        ];
    }

    public function toDTO(): object
    {
        return UpdateUserDTO::fromArray($this->validated());
    }
}
