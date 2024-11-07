<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%manager_station}}`.
 */
class m241106_231529_create_manager_station_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('manager_station', [
            'manager_id' => $this->integer()->notNull(),
            'station_id' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE=utf8mb4_0900_ai_ci ENGINE=InnoDB');

        $this->addPrimaryKey('pk_manager_station', 'manager_station', ['manager_id', 'station_id']);
        $this->addForeignKey('fk_manager', 'manager_station', 'manager_id', 'user_info', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_station', 'manager_station', 'station_id', 'stations', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_station', 'manager_station');
        $this->dropForeignKey('fk_manager', 'manager_station');
        $this->dropTable('manager_station');
    }
}
