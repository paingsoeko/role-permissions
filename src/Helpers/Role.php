<?php

namespace Kopaing\RolesPermissions\Helpers;

use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Get the role ID of the authenticated user.
     *
     * @return int|null
     */
    public static function id()
    {
        $user = Auth::user();
        return $user ? $user->role->id : null;
    }

    /**
     * Get the role name of the authenticated user.
     *
     * @return string|null
     */
    public static function name()
    {
        $user = Auth::user();
        return $user ? $user->role->name : null;
    }

    /**
     * Get the permissions of the authenticated user's role.
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public static function permissions()
    {
        $user = Auth::user();
        return $user ? $user->role->permissions : null;
    }

    /**
     * Get the permissions of the authenticated user's role.
     *
     * @param bool $withFeature Whether to include features along with permission names.
     * @return array|null
     */
    public static function permissionsName($withFeature = false)
    {
        $user = Auth::user();

        if (!$user) {
            return null;
        }

        $permissions = $user->role->permissions;

        if ($withFeature) {
            // Assuming the Permission model has a relationship with Feature
            return $permissions->mapWithKeys(function ($permission) {
                return [
                    $permission->id => [
                        'name' => $permission->name,
                        'feature' => $permission->feature->name ?? null // Adjust this based on your actual relationship
                    ]
                ];
            })->toArray();
        }

        return $permissions->pluck('name', 'id')->toArray();
    }

}
