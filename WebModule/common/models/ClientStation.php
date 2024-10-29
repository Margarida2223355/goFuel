<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_station".
 *
 * @property int $id_client
 * @property int $id_station
 *
 * @property User $client
 * @property UserInfo $station
 */
class ClientStation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_station';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_client', 'id_station'], 'required'],
            [['id_client', 'id_station'], 'integer'],
            [['id_client', 'id_station'], 'unique', 'targetAttribute' => ['id_client', 'id_station']],
            [['id_client'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_client' => 'id']],
            [['id_station'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::class, 'targetAttribute' => ['id_station' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_client' => 'Id Client',
            'id_station' => 'Id Station',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::class, ['id' => 'id_client']);
    }

    /**
     * Gets query for [[Station]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStation()
    {
        return $this->hasOne(UserInfo::class, ['id' => 'id_station']);
    }
}
