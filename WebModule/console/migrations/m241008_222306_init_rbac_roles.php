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

        // Criando as roles
        $admin = $auth->createRole('Admin');
        $manager = $auth->createRole('Manager');
        $inCharge = $auth->createRole('In Charge');
        $employee = $auth->createRole('Employee');
        $client = $auth->createRole('Client');

        // Adicionando as roles no sistema
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

}
