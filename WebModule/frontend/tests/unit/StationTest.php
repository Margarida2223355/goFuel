<?php

namespace frontend\tests\unit;

use common\models\ClientStation;
use common\models\Pump;
use common\models\Station;
use common\models\User;

class StationTest extends \Codeception\Test\Unit
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
        ];
    }

    public function testValidation()
    {
        $station = new Station();

        $station->name = null;
        $station->address = null;
        $station->postal_code = null;
        $station->manager_id = null;

        $this->assertFalse($station->save());

        $station->name = 'Station Test';
        $station->address = '123 Test Street';
        $station->postal_code = '12345-678';
        $station->manager_id = 2;

        if (!$station->validate()) {
            dd($station->errors);
        }

        $this->assertTrue($station->validate(), 'Validation should pass when all fields are valid');

        $station->save();
    }

    public function testManagerRelationship()
    {
        $station = $this->createStation();

        //$station = Station::findOne(['id' => 1]);

        $this->assertNotNull($station);
        $manager = $station->manager;
        $this->assertNotNull($manager);
        $this->assertEquals($manager->id, $station->manager_id);
    }

    public function testIsFavoritedByUser()
    {
        $fav = $this->favStation();
        $station = $this->createStation();
        $this->assertNotNull($station);
        $this->assertFalse($station->isFavoritedByUser(5));
        $this->assertFalse($station->isFavoritedByUser(2));
    }

    public function testAddPumps()
    {
        $station = $this->createStation();

        $this->assertNotNull($station);

        $pumpNumber = 4;

        for ($i = 0; $i < $pumpNumber; $i++) {
            $pump = new Pump();
            $pump->station_id = $station->id;
            $pump->save();
        }

        $pumps = Pump::find()->where(['station_id' => $station->id]);
        $pumpsCount = $pumps->count();

        $this->assertEquals($pumpNumber, $pumpsCount);
    }

    public function testDeleteStation()
    {
        $station = $this->createStation();

        $this->assertNotNull($station);

        $this->assertEquals(0, $station->is_deleted);
        $this->delete($station);

        $this->assertEquals(1, $station->is_deleted);
    }

    protected function createStation()
    {
        $station = new Station();

        $station->name = 'Station Test';
        $station->address = '123 Test Street';
        $station->postal_code = '12345-678';
        $station->manager_id = 2;
        $station->is_deleted = 0;

        $station->save();

        return $station;
    }

    protected function favStation()
    {
        $clientStation = new ClientStation();
        $clientStation->client_id = 5;
        $clientStation->station_id = 1;

        return $clientStation;
    }

    protected function delete($station)
    {
        $station->is_deleted = 1;
        $station->save();
    }
}
