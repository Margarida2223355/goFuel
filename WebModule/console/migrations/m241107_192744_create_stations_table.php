<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stations}}`.
 */
class m241107_192744_create_stations_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%stations}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'address' => $this->string(255)->notNull(),
            'postal_code' => $this->string(20)->notNull(),
            'manager_id' => $this->integer()->notNull(),
            'phone' => $this->string(45)->defaultValue(null),
            'is_deleted' => $this->boolean()->defaultValue(false)->notNull(),
        ]);

        // Criação do índice para a coluna `manager_id`
        $this->createIndex(
            '{{%idx-stations-manager_id}}',
            '{{%stations}}',
            'manager_id'
        );

        // Adição da chave estrangeira para a tabela `user`
        $this->addForeignKey(
            '{{%fk-stations-manager_id}}',
            '{{%stations}}',
            'manager_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->batchInsert('{{%stations}}', ['id', 'name', 'address', 'postal_code', 'manager_id', 'phone'], [
            [1, 'Repsol', 'Nova Leiria', '1000-001', 2, '914241533'],
            [2, 'Galp', 'Guimarota', '1000-002', 2, '236598556'],
            [3, 'Prio', 'Dom Dinis', '1000-003', 3, '221896745'],
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-stations-manager_id}}',
            '{{%stations}}'
        );

        $this->dropIndex(
            '{{%idx-stations-manager_id}}',
            '{{%stations}}'
        );

        $this->dropTable('{{%stations}}');
    }
}
