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
            'national_id' => $this->string()->notNull(),
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
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_user_info_user', 'user_info');
        $this->dropTable('user_info');
    }
}
