<?php

return [
    [
        'parent' => 'Admin',
        'child' => 'CategoryCreatePermission',
    ],
    [
        'parent' => 'Admin',
        'child' => 'CategoryDeletePermission',
    ],
    [
        'parent' => 'Employee',
        'child' => 'CategoryIndexPermission',
    ],
    [
        'parent' => 'Admin',
        'child' => 'CategoryUpdatePermission',
    ],
    [
        'parent' => 'Employee',
        'child' => 'CategoryViewPermission',
    ],
    [
        'parent' => 'Incharge',
        'child' => 'Employee',
    ],
    [
        'parent' => 'Manager',
        'child' => 'Incharge',
    ],
    [
        'parent' => 'Employee',
        'child' => 'InvoiceFinishPermission',
    ],
    [
        'parent' => 'Employee',
        'child' => 'InvoiceIndexPermission',
    ],
    [
        'parent' => 'Employee',
        'child' => 'InvoiceViewPermission',
    ],
    [
        'parent' => 'Manager',
        'child' => 'ItemAssociatePermission',
    ],
    [
        'parent' => 'Admin',
        'child' => 'ItemCreatePermission',
    ],
    [
        'parent' => 'Employee',
        'child' => 'ItemIndexPermission',
    ],
    [
        'parent' => 'Incharge',
        'child' => 'ItemRestockPermission',
    ],
    [
        'parent' => 'Admin',
        'child' => 'ItemUpdatePermission',
    ],
    [
        'parent' => 'Employee',
        'child' => 'ItemViewPermission',
    ],
    [
        'parent' => 'Admin',
        'child' => 'Manager',
    ],
    [
        'parent' => 'Employee',
        'child' => 'SiteActionsPermission',
    ],
    [
        'parent' => 'Employee',
        'child' => 'SiteIndexPermission',
    ],
    [
        'parent' => 'Employee',
        'child' => 'SiteLoginPermission',
    ],
    [
        'parent' => 'Employee',
        'child' => 'SiteLogoutPermission',
    ],
    [
        'parent' => 'Admin',
        'child' => 'StationCreatePermission',
    ],
    [
        'parent' => 'Admin',
        'child' => 'StationDeletePermission',
    ],
    [
        'parent' => 'Employee',
        'child' => 'StationIndexPermission',
    ],
    [
        'parent' => 'Manager',
        'child' => 'StationUpdatePermission',
    ],
    [
        'parent' => 'Employee',
        'child' => 'StationViewPermission',
    ],
    [
        'parent' => 'Admin',
        'child' => 'SubcategoryCreatePermission',
    ],
    [
        'parent' => 'Admin',
        'child' => 'SubcategoryDeletePermission',
    ],
    [
        'parent' => 'Admin',
        'child' => 'SubcategoryUpdatePermission',
    ],
    [
        'parent' => 'Manager',
        'child' => 'UserChangerolePermission',
    ],
    [
        'parent' => 'Manager',
        'child' => 'UserCreatePermission',
    ],
    [
        'parent' => 'Admin',
        'child' => 'UserDeletePermission',
    ],
    [
        'parent' => 'Manager',
        'child' => 'UserIndexPermission',
    ],
    [
        'parent' => 'Manager',
        'child' => 'UserResetPasswordPermission',
    ],
    [
        'parent' => 'Employee',
        'child' => 'UserUpdatePermission',
    ],
    [
        'parent' => 'Manager',
        'child' => 'UserViewPermission',
    ],
];
