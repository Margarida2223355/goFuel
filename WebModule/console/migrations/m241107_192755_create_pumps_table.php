<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pumps}}`.
 */
class m241107_192755_create_pumps_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('pumps', [
            'id' => $this->primaryKey(),
            'station_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_pumps_station',
            'pumps',
            'station_id',
            'stations',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_pumps_station', 'pumps');
        $this->dropTable('pumps');
    }
}
