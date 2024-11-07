<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%station_users}}`.
 */
class m241106_232502_create_station_users_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('station_users', [
            'user_id' => $this->integer()->notNull(),
            'station_id' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE=utf8mb4_0900_ai_ci ENGINE=InnoDB');

        $this->addPrimaryKey('pk_station_users', 'station_users', ['user_id', 'station_id']);
        $this->addForeignKey('fk_station_users_user', 'station_users', 'user_id', 'user_info', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_station_users_station', 'station_users', 'station_id', 'stations', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_station_users_user', 'station_users');
        $this->dropForeignKey('fk_station_users_station', 'station_users');
        $this->dropTable('station_users');
    }
}
