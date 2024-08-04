<?php

namespace Kopaing\RolesPermissions\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Kopaing\RolesPermissions\Helpers\PermissionHelper;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @param  string  $feature
     * @return mixed
     */
    public function handle($request, Closure $next, $permission, $feature)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }

        if (!PermissionHelper::hasPermission($user->role_id, $feature, $permission)) {
            return response()->json(['error' => 'Forbidden.'], 403);
        }

        return $next($request);
    }
}
