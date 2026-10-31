<?php

namespace App\Modules\Clients\Policies;

use App\Modules\Clients\Models\Plan;
use App\Modules\Users\Models\User;

use Illuminate\Auth\Access\Response;

class DashboardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return true;
    }

}
