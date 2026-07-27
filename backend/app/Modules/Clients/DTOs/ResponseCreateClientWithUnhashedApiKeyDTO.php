<?php

namespace App\Modules\Clients\DTOs;

use App\Modules\Clients\Models\Client;

class ResponseCreateClientWithUnhashedApiKeyDTO
{
    public function __construct(
        readonly public Client $client,
        readonly public string $unhashed_api_key,
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
