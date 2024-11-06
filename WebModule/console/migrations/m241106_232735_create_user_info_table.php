<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_info}}`.
 */
class m241106_232735_create_user_info_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('user_info', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'tax_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'address' => $this->string(255),
            'postal_code' => $this->string(10),
            'phone' => $this->string(15),
        ], 'CHARACTER SET utf8mb4 COLLATE=utf8mb4_0900_ai_ci ENGINE=InnoDB');

        $this->addForeignKey('fk_user_info_user', 'user_info', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_user_info_user', 'user_info');
        $this->dropTable('user_info');
    }
}
