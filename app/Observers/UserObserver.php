<?php

namespace App\Observers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function created(User $user): void
    {
        if ($user->roles()->count() === 0) {
            $subscriberRole = Role::where('slug', 'subscriber')->first();
            if ($subscriberRole) {
                $user->roles()->attach($subscriberRole->id);
            }
        }
    }

    public function updated(User $user): void
    {
        //
    }

    public function deleted(User $user): void
    {
        // Revoke tokens if they exist (Sanctum/Passport or personal access tokens)
        if (method_exists($user, 'tokens') && $user->tokens()) {
            $user->tokens()->delete();
        }

        // If the deleted user is the currently authenticated user, log them out.
        if (Auth::check() && Auth::id() === $user->id) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }
    }
}
