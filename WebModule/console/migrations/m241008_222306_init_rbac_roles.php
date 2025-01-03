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

        #region Roles(Create, Add and Assignment)
        //Create roles
        $admin = $auth->createRole('Admin');
        $manager = $auth->createRole('Manager');
        $inCharge = $auth->createRole('Incharge');
        $employee = $auth->createRole('Employee');
        $client = $auth->createRole('Client');

        //Add roles
        $auth->add($admin);
        $auth->add($manager);
        $auth->add($inCharge);
        $auth->add($employee);
        $auth->add($client);

        //Assign roles to created users
        $auth->assign($admin, 1);
        $auth->assign($manager, 2);
        $auth->assign($inCharge, 3);
        $auth->assign($employee, 4);
        $auth->assign($client, 5);
        $auth->assign($client, 6);

        #endregion

        /*$permissions = [
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
                'InvoiceDeletePermission',
            ],
            'ItemController' => [
                'ItemIndexPermission',
                'ItemViewPermission',
                'ItemCreatePermission',
                'ItemUpdatePermission',
                'ItemDeletePermission',
                'ItemAssociatePermission',
                'ItemDeleteAssociationPermission',
                'ItemUpdateAssociationPermission',
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
                'StationAddItemPermission',
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
                'UserBanPermission',
                'UserResetPasswordPermission',
            ],
        ];

        foreach ($permissions as $controller => $actions) {
            foreach ($actions as $action) {
                $permission = $auth->createPermission($action);
                $permission->description = "Permission for {$action}";
                $auth->add($permission);
            }
        }*/

        // Child assignment
        // $auth->addChild($inCharge, $employee);
        // $auth->addChild($manager, $inCharge);
        // $auth->addChild($admin, $manager);
    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        // Recupera as roles
        $admin = $auth->getRole('Admin');
        $manager = $auth->getRole('Manager');
        $incharge = $auth->getRole('Incharge');
        $employee = $auth->getRole('Employee');

        // Remove a hierarquia
        if ($auth->hasChild($admin, $manager)) {
            $auth->removeChild($admin, $manager);
        }
        if ($auth->hasChild($manager, $incharge)) {
            $auth->removeChild($manager, $incharge);
        }
        if ($auth->hasChild($incharge, $employee)) {
            $auth->removeChild($incharge, $employee);
        }

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
                'InvoiceDeletePermission',
            ],
            'ItemController' => [
                'ItemIndexPermission',
                'ItemViewPermission',
                'ItemCreatePermission',
                'ItemUpdatePermission',
                'ItemDeletePermission',
                'ItemAssociatePermission',
                'ItemDeleteAssociationPermission',
                'ItemUpdateAssociationPermission',
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
                'StationAddItemPermission',
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
                'UserBanPermission',
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
    }
    //Permissions e controladores
}
