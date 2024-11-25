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
            'is_deleted' => $this->boolean()->defaultValue(true)->notNull(),
        ]);

        $this->batchInsert('{{%categories}}', ['id', 'name'], [
            [1, 'Gasoline'],
            [2, 'Diesel'],
            [3, 'Snacks'],
            [4, 'Accessories'],
            [5, 'Tobacco'],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('categories');
    }
}
