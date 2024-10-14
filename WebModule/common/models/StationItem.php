<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "station_items".
 *
 * @property int $id
 * @property int $station_id
 * @property int $item_id
 * @property float $price
 *
 * @property Item $item
 * @property Station $station
 */
class StationItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'station_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['station_id', 'item_id', 'price'], 'required'],
            [['station_id', 'item_id'], 'integer'],
            [['price'], 'number'],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::class, 'targetAttribute' => ['item_id' => 'id']],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Station::class, 'targetAttribute' => ['station_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'station_id' => 'Station ID',
            'item_id' => 'Item ID',
            'price' => 'Price',
        ];
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::class, ['id' => 'item_id']);
    }

    /**
     * Gets query for [[Station]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStation()
    {
        return $this->hasOne(Station::class, ['id' => 'station_id']);
    }

    public function fields() {
        $fields = parent::fields();

        // Remove station_id and item_id fields
        unset($fields['station_id'], $fields['item_id']);

        // Add station and item fields with array_merge
        return array_merge($fields, [
            'station' => function() {
                $station = $this->getStation()->one();
                return $station ? $station : null;
            },
            'item' => function() {
                $item = $this->getItem()->one();
                return $item ? $item : null;
            }
        ]);
    }
}
