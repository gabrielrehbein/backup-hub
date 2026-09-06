<?php

namespace App\Modules\Systems\Policies;

use App\Modules\Clients\Models\Client;
use App\Modules\Systems\Models\SystemInstance;


class SystemInstancePolicy
{
    public function uploadBackup(
        Client $client,
        SystemInstance $instance
    ): bool {
            dd([
        'client_id' => $client->id,
        'instance_client_id' => $instance->client_id,
        'same' => $instance->client_id == $client->id,
        'strict_same' => $instance->client_id === $client->id,
        'client_type' => get_class($client),
        'instance_type' => get_class($instance),
    ]);
        return $instance->client_id === $client->id;
    }
}
