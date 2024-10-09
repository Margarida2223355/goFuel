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

        // Se quiser adicionar permissões específicas, faça isso aqui.
        // Exemplo de permissão:
        // $viewInvoices = $auth->createPermission('viewInvoices');
        // $auth->add($viewInvoices);
        // $auth->addChild($manager, $viewInvoices);

        // Atribuir uma role ao usuário (exemplo: Admin ao usuário de ID 1)
        // Você pode modificar ou adicionar mais atribuições conforme necessário
        $auth->assign($admin, 1); // Admin atribuído ao usuário com ID 1
    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        // Remover todas as roles
        $auth->removeAll();
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241008_222306_init_rbac_roles cannot be reverted.\n";

        return false;
    }
    */
}
