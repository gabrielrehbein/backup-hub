<?php

namespace App\Modules\Systems\Http\Requests;

use App\Modules\Systems\Enums\SystemCategoryEnum;
use App\Shared\Utils\ArrayHelper;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSystemInstanceRequest extends FormRequest
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
                'category' => ['sometimes', 'string', 'in:' . ArrayHelper::arrayToFormRequestValidation(SystemCategoryEnum::cases())],
            ];
        }
}
