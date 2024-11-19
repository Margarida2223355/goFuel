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
        ]);

        $this->addPrimaryKey('pk_station_items', 'station_items', ['station_id', 'item_id']);

        $this->addForeignKey('fk_station_items_station', 'station_items', 'station_id', 'stations', 'id', 'CASCADE');
        $this->addForeignKey('fk_station_items_item', 'station_items', 'item_id', 'items', 'id', 'CASCADE');

        $this->batchInsert('{{%station_items}}', [ 'station_id', 'item_id', 'price', 'stock'], [
            [1, 1, 1.3, 5000],
            [1, 2, 1.6, 5000],
            [1, 3, 1, 25],
            [2, 5, 1, 1000],
            [2, 8, 4.3, 1000],
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_station_items_station', 'station_items');
        $this->dropForeignKey('fk_station_items_item', 'station_items');
        $this->dropTable('station_items');
    }
}
