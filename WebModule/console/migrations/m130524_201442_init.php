<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->batchInsert('{{%user}}', ['id', 'username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'status', 'created_at', 'updated_at', 'verification_token'], [
            [1, 'admin', 'adminAuthKey', '$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.', null, 'admin@example.com', 10, 0, 0, null],
            [2, 'manager', 'managerAuthKey', '$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.', null, 'manager@example.com', 10, 0, 0, null],
            [3, 'incharge', 'inchargeAuthKey', '$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.', null, 'incharge@example.com', 10, 0, 0, null],
            [4, 'employee', 'employeeAuthKey', '$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.', null, 'employee@example.com', 10, 0, 0, null],
            [5, 'client', 'clientAuthKey', '$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.', null, 'client@example.com', 10, 0, 1731168731, null],
            [6, 'f.roldao', 'NSnXYl5yzkxfYWvjUMjAkrEBCEnKfhTT', '$2y$13$touBeY34pYqDhtIF.2G.dOCFzGW5TcY4bk6z5fzlbH4eA.fHnWVjK', null, 'f.roldao@oneclient.com', 10, 1730409678, 1731806938, null],
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
