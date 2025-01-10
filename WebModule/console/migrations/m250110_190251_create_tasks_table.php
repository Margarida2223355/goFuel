<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 */
class m250110_190251_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tarefas}}', [
            'id' => $this->primaryKey(),
            'description' => $this->string(20)->notNull(),
            'is_done' => $this->boolean()->defaultValue(false)->notNull(),
            'user_id' => $this->integer()->notNull(),

        ]);

        $this->addForeignKey(
            'fk_tarefa_user',
            'tarefas',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_tarefa_user', 'tarefas');
        $this->dropTable('user_info');
    }
}
