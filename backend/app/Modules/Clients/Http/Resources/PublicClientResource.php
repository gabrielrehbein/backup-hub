<?php

namespace App\Modules\Clients\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Request;


class PublicClientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'external_id' => $this->external_id,
            'plan' => [
                'id' => $this->plan->id,
                'name' => $this->plan->name,
            ],
            'is_active' => $this->is_active,
            'description' => $this->description,
        ];
    }

}
