<?php

namespace App\Modules\Clients\Http\Requests;

use App\Modules\Clients\DTOs\CreateClientDTO;
use App\Modules\Clients\DTOs\FilterClientDTO;
use App\Shared\Http\Request\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use PHPUnit\Util\Filter;

class FilterClientRequest extends BaseFormRequest
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
            'plan_id' => ['sometimes', 'integer',],
            'is_active' => ['sometimes', 'boolean']
        ];
    }

    public function toDTO(): object
    {
        return FilterClientDTO::fromArray($this->validated());
    }
}
