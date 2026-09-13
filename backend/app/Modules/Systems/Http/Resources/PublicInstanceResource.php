<?php

namespace App\Modules\Systems\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Request;


class PublicInstanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'version' => $this->version,
            'client' => [
                'cliend_id' => $this->client_id,
                'client_name' => $this->client->name,
            ],
            'system' => [
                'system_id' => $this->system_id,
                'system_name' => $this->system->name,
            ],
        ];
    }

}
