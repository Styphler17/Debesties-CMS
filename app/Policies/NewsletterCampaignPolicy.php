<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsletterCampaignPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermission('settings.manage');
    }

    public function create(User $user)
    {
        return $user->hasPermission('settings.manage');
    }

    public function update(User $user)
    {
        return $user->hasPermission('settings.manage');
    }

    public function delete(User $user)
    {
        return $user->hasPermission('settings.manage');
    }
}
