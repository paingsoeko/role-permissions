<?php


namespace Kopaing\RolesPermissions\Models;


use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kopaing\RolesPermissions\Helpers\PermissionHelper;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($role) {
            PermissionHelper::clearRolePermissionsCache($role->id);
        });

        static::deleting(function ($role) {
            if ($role->isDefaultRole()) {
                throw new \Exception('Cannot delete default role.');
            }

            if ($role->hasUsers()) {
                throw new \Exception('Cannot delete role assigned to users.');
            }
            PermissionHelper::clearRolePermissionsCache($role->id);
        });
    }

    public function isDefaultRole()
    {
        // Assuming 'Administrator' is the name of your default role
        return $this->name === 'Administrator';
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    public function hasUsers()
    {
        return $this->users()->count() > 0;
    }
}
