<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoices}}`.
 */
class m241107_192749_create_invoices_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%invoices}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'station_id' => $this->integer()->notNull(),
            'invoice_date' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'total' => $this->double()->notNull(),
            'state_id' => $this->integer()->notNull()->defaultValue(2),
            'code' => $this->string(45)->defaultValue(null),
        ]);

        $this->createIndex(
            '{{%idx-invoices-station_id}}',
            '{{%invoices}}',
            'station_id'
        );
        $this->createIndex(
            '{{%idx-invoices-state_id}}',
            '{{%invoices}}',
            'state_id'
        );
        $this->createIndex(
            '{{%idx-invoices-client_id}}',
            '{{%invoices}}',
            'client_id'
        );

        $this->addForeignKey(
            '{{%fk-invoices-station_id}}',
            '{{%invoices}}',
            'station_id',
            '{{%stations}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            '{{%fk-invoices-state_id}}',
            '{{%invoices}}',
            'state_id',
            '{{%invoice_states}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            '{{%fk-invoices-client_id}}',
            '{{%invoices}}',
            'client_id',
            '{{%user}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->batchInsert('{{%invoices}}', ['id', 'client_id', 'station_id', 'invoice_date', 'total', 'state_id', 'code'], [
            [8, 5, 2, '2024-10-31 21:22:19', 2, 2, 'AQL1L6'],
            [10, 5, 1, '2024-11-04 19:24:55', 1.6, 2, 'IZG4ME'],
            [11, 5, 1, '2024-11-12 21:02:36', 13, 4, 'F3XMY9'],
            [12, 5, 1, '2024-11-14 18:52:23', 1.6, 1, null],
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_invoices_user', 'invoices');
        $this->dropForeignKey('fk_invoices_state', 'invoices');
        $this->dropTable('invoices');
    }
}
