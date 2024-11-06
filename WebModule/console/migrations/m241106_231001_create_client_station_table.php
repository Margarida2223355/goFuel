<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client_station}}`.
 */
class m241106_231001_create_client_station_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('client_station', [
            'id_client' => $this->integer()->notNull(),
            'id_station' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE=utf8mb4_0900_ai_ci ENGINE=InnoDB');

        $this->addPrimaryKey('pk_client_station', 'client_station', ['id_client', 'id_station']);
        $this->addForeignKey('fk_id_client', 'client_station', 'id_client', 'user', 'id', 'CASCADE');
        $this->addForeignKey('fk_id_station', 'client_station', 'id_station', 'user_info', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_id_station', 'client_station');
        $this->dropForeignKey('fk_id_client', 'client_station');
        $this->dropTable('client_station');
    }
}
