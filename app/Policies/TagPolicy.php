<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Tag $tag): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('tags.manage');
    }

    public function update(User $user, Tag $tag): bool
    {
        return $user->hasPermission('tags.manage');
    }

    public function delete(User $user, Tag $tag): bool
    {
        return $user->hasPermission('tags.manage');
    }
}
