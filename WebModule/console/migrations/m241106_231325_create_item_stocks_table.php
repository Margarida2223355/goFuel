<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%item_stocks}}`.
 */
class m241106_231325_create_item_stocks_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('item_stocks', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->notNull(),
            'station_id' => $this->integer()->notNull(),
            'stock' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE=utf8mb4_0900_ai_ci ENGINE=InnoDB');

        $this->addForeignKey('fk_item_stocks_item', 'item_stocks', 'item_id', 'items', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_item_stocks_station', 'item_stocks', 'station_id', 'stations', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_item_stocks_station', 'item_stocks');
        $this->dropForeignKey('fk_item_stocks_item', 'item_stocks');
        $this->dropTable('item_stocks');
    }
}
