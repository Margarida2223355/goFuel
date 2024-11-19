<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%manager_station}}`.
 */
class m241107_192754_create_manager_station_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('manager_station', [
            'manager_id' => $this->integer()->notNull(),
            'station_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk_manager_station', 'manager_station', ['manager_id', 'station_id']);

        $this->addForeignKey('fk_manager_station_manager', 'manager_station', 'manager_id', 'user', 'id', 'CASCADE');
        $this->addForeignKey('fk_manager_station_station', 'manager_station', 'station_id', 'stations', 'id', 'CASCADE');

        $this->batchInsert('{{%manager_station}}', ['manager_id', 'station_id'], [
            [3, 1],
            [3, 2],
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_manager_station_manager', 'manager_station');
        $this->dropForeignKey('fk_manager_station_station', 'manager_station');
        $this->dropTable('manager_station');
    }
}
