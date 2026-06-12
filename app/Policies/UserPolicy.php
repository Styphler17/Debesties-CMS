<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermission('users.manage');
    }

    public function create(User $user)
    {
        return $user->hasPermission('users.manage');
    }

    public function update(User $currentUser, User $user)
    {
        return $currentUser->hasPermission('users.manage') || $currentUser->id === $user->id;
    }

    public function delete(User $currentUser, User $user)
    {
        return $currentUser->hasPermission('users.manage');
    }
}
