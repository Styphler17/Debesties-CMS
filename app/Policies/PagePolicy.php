<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Page $page): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('posts.create');
    }

    public function update(User $user, Page $page): bool
    {
        return $user->hasPermission('posts.edit') || $user->id === $page->user_id;
    }

    public function delete(User $user, Page $page): bool
    {
        return $user->hasPermission('posts.delete') || $user->id === $page->user_id;
    }
}
