<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoice_lines}}`.
 */
class m241107_192750_create_invoice_lines_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%invoice_lines}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->notNull(),
            'qty' => $this->double()->notNull(),
            'total' => $this->double()->notNull(),
            'invoice_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            '{{%idx-invoice_lines-invoice_id}}',
            '{{%invoice_lines}}',
            'invoice_id'
        );
        $this->createIndex(
            '{{%idx-invoice_lines-item_id}}',
            '{{%invoice_lines}}',
            'item_id'
        );

        $this->addForeignKey(
            '{{%fk-invoice_lines-invoice_id}}',
            '{{%invoice_lines}}',
            'invoice_id',
            '{{%invoices}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->addForeignKey(
            '{{%fk-invoice_lines-item_id}}',
            '{{%invoice_lines}}',
            'item_id',
            '{{%items}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->batchInsert('{{%invoice_lines}}', ['id', 'item_id', 'qty', 'total', 'invoice_id'], [
            [10, 5, 2, 2.0, 8],
            [11, 2, 1, 1.5, 10],
            [12, 1, 10, 13.0, 11],
            [17, 2, 1, 1.5, 12],
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-invoice_lines-invoice_id}}',
            '{{%invoice_lines}}'
        );
        $this->dropForeignKey(
            '{{%fk-invoice_lines-item_id}}',
            '{{%invoice_lines}}'
        );

        $this->dropIndex(
            '{{%idx-invoice_lines-invoice_id}}',
            '{{%invoice_lines}}'
        );
        $this->dropIndex(
            '{{%idx-invoice_lines-item_id}}',
            '{{%invoice_lines}}'
        );

        $this->dropTable('{{%invoice_lines}}');
    }
}
