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
            'is_deleted' => $this->boolean()->defaultValue(false)->notNull(),
            'is_banned' => $this->boolean()->defaultValue(false)->notNull(),
        ]);

        $this->addForeignKey(
            'fk_user_info_user',
            'user_info',
            'user_id',
            'user',  // Supondo que existe uma tabela `user`
            'id',
            'CASCADE'
        );

        $this->batchInsert('{{%user_info}}', ['id', 'user_id', 'nif', 'name', 'address', 'postal_code', 'phone'], [
            [1, 1, 123456789, 'Admin', 'Rua Admin 1', '1000-001', '926326333'],
            [2, 2, 987654321, 'Júlio Magalães', 'Rua Julio 2', '1000-002', '911234564'],
            [3, 3, 987654321, 'João Arroios', 'Rua Joao 2', '1000-002', '912234564'],
            [4, 4, 123789456, 'Inês Clemente', 'Rua InCharge 3', '1000-003', '963963963'],
            [5, 5, 456123789, 'Maria do Carmo', 'Rua Employee 4', '1000-004', '914914500'],
            [6, 6, 456123784, 'Ricardo Roldão', 'Rua Client 5', '1000-005', '926926596'],
            [7, 7, 111223344, 'Gilberto Silva', 'Rua Cliente 6', '1000-006', '934567890'],
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_user_info_user', 'user_info');
        $this->dropTable('user_info');
    }
}
