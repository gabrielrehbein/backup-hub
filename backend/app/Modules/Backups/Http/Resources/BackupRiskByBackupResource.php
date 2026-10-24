<?php

namespace App\Modules\Backups\Http\Resources;

use App\Modules\Backups\Actions\SizeConveterAction;
use App\Modules\Backups\Enums\SizeTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BackupRiskByBackupResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'type' => $this->type,
            'delay_in_minutes' => $this->delay_in_minutes,
            'size_loss_percent' => $this->size_loss_percent,
            'is_active' => $this->is_active,
            'description' => $this->description,
            'risk' => $this->whenLoaded('risk', function () {
                return $this->risk;
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
