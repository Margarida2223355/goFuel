<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%items}}`.
 */
class m241107_192747_create_items_table extends Migration
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
        $this->batchInsert('{{%items}}', ['id', 'name', 'subcategory_id', 'price'], [
            [1, 'Unleaded 95 - 1L', 1, 1000],
            [2, 'Unleaded 98 - 1L', 2, 1000],
            [3, 'Diesel Regular - 1L', 3, 1200],
            [4, 'Diesel Premium - 1L', 4, 1200],
            [5, 'Pack of Chips', 5, 24],
            [8, 'Car Charger', 8, 16],
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_items_subcategory', 'items');
        $this->dropTable('items');
    }
}
