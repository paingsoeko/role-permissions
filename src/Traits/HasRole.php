<?php
namespace Kopaing\RolesPermissions\Traits;

use Kopaing\RolesPermissions\Models\Role;

trait HasRole
{
    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
