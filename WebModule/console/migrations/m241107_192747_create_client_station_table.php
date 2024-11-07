<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client_station}}`.
 */
class m241107_192747_create_client_station_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('client_station', [
            'client_id' => $this->integer()->notNull(),
            'station_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk_client_station', 'client_station', ['client_id', 'station_id']);

        $this->addForeignKey('fk_client_station_client', 'client_station', 'client_id', 'user', 'id', 'CASCADE');
        $this->addForeignKey('fk_client_station_station', 'client_station', 'station_id', 'stations', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_client_station_client', 'client_station');
        $this->dropForeignKey('fk_client_station_station', 'client_station');
        $this->dropTable('client_station');
    }
}
