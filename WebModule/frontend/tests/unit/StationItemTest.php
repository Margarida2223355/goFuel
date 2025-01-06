<?php

namespace frontend\tests\unit;

use common\models\StationItem;
use common\models\Station;
use common\models\Item;
use PhpParser\Builder\Function_;

class StationItemTest extends \Codeception\Test\Unit
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
            'categories' => [
                'class' => \common\fixtures\CategoryFixture::class,
                'dataFile' => codecept_data_dir() . 'categories.php',
            ],
            'subcategories' => [
                'class' => \common\fixtures\SubcategoryFixture::class,
                'dataFile' => codecept_data_dir() . 'subcategories.php',
            ],
            'items' => [
                'class' => \common\fixtures\ItemsFixture::class,
                'dataFile' => codecept_data_dir() . 'items.php',
            ],
        ];
    }
    public function testValidation()
    {
        $stationItem = new StationItem();

        $stationItem->station_id = null;
        $stationItem->item_id = null;
        $stationItem->price = null;
        $this->assertFalse($stationItem->validate(), 'Validation should fail when required fields are null');

        $stationItem->station_id = 1;
        $stationItem->item_id = 1;
        $stationItem->price = 100.50;
        $stationItem->stock = 10;
        $this->assertTrue($stationItem->validate(), 'Validation should pass with valid data');
    }

    public function testRelations()
    {
        $stationItem = $this->createStationItem();
        $this->assertNotNull($stationItem, 'StationItem should exist in database');

        $station = $stationItem->station;
        $this->assertNotNull($station, 'Station relation should return a valid object');
        $this->assertInstanceOf(Station::class, $station, 'Station relation should return a Station object');

        $item = $stationItem->item;
        $this->assertNotNull($item, 'Item relation should return a valid object');
        $this->assertInstanceOf(Item::class, $item, 'Item relation should return an Item object');
    }

    public function testUpdate()
    {
        $stationItem = $this->createStationItem();
        $this->assertNotNull($stationItem, 'StationItem should exist in database');

        $stationItem->station_id = 1;
        $stationItem->item_id = 1;
        $stationItem->price = 10.5;
        $stationItem->stock = 100;
        $this->assertTrue($stationItem->save(), 'StationItem wasn\'t updated');
    }

    public function testDeleteStationItem()
    {
        $stationItem = $this->createStationItem();
        $this->assertNotNull($stationItem, 'StationItem should exist in database');

        $this->assertEquals(1, $stationItem->delete(), 'StationItem wasn\'t deleted');
    }

    protected function createStationItem()
    {
        $stationItem = new StationItem();
        $stationItem->station_id = 1;
        $stationItem->item_id = 1;
        $stationItem->price = 100.50;
        $stationItem->stock = 10;
        $stationItem->save();

        return $stationItem;
    }
}
