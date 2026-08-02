<?php

namespace App\Modules\Clients\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'plan_id' => ['sometimes', 'integer', 'exists:plans,id'],
            'external_id' => ['sometimes', 'string', 'max:255', 'unique:clients,external_id'],
            'description' => ['nullable', 'string'],
        ];
    }
}
