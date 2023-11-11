<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;

class OrderPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user)
    {
        return $user->isAdmin() || $user->isModerator();
    }

    public function update(User $user, Order $order)
    {
        return $user->isAdmin() || $user->isModerator();
    }
}
