<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoice_states}}`.
 */
class m241106_231144_create_invoice_states_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('invoice_states', [
            'id' => $this->primaryKey(),
            'description' => $this->string(255)->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE=utf8mb4_0900_ai_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('invoice_states');
    }
}
