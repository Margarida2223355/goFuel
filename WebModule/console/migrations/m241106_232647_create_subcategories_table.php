<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subcategories}}`.
 */
class m241106_232647_create_subcategories_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('subcategories', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'category_id' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE=utf8mb4_0900_ai_ci ENGINE=InnoDB');

        $this->addForeignKey('fk_subcategories_category', 'subcategories', 'category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_subcategories_category', 'subcategories');
        $this->dropTable('subcategories');
    }
}
