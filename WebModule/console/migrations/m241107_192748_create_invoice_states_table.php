<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoice_states}}`.
 */
class m241107_192748_create_invoice_states_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('invoice_states', [
            'id' => $this->primaryKey(),
            'description' => $this->string()->notNull(),
        ]);

        $this->batchInsert('{{%invoice_states}}', ['id', 'description'], [
            [1, 'Cart'],
            [2, 'Pending'],
            [3, 'Cancelled'],
            [4, 'Finished'],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('invoice_states');
    }
}
