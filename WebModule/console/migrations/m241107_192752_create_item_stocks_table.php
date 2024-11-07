<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%item_stocks}}`.
 */
class m241107_192752_create_item_stocks_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('item_stocks', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'location' => $this->string(),
        ]);

        $this->addForeignKey(
            'fk_item_stocks_item',
            'item_stocks',
            'item_id',
            'items',  // Supondo que existe uma tabela `items`
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_item_stocks_item', 'item_stocks');
        $this->dropTable('item_stocks');
    }
}
