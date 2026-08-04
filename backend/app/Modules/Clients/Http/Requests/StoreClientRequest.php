<?php

namespace App\Modules\Clients\Http\Requests;

use App\Modules\Clients\DTOs\CreateClientDTO;
use App\Shared\Http\Request\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;


class StoreClientRequest extends BaseFormRequest
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
            'plan_id' => ['required', 'integer', 'exists:plans,id'],
            'external_id' => ['required', 'string', 'max:255', 'unique:clients,external_id'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function toDTO(): object
    {
        return CreateClientDTO::fromArray($this->validated());
    }
}
