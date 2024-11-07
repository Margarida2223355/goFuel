<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories}}`.
 */
class m241106_230900_create_categories_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE=utf8mb4_0900_ai_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('categories');
    }
}
