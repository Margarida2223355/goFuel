<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoices}}`.
 */
class m241107_192749_create_invoices_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('invoices', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'state_id' => $this->integer()->notNull(),
            'date' => $this->dateTime()->notNull(),
        ]);

        $this->addForeignKey('fk_invoices_user', 'invoices', 'user_id', 'user', 'id', 'CASCADE');
        $this->addForeignKey('fk_invoices_state', 'invoices', 'state_id', 'invoice_states', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_invoices_user', 'invoices');
        $this->dropForeignKey('fk_invoices_state', 'invoices');
        $this->dropTable('invoices');
    }
}
