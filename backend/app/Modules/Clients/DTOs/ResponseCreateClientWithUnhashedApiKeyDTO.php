<?php

namespace App\Modules\Clients\DTOs;

use App\Modules\Clients\Models\Client;

class ResponseCreateClientWithUnhashedApiKeyDTO
{
    public function __construct(
        public readonly Client $client,
        public readonly string $unhashed_api_key,
    ) {
        $this->client->api_key = $this->unhashed_api_key;
    }

    public function toArray(): array
    {
        dd($this);

        return [
            'client' => $this->client,
        ];
    }
}
