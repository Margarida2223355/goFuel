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

        $admin = $auth->createRole('Admin');
        $manager = $auth->createRole('Manager');
        $inCharge = $auth->createRole('In Charge');
        $employee = $auth->createRole('Employee');
        $client = $auth->createRole('Client');


        $auth->add($admin);
        $auth->add($manager);
        $auth->add($inCharge);
        $auth->add($employee);
        $auth->add($client);


        $auth->assign($admin, 1);
    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
//Permissions e controladores
}
