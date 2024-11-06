<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stations}}`.
 */
class m241106_232550_create_stations_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('stations', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'address' => $this->string(255)->notNull(),
            'postal_code' => $this->string(10)->notNull(),
            'manager_id' => $this->integer()->notNull(),
            'phone' => $this->string(15),
        ], 'CHARACTER SET utf8mb4 COLLATE=utf8mb4_0900_ai_ci ENGINE=InnoDB');

        $this->addForeignKey('fk_stations_manager', 'stations', 'manager_id', 'user_info', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_stations_manager', 'stations');
        $this->dropTable('stations');
    }
}
