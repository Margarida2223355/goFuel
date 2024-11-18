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
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_station_items_station', 'station_items');
        $this->dropForeignKey('fk_station_items_item', 'station_items');
        $this->dropTable('station_items');
    }
}
