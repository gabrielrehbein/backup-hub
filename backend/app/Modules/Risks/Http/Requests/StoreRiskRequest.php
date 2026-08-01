<?php

namespace App\Modules\Risks\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('risks')->where(
                    fn ($query) => $query->where('plan_id', $this->plan_id)
                )
            ],
            'level' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('risks')->where(
                    fn ($query) => $query->where('plan_id', $this->plan_id)
                )
            ],
            'description' => ['nullable', 'string'],
            'max_delay_limit_in_minutes' => ['required', 'integer', 'min:0'],
            'max_size_loss_in_percent' => ['required', 'integer', 'between:0,100'],
            'plan_id' => ['required', 'integer', 'exists:plans,id'],
            'notifiable' => ['sometimes', 'boolean'],
        ];
    }
}
