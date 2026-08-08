<?php

namespace App\Modules\Backups\Http\Resources;

use App\Modules\Backups\Actions\SizeConveterAction;
use App\Modules\Backups\Enums\SizeTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BackupResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $sizeType = $request->input('return_in_size_type');


        return [
            'id' => $this->id,
            'size' => SizeConveterAction::fromKb(
                $this->file_size_kb,
                $sizeType ? SizeTypeEnum::from($sizeType) : SizeTypeEnum::KB
            ),
            'size_type' => $sizeType ? SizeTypeEnum::from($sizeType)->value : SizeTypeEnum::KB->value,
            'generated_at' => $this->generated_at,
            'source_ip' => $this->source_ip,
            'is_local' => $this->is_local,
            'system_instance_id' => $this->system_instance_id,
            'version' => $this->version,
            'file_path' => $this->file_path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}