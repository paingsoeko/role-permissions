<?php

namespace Kopaing\RolesPermissions\Helpers;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Kopaing\RolesPermissions\Models\Feature;
use Kopaing\RolesPermissions\Models\Permission;
use Kopaing\RolesPermissions\Models\Role;
use Kopaing\RolesPermissions\Models\RolePermission;

class PermissionHelper
{
    /**
     * Check if the user has a specific permission.
     *
     * @param int $userId
     * @param string $permissionName
     * @return bool
     */
    public static function hasPermission($roleId, $featureName, $permissionName)
    {
        if (!auth()->id()){
            return false;
        }


        // Get the feature ID by feature name
        $feature = Feature::where('name', $featureName)->first();
        if (!$feature) {
            return false;
        }

        // Get the permission ID by permission name and feature ID
        $permission = $feature->permissions()->where('name', $permissionName)->first();

        if (!$permission) {
            return false;
        }


        $cacheKey = auth()->id().'_role_permissions_' . $roleId;

        // Get cached permissions or store them in the cache
        $permissions = Cache::remember($cacheKey, 60, function () use ($roleId) {
        return RolePermission::where('role_id', $roleId)
                ->pluck('permission_id')
                ->toArray();
        });

        // Check if the permission ID exists in the cached permissions
        return in_array($permission->id, $permissions);

    }

    public static function clearRolePermissionsCache($roleId)
    {
        $cacheKey = auth()->id().'_role_permissions_' . $roleId;
        Cache::forget($cacheKey);
    }

    public static function canViewAny($roleId, $featureName)
    {
        return self::hasPermission($roleId, $featureName, 'view-any');
    }

    public static function canView($roleId, $featureName)
    {
        return self::hasPermission($roleId, $featureName, 'view');
    }

    public static function canCreate($roleId, $featureName)
    {
        return self::hasPermission($roleId, $featureName, 'create');
    }

    public static function canUpdate($roleId, $featureName)
    {
        return self::hasPermission($roleId, $featureName, 'update');
    }

    public static function canDelete($roleId, $featureName)
    {
        return self::hasPermission($roleId, $featureName, 'delete');
    }
}
