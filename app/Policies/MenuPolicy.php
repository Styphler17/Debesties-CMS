<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermission('settings.manage');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('settings.manage');
    }

    public function update(User $user, Menu $menu): bool
    {
        return $user->hasPermission('settings.manage');
    }
}
