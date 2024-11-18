<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoice_lines}}`.
 */
class m241107_192750_create_invoice_lines_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('invoice_lines', [
            'id' => $this->primaryKey(),
            'invoice_id' => $this->integer()->notNull(),
            'description' => $this->string()->notNull(),
            'amount' => $this->decimal(10, 2),
        ]);

        $this->addForeignKey(
            'fk_invoice_lines_invoice',
            'invoice_lines',
            'invoice_id',
            'invoices',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_invoice_lines_invoice', 'invoice_lines');
        $this->dropTable('invoice_lines');
    }
}
