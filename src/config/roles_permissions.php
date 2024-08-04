<?php

return [

    'models' => [
        'feature' => Kopaing\RolesPermissions\Models\Feature::class,
        'role' => Kopaing\RolesPermissions\Models\Role::class,
        'permission' => Kopaing\RolesPermissions\Models\Permission::class,
        'role_permission' => Kopaing\RolesPermissions\Models\RolePermission::class,
    ],




    //Declare Feature and Permissions
    'features' => [
        'User' => [
            'default' => ['view-any', 'view', 'create', 'update', 'delete'],
            'custom' => ['import'],
        ],

        'Role' => [
            'default' => ['view-any', 'view', 'create', 'update', 'delete'],
            'custom' => [],
        ],

////        Add new feature and permissions
//        '' => [
//            'default' => ['view-any', 'view', 'create', 'update', 'delete'],
//            'custom' => [],
//        ],

    ],
];
