<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pumps}}`.
 */
class m241106_232240_create_pumps_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('pumps', [
            'id' => $this->primaryKey(),
            'station_id' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE=utf8mb4_0900_ai_ci ENGINE=InnoDB');

        $this->addForeignKey('fk_pumps_station', 'pumps', 'station_id', 'stations', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_pumps_station', 'pumps');
        $this->dropTable('pumps');
    }
}
