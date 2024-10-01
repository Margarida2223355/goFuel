<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pumps".
 *
 * @property int $id
 * @property int $station_id
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
}
