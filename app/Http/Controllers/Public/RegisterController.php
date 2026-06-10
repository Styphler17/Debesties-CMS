<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\RegisterRequest;
use App\Jobs\SendWelcomeEmail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $baseSlug = Str::slug($request->name);
        do {
            $slug = $baseSlug . '-' . Str::random(4);
        } while (User::where('slug', $slug)->exists());

        $user = User::create([
            'name'       => $request->name,
            'slug'       => $slug,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'newsletter' => true,
            'status'     => 'active',
        ]);

        $subscriberRole = Role::where('slug', 'subscriber')->first();
        if ($subscriberRole) {
            $user->roles()->attach($subscriberRole);
        }

        SendWelcomeEmail::dispatch($user);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('home');
    }
}
