<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stations}}`.
 */
class m241107_192744_create_stations_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('stations', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'address' => $this->string(),
            'postal_code' => $this->string(),
            'manager_id' => $this->integer(),
            'phone' => $this->string(15),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('stations');
    }
}
