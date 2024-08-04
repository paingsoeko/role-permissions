<?php

namespace Kopaing\RolesPermissions;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Kopaing\RolesPermissions\Console\Commands\UpdatePermissions;
use Kopaing\RolesPermissions\Middleware\CheckPermissions;


class RolesPermissionsServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        // Publish the middleware
        $router->aliasMiddleware('check.permissions', CheckPermissions::class);


        // Register Blade directive
        Blade::directive('check', function ($expression) {
            list($permissionName, $featureName) = explode(',', $expression);

            $permissionName = trim($permissionName, "'\" ");
            $featureName = trim($featureName, "'\" ");

            return "<?php if (\\Kopaing\\RolesPermissions\\Helpers\\PermissionHelper::hasPermission(auth()->user()->role_id, '$featureName', '$permissionName')): ?>";
        });

        Blade::directive('checkViewAny', function ($expression) {
            $featureName = trim($expression, "'\" ");
            return "<?php if (\\Kopaing\\RolesPermissions\\Helpers\\PermissionHelper::canViewAny(auth()->user()->role_id, '$featureName')): ?>";
        });

        Blade::directive('checkView', function ($expression) {
            $featureName = trim($expression, "'\" ");
            return "<?php if (\\Kopaing\\RolesPermissions\\Helpers\\PermissionHelper::canView(auth()->user()->role_id, '$featureName')): ?>";
        });

        Blade::directive('checkCreate', function ($expression) {
            $featureName = trim($expression, "'\" ");
            return "<?php if (\\Kopaing\\RolesPermissions\\Helpers\\PermissionHelper::canCreate(auth()->user()->role_id, '$featureName')): ?>";
        });

        Blade::directive('checkUpdate', function ($expression) {
            $featureName = trim($expression, "'\" ");
            return "<?php if (\\Kopaing\\RolesPermissions\\Helpers\\PermissionHelper::canUpdate(auth()->user()->role_id, '$featureName')): ?>";
        });

        Blade::directive('checkDelete', function ($expression) {
            $featureName = trim($expression, "'\" ");
            return "<?php if (\\Kopaing\\RolesPermissions\\Helpers\\PermissionHelper::canDelete(auth()->user()->role_id, '$featureName')): ?>";
        });

        Blade::directive('endcheck', function () {
            return "<?php endif; ?>";
        });

        // Register the console command
        if ($this->app->runningInConsole()) {
            $this->commands([
                UpdatePermissions::class,
            ]);
        }

        // Publish config
        $this->publishes([
            __DIR__ . '/config/roles_permissions.php' => config_path('roles_permissions.php'),
        ], 'config');


        // Publish migrations
        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations'),
        ], 'migrations');

        // Load package migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Publish models
        $this->publishes([
            __DIR__ . '/Models/' => base_path('/app/Models/'),
        ], 'models');

    }

    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/config/roles_permissions.php', 'roles_permissions'
        );
    }
}
