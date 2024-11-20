<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_station".
 *
 * @property int $client_id
 * @property int $station_id
 *
 * @property User $client
 * @property Station $station
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
            [['client_id', 'station_id'], 'required'],
            [['client_id', 'station_id'], 'integer'],
            [['client_id', 'station_id'], 'unique', 'targetAttribute' => ['client_id', 'station_id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['client_id' => 'id']],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Station::class, 'targetAttribute' => ['station_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'client_id' => 'Client ID',
            'station_id' => 'Station ID',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::class, ['id' => 'client_id']);
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

        unset($fields['client_id'],  $fields['station_id']);

        $fields['client'] = function() {
            $client = $this->getClient()->one();
            return $client ? $client->getUserInfo()->one() : null;
        };

        $fields['station'] = function() {
            $station = $this->getStation()->one();
            return $station ? $station : null;
        };

        return $fields;
    }
}
