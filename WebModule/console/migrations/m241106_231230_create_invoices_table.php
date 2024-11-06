<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoices}}`.
 */
class m241106_231230_create_invoices_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('invoices', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'station_id' => $this->integer()->notNull(),
            'invoice_date' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'total' => $this->double()->notNull(),
            'state_id' => $this->integer()->notNull()->defaultValue(2),
            'code' => $this->string(45),
        ], 'CHARACTER SET utf8mb4 COLLATE=utf8mb4_0900_ai_ci ENGINE=InnoDB');

        $this->addForeignKey('fk_invoices_state', 'invoices', 'state_id', 'invoice_states', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_invoices_station', 'invoices', 'station_id', 'stations', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_invoices_client', 'invoices', 'client_id', 'user', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_invoices_client', 'invoices');
        $this->dropForeignKey('fk_invoices_station', 'invoices');
        $this->dropForeignKey('fk_invoices_state', 'invoices');
        $this->dropTable('invoices');
    }
}
