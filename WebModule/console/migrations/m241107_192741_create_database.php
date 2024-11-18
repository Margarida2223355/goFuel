<?php

use yii\db\Migration;

/**
 * Class m241107_192741_create_database
 */
class m241107_192741_create_database extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241107_192741_create_database cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241107_192741_create_database cannot be reverted.\n";

        return false;
    }
    */
}
