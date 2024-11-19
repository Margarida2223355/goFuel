<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_info}}`.
 */
class m241107_192746_create_user_info_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('user_info', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'nif' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'address' => $this->string(),
            'postal_code' => $this->string(),
            'phone' => $this->string(15),
        ]);

        $this->addForeignKey(
            'fk_user_info_user',
            'user_info',
            'user_id',
            'user',  // Supondo que existe uma tabela `user`
            'id',
            'CASCADE'
        );

        $this->batchInsert('{{%user_info}}', ['id', 'user_id', 'nif', 'full_name', 'address', 'postal_code', 'phone'], [
            [1, 1, 123456789, 'Admin', 'Rua Admin 1', '1000-001', '0'],
            [2, 2, 987654321, 'Manager', 'Rua Manager 2', '1000-002', '911234564'],
            [3, 3, 123789456, 'In Charge', 'Rua InCharge 3', '1000-003', '963963963'],
            [4, 4, 456123789, 'Employee', 'Rua Employee 4', '1000-004', '914914500'],
            [5, 5, 456123784, 'Client', 'Rua Employee 4', '1000-004', '926926596'],
            [6, 6, 465465444, 'Francisco Roldão', 'Rua do Rei', '2365-886', '265265265'],
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_user_info_user', 'user_info');
        $this->dropTable('user_info');
    }
}
