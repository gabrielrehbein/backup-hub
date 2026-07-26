<?php

namespace App\Modules\Risks\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRiskRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:risks,name'],
            'level' => ['required', 'integer', 'min:1', 'unique:risks,level'],
            'description' => ['nullable', 'string'],
            'max_delay_limit_in_minutes' => ['required', 'integer', 'min:0'],
            'max_size_loss_in_percent' => ['required', 'integer', 'between:0,100'],
            'plan_id' => ['required', 'integer', 'exists:plans,id'],
            'notifiable' => ['sometimes', 'boolean'],
        ];
    }
}
