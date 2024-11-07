<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoice_states}}`.
 */
class m241107_192749_create_invoice_states_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('invoice_states', [
            'id' => $this->primaryKey(),
            'state' => $this->string()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('invoice_states');
    }
}
