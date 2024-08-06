<?php

namespace Kopaing\RolesPermissions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Context extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'context_permissions');
    }
}
