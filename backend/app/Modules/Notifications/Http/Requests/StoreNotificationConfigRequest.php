<?php

namespace App\Modules\Notifications\Http\Requests;

use App\Modules\Notifications\DTOs\CreateNotificationConfigDTO;
use App\Shared\Http\Request\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreNotificationConfigRequest extends BaseFormRequest
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
            "email" => ["required", "string", 'email',],
        ];
    }

    public function toDTO(): CreateNotificationConfigDTO
    {
        return new CreateNotificationConfigDTO(
            email: $this->validated('email'),
        );
    }
}
