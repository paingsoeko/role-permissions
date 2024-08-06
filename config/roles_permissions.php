<?php

return [

    'models' => [
        'feature' => Kopaing\RolesPermissions\Models\Feature::class,
        'role' => Kopaing\RolesPermissions\Models\Role::class,
        'permission' => Kopaing\RolesPermissions\Models\Permission::class,
        'role_permission' => Kopaing\RolesPermissions\Models\RolePermission::class,
        'context' => Kopaing\RolesPermissions\Models\Context::class,
    ],




    //Declare Feature and Permissions
    'features' => [
        'User' => [
            'default-permissions' => ['view-any', 'view', 'create', 'update', 'delete'],
            'custom-permissions' => ['import'],
        ],

        'Role' => [
            'default-permissions' => ['view-any', 'view', 'create', 'update', 'delete'],
        ],


////        Add new feature and permissions
////        for custom permission 'custom' => []
////        Dynamic Permissions based on context, use  'context' => []
//        '' => [
//            'default' => ['view-any', 'view', 'create', 'update', 'delete'],
//        ],

    ],
];
