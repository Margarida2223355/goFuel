<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pumps".
 *
 * @property int $id
 * @property int $station_id
 *
 * @property Stations $station
 */
class Pump extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pumps';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['station_id'], 'required'],
            [['station_id'], 'integer'],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stations::class, 'targetAttribute' => ['station_id' => 'id']],
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
        ];
    }

    /**
     * Gets query for [[Station]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStation()
    {
        return $this->hasOne(Stations::class, ['id' => 'station_id']);
    }
}
