<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%items}}`.
 */
class m241107_192751_create_items_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('items', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'price' => $this->decimal(10, 2),
            'subcategory_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_items_subcategory',
            'items',
            'subcategory_id',
            'subcategories',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_items_subcategory', 'items');
        $this->dropTable('items');
    }
}
