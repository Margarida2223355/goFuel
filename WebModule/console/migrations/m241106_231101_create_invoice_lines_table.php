<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoice_lines}}`.
 */
class m241106_231101_create_invoice_lines_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('invoice_lines', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->notNull(),
            'qty' => $this->integer()->notNull(),
            'total' => $this->double()->notNull(),
            'invoice_id' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE=utf8mb4_0900_ai_ci ENGINE=InnoDB');

        $this->addForeignKey('fk_invoice_lines_invoice', 'invoice_lines', 'invoice_id', 'invoices', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_invoice_lines_item', 'invoice_lines', 'item_id', 'items', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_invoice_lines_item', 'invoice_lines');
        $this->dropForeignKey('fk_invoice_lines_invoice', 'invoice_lines');
        $this->dropTable('invoice_lines');
    }
}
