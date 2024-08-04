<?php

namespace Kopaing\RolesPermissions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kopaing\RolePermissions\Events\PermissionUpdated;
use Kopaing\RolesPermissions\Helpers\PermissionHelper;
use Kopaing\RolesPermissions\Models\Feature;
use Kopaing\RolesPermissions\Models\Role;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'feature_id'];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($permission) {
            $roleIds = $permission->roles->pluck('id');
            foreach ($roleIds as $roleId) {
                PermissionHelper::clearRolePermissionsCache($roleId);
            }
        });

        static::deleted(function ($permission) {
            $roleIds = $permission->roles->pluck('id');
            foreach ($roleIds as $roleId) {
                PermissionHelper::clearRolePermissionsCache($roleId);
            }
        });
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
