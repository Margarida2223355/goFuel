<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "station_users".
 *
 * @property int $user_id
 * @property int $station_id
 *
 * @property Station $station
 * @property User $user
 */
class StationUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'station_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'station_id'], 'required'],
            [['user_id', 'station_id'], 'integer'],
            [['user_id', 'station_id'], 'unique', 'targetAttribute' => ['user_id', 'station_id']], // Se quiser evitar duplicatas
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
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
        return $this->hasOne(Station::class, ['id' => 'station_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
