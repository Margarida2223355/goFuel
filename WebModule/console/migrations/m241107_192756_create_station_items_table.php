<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%station_items}}`.
 */
class m241107_192756_create_station_items_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('station_items', [
            'station_id' => $this->integer()->notNull(),
            'item_id' => $this->integer()->notNull(),
            'price' => $this->decimal(10, 2),
            'stock' => $this->integer()->notNull()->defaultValue(0),
            'is_deleted' => $this->boolean()->defaultValue(false)->notNull(),
        ]);

        $this->addPrimaryKey('pk_station_items', 'station_items', ['station_id', 'item_id']);

        $this->addForeignKey('fk_station_items_station', 'station_items', 'station_id', 'stations', 'id', 'CASCADE');
        $this->addForeignKey('fk_station_items_item', 'station_items', 'item_id', 'items', 'id', 'CASCADE');

        $this->batchInsert(
            '{{%station_items}}',
            ['station_id', 'item_id', 'price', 'stock'],
            [
                [1, 1, 1.56, 1000],
                [1, 2, 1.63, 1000],
                [1, 3, 1.61, 1200],
                [1, 4, 1.72, 1200],
                [1, 6, 6.99, 16],
                [2, 1, 1.50, 1000],
                [2, 2, 1.55, 1000],
                [2, 3, 1.60, 1200],
                [2, 4, 1.67, 1200],
                [2, 5, 2.39, 24],
                [3, 1, 1.73, 1000],
                [3, 3, 1.90, 1200],
                [3, 5, 1.40, 48],
            ]
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_station_items_station', 'station_items');
        $this->dropForeignKey('fk_station_items_item', 'station_items');
        $this->dropTable('station_items');
    }
}
