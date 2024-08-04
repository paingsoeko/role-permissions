<?php


namespace Kopaing\RolesPermissions\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kopaing\RolesPermissions\Helpers\PermissionHelper;

class RolePermission extends Model
{
    use HasFactory;

    protected $fillable = ['role_id', 'permission_id'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($rolePermission) {
            PermissionHelper::clearRolePermissionsCache($rolePermission->role_id);
        });

        static::updated(function ($rolePermission) {
            PermissionHelper::clearRolePermissionsCache($rolePermission->role_id);
        });

        static::deleted(function ($rolePermission) {
            PermissionHelper::clearRolePermissionsCache($rolePermission->role_id);
        });
    }
}
