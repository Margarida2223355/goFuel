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
            'name' => $this->string()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_subcategories_category',
            'subcategories',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_subcategories_category', 'subcategories');
        $this->dropTable('subcategories');
    }
}
