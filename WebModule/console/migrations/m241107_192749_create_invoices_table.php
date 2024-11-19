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

        $this->batchInsert('{{%invoices}}', ['id', 'client_id', 'state_id', 'created_at', 'total', 'station_id', 'reference'], [
            [8, 6, 2, '2024-10-31 21:22:19', 2, 2, 'AQL1L6'],
            [10, 6, 1, '2024-11-04 19:24:55', 1.5, 2, 'IZG4ME'],
            [11, 5, 1, '2024-11-12 21:02:36', 13, 2, 'F3XMY9'],
            [12, 5, 1, '2024-11-14 18:52:23', 1.5, 1, null],
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_invoices_user', 'invoices');
        $this->dropForeignKey('fk_invoices_state', 'invoices');
        $this->dropTable('invoices');
    }
}
