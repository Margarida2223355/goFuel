<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class HomeCest
{
    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnRoute('/');
        $I->see('HomePage');
        $I->seeLink('About');
        $I->click('About');
        $I->see('More Than Just A Haircut. Learn More About Us!');
    }
}