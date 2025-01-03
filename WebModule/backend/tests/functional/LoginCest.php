<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use common\models\User;
use Yii;

/**
 * Class LoginCest
 */
class LoginCest
{
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => \common\fixtures\UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
            'userInfo' => [
                'class' => \common\fixtures\UserInfoFixture::class,
                'dataFile' => codecept_data_dir() . 'userinfo.php',
            ],
            'auth_assignment' => [
                'class' => \common\fixtures\AuthassignmentFixture::class,
                'tableName' => 'auth_assignment',
                'dataFile' => codecept_data_dir() . 'authassignment.php',
            ],
            'auth_item' => [
                'class' => \common\fixtures\AuthitemFixture::class,
                'tableName' => 'auth_item',
                'dataFile' => codecept_data_dir() . 'authitem.php',
            ],
        ];
    }

    public function _before() {}

    /**
     * @param FunctionalTester $I
     */
    public function loginUser(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->see('Login');

        $I->fillField('LoginForm[username]', 'admin');
        $I->fillField('LoginForm[password]', 'password');
        $I->click('Login');

        $I->see('HomePage');
        $I->see('Profile (Admin)');
    }

    public function loginWithEmptyFields(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->click('Login');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }
}
