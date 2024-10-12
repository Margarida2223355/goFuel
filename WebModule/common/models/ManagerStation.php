<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "manager_station".
 *
 * @property int $manager_id
 * @property int $station_id
 *
 * @property UserInfo $manager
 * @property Stations $station
 */
class ManagerStation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manager_station';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['manager_id', 'station_id'], 'required'],
            [['manager_id', 'station_id'], 'integer'],
            [['manager_id', 'station_id'], 'unique', 'targetAttribute' => ['manager_id', 'station_id']],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::class, 'targetAttribute' => ['manager_id' => 'id']],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stations::class, 'targetAttribute' => ['station_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'manager_id' => 'Manager ID',
            'station_id' => 'Station ID',
        ];
    }

    /**
     * Gets query for [[Manager]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(UserInfo::class, ['id' => 'manager_id']);
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
