<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories}}`.
 */
class m241107_192742_create_categories_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

        $this->batchInsert('categories', ['id', 'name'], [
            [1, 'Category 1'],
            [2, 'Category 2'],
            [3, 'Category 3'],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('categories');
    }
}
