<?php

namespace frontend\tests\functional;

use common\models\User;
use frontend\tests\FunctionalTester;

class SignupCest
{
    protected $formId = '#form-signup';

    public function _fixtures()
    {
        return [
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


    public function _before(FunctionalTester $I)
    {

        $I->amOnRoute('site/signup');
    }

    public function signupWithEmptyFields(FunctionalTester $I)
    {
        $I->see('Sign Up', 'h3');
        //$I->see('Please fill out the following fields to signup:');
        $I->click('SignUp');
        $I->see('Username cannot be blank.');
        $I->see('Email cannot be blank.');
        $I->see('Nif cannot be blank.');
        $I->see('Name cannot be blank.');
        $I->see('Address cannot be blank.');
        $I->see('Postal Code cannot be blank.');
    }

    public function signupWithWrongEmail(FunctionalTester $I)
    {
        $I->fillField('SignupForm[username]', 'tester');
        $I->fillField('SignupForm[email]', 'ttttt');
        $I->fillField('SignupForm[password]', 'tester_password');
        $I->fillField('SignupForm[nif]', 162162162);
        $I->fillField('SignupForm[name]', 'tester_password');
        $I->fillField('SignupForm[address]', 'tester_password');
        $I->fillField('SignupForm[postal_code]', 'tester_password');
        $I->fillField('SignupForm[phone]', 914914914,);
        $I->click('SignUp');

        $I->dontSee('Username cannot be blank.');
        $I->dontSee('Password cannot be blank.');
        $I->see('Email is not a valid email address.');
    }

    public function signupSuccessfully(FunctionalTester $I)
    {
        $I->fillField('SignupForm[username]', 'tester');
        $I->fillField('SignupForm[email]', 'tester@mail.com');
        $I->fillField('SignupForm[password]', 'tester_password');
        $I->fillField('SignupForm[nif]', 162162162);
        $I->fillField('SignupForm[name]', 'tester_password');
        $I->fillField('SignupForm[address]', 'tester_password');
        $I->fillField('SignupForm[postal_code]', 'tester_password');
        $I->fillField('SignupForm[phone]', 914914914,);
        $I->click('SignUp');

        $I->see('Thank you for registration. Please check your inbox for verification email.');

        $I->click('Login');
        $I->fillField('LoginForm[username]', 'tester');
        $I->fillField('LoginForm[password]', 'tester_password');
    }
}
