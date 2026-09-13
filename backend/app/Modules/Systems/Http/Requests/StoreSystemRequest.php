<?php

namespace App\Modules\Systems\Http\Requests;

use App\Modules\Systems\DTOs\CreateSystemDTO;
use App\Modules\Systems\Enums\SystemCategoryEnum;
use App\Shared\Http\Request\BaseFormRequest;
use App\Shared\Utils\ArrayHelper;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSystemRequest extends BaseFormRequest
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
                'description' => ['nullable', 'string'],
                'category_id' => ['required', 'integer', 'exists:categories,id'],
            ];
        }

    public function toDTO(): object
    {
        return CreateSystemDTO::fromArray($this->validated());
    }
}
