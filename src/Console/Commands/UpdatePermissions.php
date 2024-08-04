<?php

namespace Kopaing\RolesPermissions\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Kopaing\RolesPermissions\Models\Feature;
use Kopaing\RolesPermissions\Models\Permission;
use Kopaing\RolesPermissions\Models\Role;

class UpdatePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update features and permissions in the database from the configuration file';

    public function __construct()
    {
        parent::__construct();
    }

    protected function transformFeatureName($featureName)
    {
        return Str::slug(Str::lower($featureName));
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $features = config('roles_permissions.features');

        foreach ($features as $featureName => $permissions) {
            // Transform feature name
            $transformedName = $this->transformFeatureName($featureName);

            // Ensure the feature exists
            $feature = Feature::firstOrCreate(['name' => $transformedName]);

            // Create default permissions
            foreach ($permissions['default'] as $permissionName) {
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'feature_id' => $feature->id,
                ]);
            }

            // Create custom permissions
            foreach ($permissions['custom'] as $permissionName) {
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'feature_id' => $feature->id,
                ]);
            }
        }


        $defaultRole = Role::where('name', 'Administrator')->first();

        if (!$defaultRole) {
            $defaultRole = Role::firstOrCreate(['name' => 'Administrator']);
        }

        // Get all permissions for all features
        $features = Feature::with('permissions')->get();
        $allPermissions = $features->flatMap(function ($feature) {
            return $feature->permissions;
        });

        // Sync permissions with the default role
        $defaultRole->permissions()->sync($allPermissions->pluck('id')->toArray());

        $this->info('Features and permissions updated successfully and Permissions updated successfully for the default role.');
    }
}
