<?php

namespace frontent\tests\functional;

use common\models\StationItem;
use frontend\tests\FunctionalTester;
use Yii;

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

        $I->click('Service Areas');
        $I->see('Stations');
    }

    public function checkAddToCart(FunctionalTester $I)
    {
        $I->click('Station 1');
        $I->see('Available Items');

        $formSelector = 'form[action*="invoice/addtocart"][action*="item_id=2"][action*="station_id=1"]';

        $I->submitForm($formSelector, ['quantity' => 20,]);

        $sItem = StationItem::findOne(['item_id' => 2, 'station_id' => 1]);
        $total  = $sItem->price * 20;

        $I->click('Cart');
        $I->see('No results found.');

        $stationItem = \common\models\StationItem::findOne(['item_id' => 2, 'station_id' => 1]);
        $invoice = \common\models\Invoice::find()->where(['station_id' => 1])->orderBy(['id' => SORT_DESC])->one();

        if ($invoice) {
            echo ('Invoice Found: ' . $invoice->id);
        } else {
            echo ('Invoice Not Found!');
        }

        // Abrir a fatura específica
        /*$invoice = \common\models\Invoice::find()->where([
            'station_id' => $sItem->station_id,
            'client_id' => Yii::$app->user->id, // Substituir pelo ID do cliente autenticado
        ])->orderBy(['id' => SORT_DESC])->one();

        $I->amOnPage(['/invoice/view', 'id' => $invoice->id]);
        $I->see('Invoice ' . $invoice->id . ' | Details', 'h1');
        $I->see($total);

        // Verificar a presença do item e os valores da linha de fatura
        $I->see($sItem->item->description, 'table');
        $I->see(Yii::$app->formatter->asCurrency($sItem->price, 'EUR'), 'table');
        $I->see('20', 'table');
        $I->see(Yii::$app->formatter->asCurrency($total, 'EUR'), 'table');*/
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
