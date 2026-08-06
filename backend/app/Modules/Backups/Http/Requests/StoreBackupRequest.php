<?php

namespace App\Modules\Backups\Http\Requests;

use App\Modules\Backups\DTOs\CreateBackupRequestDTO;
use App\Modules\Backups\Enums\SizeTypeEnum;
use App\Shared\Http\Request\BaseFormRequest;
use App\Shared\Utils\ArrayHelper;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Validation\ValidationRule;


class StoreBackupRequest extends BaseFormRequest
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
            'size' => ['required', 'integer', 'min:0'],
            'size_type' => ['sometimes', 'string', 'in:' . ArrayHelper::arrayToFormRequestValidation(SizeTypeEnum::cases())],
            'generated_at' => ['required', 'date'],
            'source_ip' => ['required', 'ip'],
            'is_local' => ['required', 'boolean'],
            'system_instance_id' => ['required', 'integer'],
            'version' => ['required', 'string', 'max:30'],
            'file_path' => ['required', 'string', 'max:255'],
        ];
    }

    public function toDTO(): object
    {
        return new CreateBackupRequestDTO(
            fileSize: $this->validated('size'),
            generatedAt: CarbonImmutable::parse($this->validated('generated_at')),
            isLocal: $this->validated('is_local'),
            systemInstanceId: $this->validated('system_instance_id'),
            sourceIp: $this->validated('source_ip'),
            filePath: $this->validated('file_path'),
            version: $this->validated('version'),
            sizeType: SizeTypeEnum::tryFrom(strtolower($this->validated('size_type'))) ?? SizeTypeEnum::KB,
        );
    }
}
