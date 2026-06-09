<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // Add authorization logic if applicable
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    public function delete(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
}
