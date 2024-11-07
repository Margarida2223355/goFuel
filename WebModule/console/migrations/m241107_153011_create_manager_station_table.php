<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%station_items}}`.
 */
class m241106_232317_create_station_items_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('station_items', [
            'id' => $this->primaryKey(),
            'station_id' => $this->integer()->notNull(),
            'item_id' => $this->integer()->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE=utf8mb4_0900_ai_ci ENGINE=InnoDB');

        $this->addForeignKey('fk_station_items_station', 'station_items', 'station_id', 'stations', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_station_items_item', 'station_items', 'item_id', 'items', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_station_items_station', 'station_items');
        $this->dropForeignKey('fk_station_items_item', 'station_items');
        $this->dropTable('station_items');
    }
}
