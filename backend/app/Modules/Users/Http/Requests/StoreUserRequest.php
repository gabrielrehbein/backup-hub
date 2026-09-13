<?php

namespace App\Modules\Users\Http\Requests;

use App\Modules\Users\DTOs\CreateUserDTO;
use App\Modules\Users\Enums\RoleUserEnum;
use App\Shared\Http\Request\BaseFormRequest;
use App\Shared\Utils\ArrayHelper;
use Illuminate\Contracts\Validation\ValidationRule;


class StoreUserRequest extends BaseFormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'phone:BR', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['sometimes', 'string', 'in:' . ArrayHelper::arrayToFormRequestValidation(RoleUserEnum::cases())],
        ];
    }

    public function toDTO(): object
    {
        return CreateUserDTO::fromArray($this->validated());
    }
}
