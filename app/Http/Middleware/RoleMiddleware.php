<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::user();

        // 1. Check if user is logged in
        if (! $user) {
            return redirect('/login');
        }

        $requiredRole = UserRole::tryFrom($role);

        if ($user->role !== $requiredRole) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
