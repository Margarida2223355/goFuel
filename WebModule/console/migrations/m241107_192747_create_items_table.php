<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%items}}`.
 */
class m241107_192747_create_items_table extends Migration
{
    public function safeUp()
    {
        $imagePath = __DIR__ . '/../../images/items/';

        $this->createTable('items', [
            'id' => $this->primaryKey(),
            'description' => $this->string()->notNull(),
            'subcategory_id' => $this->integer()->notNull(),
            'restock_qty' => $this->integer()->notNull(),
            'is_deleted' => $this->boolean()->defaultValue(false)->notNull(),
            'image' => 'MEDIUMBLOB'
        ]);

        $this->addForeignKey(
            'fk_items_subcategory',
            'items',
            'subcategory_id',
            'subcategories',
            'id',
            'CASCADE'
        );
        $this->batchInsert('{{%items}}', ['id', 'description', 'subcategory_id', 'restock_qty', 'image'], [
            [1, 'Unleaded 95 - 1L', 1, 1000, base64_encode(file_get_contents($imagePath . 'combustivel.png'))],
            [2, 'Unleaded 98 - 1L', 2, 1000, base64_encode(file_get_contents($imagePath . 'combustivel.png'))],
            [3, 'Diesel Regular - 1L', 3, 1200, base64_encode(file_get_contents($imagePath . 'combustivel.png'))],
            [4, 'Diesel Premium - 1L', 4, 1200, base64_encode(file_get_contents($imagePath . 'combustivel.png'))],
            [5, 'Pack of Chips', 5, 24, base64_encode(file_get_contents($imagePath . 'chips.png'))],
            [6, 'Car Charger', 8, 16, base64_encode(file_get_contents($imagePath . 'charger.png'))],
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_items_subcategory', 'items');
        $this->dropTable('items');
    }
}
