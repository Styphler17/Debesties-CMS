<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\RegisterRequest;
use App\Jobs\SendWelcomeEmail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('public.auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name'       => $request->name,
            'slug'       => Str::slug($request->name) . '-' . Str::random(4),
            'email'      => $request->email,
            'password'   => $request->password,
            'newsletter' => true,
            'status'     => 'active',
        ]);

        $subscriberRole = Role::where('slug', 'subscriber')->first();
        if ($subscriberRole) {
            $user->roles()->attach($subscriberRole);
        }

        SendWelcomeEmail::dispatch($user);

        Auth::login($user);

        return redirect()->route('home');
    }
}
