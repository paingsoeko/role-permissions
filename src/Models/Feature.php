<?php

namespace Kopaing\RolesPermissions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kopaing\RolesPermissions\Models\Permission;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($feature) {
            // Ensure the name is unique
            $existingFeature = static::where('name', $feature->name)->first();
            if ($existingFeature) {
                return false; // Prevent saving if the feature already exists
            }

        });
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
