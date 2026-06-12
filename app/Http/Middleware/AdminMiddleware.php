<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                abort(401, 'Unauthenticated.');
            }
            return redirect()->route('admin.login');
        }

        $hasAdminRole = auth()->user()
            ->roles()
            ->where('slug', '!=', 'subscriber')
            ->exists();

        if (!$hasAdminRole) {
            abort(403, 'Access denied.');
        }

        return $next($request);
    }
}
