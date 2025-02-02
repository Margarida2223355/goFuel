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

        $this->batchInsert(
            '{{%invoice_lines}}',
            ['id', 'item_id', 'qty', 'total', 'invoice_id'],
            [
                [1, 1, 12.82, 20, 1],
                [2, 6, 1, 6.99, 1],
                [3, 1, 12, 18, 2],
                [4, 5, 2, 4.78, 2],
                [5, 2, 9.68, 15, 3],
                [6, 5, 1, 2.39, 3],
                [7, 3, 26.32, 50, 4],
                [8, 3, 15.53, 25, 5],
                [9, 5, 2, 4.78, 6],
                [10, 3, 15.79, 30, 7],
                [11, 3, 18.42, 35, 8],
            ]
        );
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
