<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "station_items".
 *
 * @property int $id
 * @property int $station_id
 * @property int $item_id
 * @property double $price
 *
 * @property Station $station
 * @property Item $item
 */
class StationItem extends ActiveRecord
{
    public static function tableName()
    {
        return 'station_items';
    }

    public function rules()
    {
        return [
            [['station_id', 'item_id', 'price'], 'required'],
            [['station_id', 'item_id'], 'integer'],
            [['price'], 'number'],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Station::class, 'targetAttribute' => ['station_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::class, 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    public function getStation()
    {
        return $this->hasOne(Station::class, ['id' => 'station_id']);
    }

    public function getItem()
    {
        return $this->hasOne(Item::class, ['id' => 'item_id']);
    }
}
