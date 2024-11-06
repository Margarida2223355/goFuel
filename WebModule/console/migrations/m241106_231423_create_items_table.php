<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%items}}`.
 */
class m241106_231423_create_items_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('items', [
            'id' => $this->primaryKey(),
            'description' => $this->string(255)->notNull(),
            'subcategory_id' => $this->integer()->notNull(),
            'restock_qty' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE=utf8mb4_0900_ai_ci ENGINE=InnoDB');

        $this->addForeignKey('fk_items_subcategory', 'items', 'subcategory_id', 'subcategories', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_items_subcategory', 'items');
        $this->dropTable('items');
    }
}
