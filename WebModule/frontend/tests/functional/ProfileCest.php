<?php

namespace frontent\tests\functional;

use common\models\StationItem;
use common\models\User;
use frontend\tests\FunctionalTester;
use Yii;

use function PHPUnit\Framework\assertNotEquals;

class ProfileCest
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
            'stations' => [
                'class' => \common\fixtures\StationsFixture::class,
                'dataFile' => codecept_data_dir() . 'stations.php',
            ],
            'clientstation' => [
                'class' => \common\fixtures\ClientStationFixture::class,
                'dataFile' => codecept_data_dir() . 'clientstation.php',
            ],
            'subcategories' => [
                'class' => \common\fixtures\SubcategoryFixture::class,
                'dataFile' => codecept_data_dir() . 'subcategories.php',
            ],
            'categories' => [
                'class' => \common\fixtures\CategoryFixture::class,
                'dataFile' => codecept_data_dir() . 'categories.php',
            ],
            'items' => [
                'class' => \common\fixtures\ItemsFixture::class,
                'dataFile' => codecept_data_dir() . 'items.php',
            ],
            'stationItems' => [
                'class' => \common\fixtures\StationItemFixture::class,
                'dataFile' => codecept_data_dir() . 'stationitems.php',
            ],
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $this->login($I);

        $I->click('Profile');
        $I->see('Update Profile');
    }

    public function checkChangeProfileInfo(FunctionalTester $I)
    {
        $I->submitForm('form', [
            'SignupForm[username]' => 'username',
            'SignupForm[email]' => 'newemail@example.com',
            'SignupForm[nif]' => '463469465',
            'SignupForm[name]' => 'New Name',
            'SignupForm[address]' => '123 New Street',
            'SignupForm[postal_code]' => '1365-563',
            'SignupForm[phone]' => '463469465',
        ]);

        $user = User::findOne(['id' => 5]);

        $I->assertNotEquals('client@example.com', $user->email);
        $I->assertEquals('newemail@example.com', $user->email);
    }

    protected function login(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('client', 'password'));
        $I->see('HomePage');
        $I->see('Your favourite station');
        $I->see('Logout (Client)');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }

    protected function formParams($username, $password)
    {
        return [
            'LoginForm[username]' => $username,
            'LoginForm[password]' => $password,
        ];
    }
}
