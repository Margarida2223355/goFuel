<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%station_users}}`.
 */
class m241107_192757_create_station_users_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('station_users', [
            'station_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk_station_users', 'station_users', ['station_id', 'user_id']);

        $this->addForeignKey('fk_station_users_station', 'station_users', 'station_id', 'stations', 'id', 'CASCADE');
        $this->addForeignKey('fk_station_users_user', 'station_users', 'user_id', 'user', 'id', 'CASCADE');

        $this->batchInsert('{{%station_users}}', ['station_id', 'user_id'], [
            [2, 1],
            [3, 2],
            [4, 2],
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_station_users_station', 'station_users');
        $this->dropForeignKey('fk_station_users_user', 'station_users');
        $this->dropTable('station_users');
    }
}
