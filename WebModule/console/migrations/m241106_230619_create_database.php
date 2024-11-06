<?php

use yii\db\Migration;

/**
 * Class m241106_230619_create_database
 */
class m241106_230619_create_database extends Migration
{
    public function safeUp()
    {
        $dbName = 'goFuel';

        $this->execute("CREATE DATABASE IF NOT EXISTS {$dbName} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

        echo "Banco de dados '{$dbName}' criado com sucesso.\n";
    }

    public function safeDown()
    {
        $dbName = 'goFuel';

        $this->execute("DROP DATABASE IF EXISTS {$dbName}");

        echo "Banco de dados '{$dbName}' removido.\n";
    }
}
