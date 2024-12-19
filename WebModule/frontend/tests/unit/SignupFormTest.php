<?php

namespace frontend\tests\unit\models;

use common\fixtures\UserFixture;
use common\models\User;
use common\models\UserInfo;
use frontend\models\SignupForm;
use Yii;
use yii\base\Model;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

class SignupFormTest extends \Codeception\Test\Unit
{
    protected function _before()
    {
        parent::_before();
        Yii::$app->db->createCommand()->checkIntegrity(false)->execute();
        User::deleteAll();
        UserInfo::deleteAll();
        Yii::$app->db->createCommand()->checkIntegrity(true)->execute();

        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // Criar roles
        $admin = $auth->createRole('Admin');
        $manager = $auth->createRole('Manager');
        $inCharge = $auth->createRole('Incharge');
        $employee = $auth->createRole('Employee');
        $client = $auth->createRole('Client');

        // Adicionar roles
        $auth->add($admin);
        $auth->add($manager);
        $auth->add($inCharge);
        $auth->add($employee);
        $auth->add($client);
    }

    public function testSignupWithValidData()
    {
        $model = new SignupForm([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'nif' => 123456789,
            'name' => 'TestUser',
            'address' => '123 Test Street',
            'postal_code' => '12345',
            'phone' => '1234567890',
        ]);
        $model->signup();

        $user = User::findOne(['email' => 'test@example.com']);
        assertNotNull($user);
        assertEquals('123456789', $user->userInfo->nif);

        
    }

    public function testSignupWithInvalidData()
    {
        $model = new SignupForm([
            'username' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'nif' => 'not-a-number',
            'name' => '',
            'address' => '',
            'postal_code' => '',
            'phone' => '',
        ]);

        assertNull($model->signup());
        assertTrue($model->hasErrors('username'));
        assertTrue($model->hasErrors('email'));
        assertTrue($model->hasErrors('password'));
        assertTrue($model->hasErrors('nif'));
        assertTrue($model->hasErrors('name'));
        assertTrue($model->hasErrors('address'));
        assertTrue($model->hasErrors('postal_code'));
        assertTrue($model->hasErrors('phone'));
    }
}
