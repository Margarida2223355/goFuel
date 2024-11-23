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
        $inCharge = $auth->createRole('In Charge');
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

        #endregion

        #region Permissions (Create and Add)

        //Category permission
        $auth->add($auth->createPermission('CategoryIndex'));
        $auth->add($auth->createPermission('CategoryView'));
        $auth->add($auth->createPermission('CategoryCreate'));
        $auth->add($auth->createPermission('CategoryUpdate'));
        $auth->add($auth->createPermission('CategoryDelete'));

        //Invoice permission
        $auth->add($auth->createPermission('InvoiceIndex'));
        $auth->add($auth->createPermission('InvoiceView'));
        $auth->add($auth->createPermission('InvoiceFinish'));
        $auth->add($auth->createPermission('InvoiceFindModel'));

        //Item permission
        $auth->add($auth->createPermission('ItemIndex'));
        $auth->add($auth->createPermission('ItemView'));
        $auth->add($auth->createPermission('ItemCreate'));
        $auth->add($auth->createPermission('ItemUpdate'));
        $auth->add($auth->createPermission('ItemAssociate'));
        $auth->add($auth->createPermission('ItemDeleteAssociation'));
        $auth->add($auth->createPermission('ItemUpdateAssociation'));
        $auth->add($auth->createPermission('ItemRestock'));
        $auth->add($auth->createPermission('ItemFindModel'));

        //Station permission
        $auth->add($auth->createPermission('StationIndex'));
        $auth->add($auth->createPermission('StationView'));
        $auth->add($auth->createPermission('StationCreate'));
        $auth->add($auth->createPermission('StationUpdate'));
        $auth->add($auth->createPermission('StationDelete'));
        $auth->add($auth->createPermission('StationFindModel'));

        //StationItem permission
        $auth->add($auth->createPermission('StationItemAssociate'));
        $auth->add($auth->createPermission('StationItemDeleteAssociation'));
        $auth->add($auth->createPermission('StationItemUpdateAssociation'));

        //Subcategory permission
        $auth->add($auth->createPermission('SubcategoryCreate'));
        $auth->add($auth->createPermission('SubcategoryUpdate'));
        $auth->add($auth->createPermission('SubcategoryDelete'));

        //User permission
        $auth->add($auth->createPermission('UserIndex'));
        $auth->add($auth->createPermission('UserView'));
        $auth->add($auth->createPermission('UserChangerole'));
        $auth->add($auth->createPermission('UserCreate'));
        $auth->add($auth->createPermission('UserUpdate'));
        $auth->add($auth->createPermission('UserDelete'));
        $auth->add($auth->createPermission('UserResetPassword'));

        //Userinfo permission
        $auth->add($auth->createPermission('UserinfoIndex'));
        $auth->add($auth->createPermission('UserinfoView'));
        $auth->add($auth->createPermission('UserinfoCreate'));
        $auth->add($auth->createPermission('UserinfoUpdate'));
        $auth->add($auth->createPermission('UserinfoDelete'));

        #endregion

        $permissions = [
            'Employee' => [
                'CategoryIndex',
                'CategoryView',
                'InvoiceIndex',
                'InvoiceView',
                'InvoiceFinish',
                'ItemIndex',
                'ItemView',
                'StationIndex',
                'StationView',
                'UserUpdate',
            ],
            'Incharge' => [
                'ItemRestock',
            ],
            'Manager' => [
                'ItemAssociate',
                'StationItemAssociate',
                'StationItemDeleteAssociation',
                'StationItemUpdateAssociation',
                'StationUpdate',
                'UserIndex',
                'UserView',
                'UserCreate',
                'UserResetPassword',
            ],
            'Admin' => [
                'CategoryCreate',
                'CategoryUpdate',
                'CategoryDelete',
                'ItemCreate',
                'ItemUpdate',
                'StationCreate',
                'StationDelete',
                'SubcategoryCreate',
                'SubcategoryUpdate',
                'SubcategoryDelete',
            ],
        ];

        // Atribui permissões a cada role
        foreach ($permissions as $roleName => $permissionList) {
            $role = $auth->getRole($roleName);
            foreach ($permissionList as $permissionName) {
                $permission = $auth->getPermission($permissionName);
                if ($permission !== null && $role !== null) {
                    $auth->addChild($role, $permission);
                }
            }
        }

        #region Roles and Permissions assignment


        #endregion


        //Child assignment
        $auth->addChild($inCharge, $employee);
        $auth->addChild($manager, $inCharge);
        $auth->addChild($admin, $manager);
    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
    //Permissions e controladores
}
