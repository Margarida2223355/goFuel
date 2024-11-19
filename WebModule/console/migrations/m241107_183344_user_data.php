<?php

use yii\db\Migration;

/**
 * Class m241119_223344_user_data
 */
class m241119_223344_user_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%user}}', ['id', 'username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'status', 'created_at', 'updated_at', 'verification_token'], [
            [1, 'admin', 'adminAuthKey', '$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.', null, 'admin@example.com', 10, 0, 0, null],
            [2, 'manager', 'managerAuthKey', '$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.', null, 'manager@example.com', 10, 0, 0, null],
            [3, 'incharge', 'inchargeAuthKey', '$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.', null, 'incharge@example.com', 10, 0, 0, null],
            [4, 'employee', 'employeeAuthKey', '$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.', null, 'employee@example.com', 10, 0, 0, null],
            [5, 'client', 'clientAuthKey', '$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.', null, 'client@example.com', 10, 0, 1731168731, null],
            [6, 'f.roldao', 'NSnXYl5yzkxfYWvjUMjAkrEBCEnKfhTT', '$2y$13$touBeY34pYqDhtIF.2G.dOCFzGW5TcY4bk6z5fzlbH4eA.fHnWVjK', null, 'f.roldao@oneclient.com', 10, 1730409678, 1731806938, null],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241119_223344_user_data cannot be reverted.\n";

        return false;
    }
}
