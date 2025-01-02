<?php

namespace frontent\tests\functional;

use frontend\tests\FunctionalTester;

use function PHPUnit\Framework\assertNotEquals;

class InvoiceCest
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
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
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
