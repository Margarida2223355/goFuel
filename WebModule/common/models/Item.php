<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property int $id
 * @property string $description
 * @property int $subcategory_id
 * @property int $restock_qty
 *
 * @property Subcategory $subcategory
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'subcategory_id'], 'required'],
            [['subcategory_id', 'restock_qty'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['subcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subcategory::class, 'targetAttribute' => ['subcategory_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'subcategory_id' => 'Subcategory ID',
            'restock_qty' => 'Restock Quantity',
        ];
    }

    /**
     * Gets query for [[Subcategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory()
    {
        return $this->hasOne(Subcategory::class, ['id' => 'subcategory_id']);
    }

    public function getStationItems()
    {
        return $this->hasMany(StationItem::class, ['item_id' => 'id']);
    }

    public function getStations()
    {
        return $this->hasMany(Station::class, ['id' => 'station_id'])->via('stationItems');
    }
}
