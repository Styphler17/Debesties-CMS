<?php

namespace App\Policies;

use App\Models\Media;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MediaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->hasPermission('media.upload');
    }

    public function delete(User $user, Media $media)
    {
        return $user->hasPermission('media.delete') || $user->id === $media->user_id;
    }
}
