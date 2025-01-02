<?php

namespace frontent\tests\functional;

use common\models\ClientStation;
use common\models\Station;
use frontend\tests\FunctionalTester;

use function PHPUnit\Framework\assertNotEquals;

class StationCest
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

    public function checkStationDetailsAndItems(FunctionalTester $I)
    {
        $this->login($I);
        $I->see('HomePage');
        $I->seeLink('Service Areas');
        $I->click('Service Areas');
        $I->see('Stations');
        $I->click('Station 1');
        $I->see('Available Items');
        $I->dontSee('Unleaded 98 - 1L');
    }

    public function checkChangeFavouriteStation(FunctionalTester $I)
    {
        $this->login($I);

        $I->seeLink('Service Areas');
        $I->click('Service Areas');
        $I->see('Stations');
        $I->seeElement('.star-button[href*="station_id=1"]');
        $initialFavStation = ClientStation::findOne(['client_id' => 5]);
        $initialStationId = $initialFavStation->station_id;
        $I->click('.star-button[href*="station_id=1"]');
        $updatedFavStation = ClientStation::findOne(['client_id' => 5]);
        $I->assertNotEquals($initialStationId, $updatedFavStation->station_id, 'Favourite Station Successfully Changed');
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
