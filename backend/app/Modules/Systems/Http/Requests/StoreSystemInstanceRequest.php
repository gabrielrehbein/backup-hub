<?php

namespace App\Modules\Systems\Http\Requests;

use App\Modules\Systems\Enums\SystemCategoryEnum;
use App\Shared\Utils\ArrayHelper;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSystemInstanceRequest extends FormRequest
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
                'version' => ['required', 'string', 'max:30'],
                'client_id' => ['required', 'integer', 'exists:clients,id', 'unique:system_instances,client_id,system_id'],
                'system_id' => ['required', 'integer', 'exists:systems,id', 'unique:system_instances,client_id,system_id'],
            ];
        }
}
