<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subcategories}}`.
 */
class m241107_192743_create_subcategories_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('subcategories', [
            'id' => $this->primaryKey(),
            'description' => $this->string()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'is_deleted' => $this->boolean()->defaultValue(true)->notNull(),
        ]);

        $this->addForeignKey(
            'fk_subcategories_category',
            'subcategories',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );

        $this->batchInsert('{{%subcategories}}', ['id', 'description', 'category_id'], [
            [1, 'Unleaded 95', 1],
            [2, 'Unleaded 98', 1],
            [3, 'Diesel Regular', 2],
            [4, 'Diesel Premium', 2],
            [5, 'Chips', 3],
            [6, 'Soda', 3],
            [7, 'Car Fresheners', 4],
            [8, 'Car Chargers', 4],
            [9, 'Conventional Tobacco', 5],
            [10, 'Heated Tobacco', 5],
            [14, 'Leaded 95', 1],
            [15, 'Leaded 98', 1],
            [16, 'Rolling Tabacco', 5],
            [17, 'Filters', 5],
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_subcategories_category', 'subcategories');
        $this->dropTable('subcategories');
    }
}
