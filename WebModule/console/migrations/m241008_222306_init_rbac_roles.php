<?php

use yii\db\Migration;

/**
 * Class m241008_222306_init_rbac_roles
 */
class m241008_222306_init_rbac_roles extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        #region Roles (Create, Add, and Assignment)
        // Create roles
        $admin = $auth->createRole('Admin');
        $manager = $auth->createRole('Manager');
        $inCharge = $auth->createRole('Incharge');
        $employee = $auth->createRole('Employee');
        $client = $auth->createRole('Client');

        // Add roles
        $auth->add($admin);
        $auth->add($manager);
        $auth->add($inCharge);
        $auth->add($employee);
        $auth->add($client);

        // Assign roles to created users
        $auth->assign($admin, 1);
        $auth->assign($manager, 2);
        $auth->assign($inCharge, 3);
        $auth->assign($employee, 4);
        $auth->assign($client, 5);
        $auth->assign($client, 6);
        #endregion

        #region Permissions
        $permissions = [
            'CategoryController' => [
                'CategoryIndexPermission',
                'CategoryViewPermission',
                'CategoryCreatePermission',
                'CategoryUpdatePermission',
                'CategoryDeletePermission',
            ],
            'InvoiceController' => [
                'InvoiceIndexPermission',
                'InvoiceViewPermission',
                'InvoiceFinishPermission',
            ],
            'ItemController' => [
                'ItemIndexPermission',
                'ItemViewPermission',
                'ItemCreatePermission',
                'ItemUpdatePermission',
                'ItemAssociatePermission',
                'ItemRestockPermission',
            ],
            'SiteController' => [
                'SiteActionsPermission',
                'SiteIndexPermission',
                'SiteLoginPermission',
                'SiteLogoutPermission',
            ],
            'StationController' => [
                'StationIndexPermission',
                'StationViewPermission',
                'StationCreatePermission',
                'StationUpdatePermission',
                'StationDeletePermission',
            ],
            'StationItemController' => [
                'StationItemAssociatePermission',
                'StationItemDeleteAssociationPermission',
                'StationItemUpdateAssociationPermission',
            ],
            'SubcategoryController' => [
                'SubcategoryCreatePermission',
                'SubcategoryUpdatePermission',
                'SubcategoryDeletePermission',
            ],
            'UserController' => [
                'UserIndexPermission',
                'UserViewPermission',
                'UserChangerolePermission',
                'UserCreatePermission',
                'UserUpdatePermission',
                'UserDeletePermission',
                'UserResetPasswordPermission',
            ],
        ];

        // Add permissions
        foreach ($permissions as $controller => $actions) {
            foreach ($actions as $action) {
                $permission = $auth->createPermission($action);
                $permission->description = "Permission for {$action}";
                $auth->add($permission);
            }
        }
        #endregion

        #region Role-Permission Assignments
        // Associate permissions with roles
        $rolePermissions = [
            'Admin' => [
                'CategoryCreatePermission',
                'CategoryUpdatePermission',
                'CategoryDeletePermission',
                'ItemCreatePermission',
                'ItemUpdatePermission',
                'StationCreatePermission',
                'StationDeletePermission',
                'SubcategoryCreatePermission',
                'SubcategoryUpdatePermission',
                'SubcategoryDeletePermission',
                'UserDeletePermission',
            ],
            'Manager' => [
                'ItemAssociatePermission',
                'StationUpdatePermission',
                'UserIndexPermission',
                'UserViewPermission',
                'UserChangerolePermission',
                'UserCreatePermission',
                'UserResetPasswordPermission',
            ],
            'Incharge' => [
                'ItemRestockPermission',
            ],
            'Employee' => [
                'CategoryIndexPermission',
                'CategoryViewPermission',
                'InvoiceIndexPermission',
                'InvoiceViewPermission',
                'InvoiceFinishPermission',
                'ItemIndexPermission',
                'ItemViewPermission',
                'StationIndexPermission',
                'StationViewPermission',
                'SiteActionsPermission',
                'SiteIndexPermission',
                'SiteLoginPermission',
                'SiteLogoutPermission',
                'UserUpdatePermission',
            ],
        ];

        foreach ($rolePermissions as $roleName => $roleActions) {
            $role = $auth->getRole($roleName);
            foreach ($roleActions as $action) {
                $permission = $auth->getPermission($action);
                $auth->addChild($role, $permission);
            }
        }

        // Add role hierarchy
        $auth->addChild($inCharge, $employee);
        $auth->addChild($manager, $inCharge);
        $auth->addChild($admin, $manager);
        #endregion
    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        // Retrieve roles
        $admin = $auth->getRole('Admin');
        $manager = $auth->getRole('Manager');
        $inCharge = $auth->getRole('Incharge');
        $employee = $auth->getRole('Employee');

        // Remove role hierarchy
        if ($auth->hasChild($admin, $manager)) {
            $auth->removeChild($admin, $manager);
        }
        if ($auth->hasChild($manager, $inCharge)) {
            $auth->removeChild($manager, $inCharge);
        }
        if ($auth->hasChild($inCharge, $employee)) {
            $auth->removeChild($inCharge, $employee);
        }

        // Remove permissions
        $permissions = [
            'CategoryController' => [
                'CategoryIndexPermission',
                'CategoryViewPermission',
                'CategoryCreatePermission',
                'CategoryUpdatePermission',
                'CategoryDeletePermission',
            ],
            'InvoiceController' => [
                'InvoiceIndexPermission',
                'InvoiceViewPermission',
                'InvoiceFinishPermission',
            ],
            'ItemController' => [
                'ItemIndexPermission',
                'ItemViewPermission',
                'ItemCreatePermission',
                'ItemUpdatePermission',
                'ItemAssociatePermission',
                'ItemRestockPermission',
            ],
            'SiteController' => [
                'SiteActionsPermission',
                'SiteIndexPermission',
                'SiteLoginPermission',
                'SiteLogoutPermission',
            ],
            'StationController' => [
                'StationIndexPermission',
                'StationViewPermission',
                'StationCreatePermission',
                'StationUpdatePermission',
                'StationDeletePermission',
            ],
            'StationItemController' => [
                'StationItemAssociatePermission',
                'StationItemDeleteAssociationPermission',
                'StationItemUpdateAssociationPermission',
            ],
            'SubcategoryController' => [
                'SubcategoryCreatePermission',
                'SubcategoryUpdatePermission',
                'SubcategoryDeletePermission',
            ],
            'UserController' => [
                'UserIndexPermission',
                'UserViewPermission',
                'UserChangerolePermission',
                'UserCreatePermission',
                'UserUpdatePermission',
                'UserDeletePermission',
                'UserResetPasswordPermission',
            ],
        ];

        foreach ($permissions as $actions) {
            foreach ($actions as $action) {
                $permission = $auth->getPermission($action);
                if ($permission) {
                    $auth->remove($permission);
                }
            }
        }

        // Remove roles
        $auth->remove($admin);
        $auth->remove($manager);
        $auth->remove($inCharge);
        $auth->remove($employee);
    }
}
