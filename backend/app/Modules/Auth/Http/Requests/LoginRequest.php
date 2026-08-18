<?php

namespace App\Modules\Auth\Http\Requests;

use App\Modules\Auth\DTOs\LoginDTO;
use App\Shared\Http\Request\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;


class LoginRequest extends BaseFormRequest
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
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function toDTO(): LoginDTO
    {
        return LoginDTO::fromArray($this->validated());
    }
}
