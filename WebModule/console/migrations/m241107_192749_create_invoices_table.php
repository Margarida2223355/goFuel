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
            'state_id' => $this->integer()->notNull()->defaultValue(1),
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

        $this->batchInsert(
            '{{%invoices}}',
            ['id', 'client_id', 'station_id', 'invoice_date', 'total', 'state_id', 'code'],
            [
                [1, 6, 1, '2025-01-28 01:30:27', 26.99, 4, 'FZJVW4'],
                [2, 6, 2, '2025-01-28 01:31:10', 22.78, 3, NULL],
                [3, 6, 2, '2025-01-28 01:32:43', 17.39, 2, 'FWDI0C'],
                [4, 6, 2, '2025-01-28 01:33:43', 50.00, 1, NULL],
                [5, 7, 1, '2025-01-28 01:59:20', 25.00, 4, 'HO29HI'],
                [6, 7, 2, '2025-01-28 01:59:43', 4.78, 2, 'M8SKCG'],
                [7, 7, 3, '2025-01-28 02:00:00', 30.00, 3, NULL],
                [8, 7, 3, '2025-01-28 02:03:01', 35.00, 1, NULL],
            ]
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_invoices_user', 'invoices');
        $this->dropForeignKey('fk_invoices_state', 'invoices');
        $this->dropTable('invoices');
    }
}
