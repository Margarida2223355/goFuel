<?php

namespace backend\models;

use Yii;
use common\models\StationItem; // Ajuste o namespace conforme necessário

class ItemStationForm extends \yii\base\Model
{
    public $station_id;
    public $item_id;
    public $price;

    public function rules()
    {
        return [
            [['station_id', 'item_id', 'price'], 'required'],
            [['station_id', 'item_id'], 'integer'],
            [['price'], 'number'],
        ];
    }

    public function save()
    {
        $stationItem = new StationItem();
        $stationItem->station_id = $this->station_id;
        $stationItem->item_id = $this->item_id;
        $stationItem->price = $this->price;

        return $stationItem->save();
    }
}
