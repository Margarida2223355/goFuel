<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stations".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $postal_code
 *
 * @property Invoices[] $invoices
 * @property Pumps[] $pumps
 */
class Station extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'address', 'postal_code'], 'required'],
            [['name', 'address'], 'string', 'max' => 255],
            [['postal_code'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'postal_code' => 'Postal Code',
        ];
    }

    /**
     * Gets query for [[Invoices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoices::class, ['station_id' => 'id']);
    }

    /**
     * Gets query for [[Pumps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPumps()
    {
        return $this->hasMany(Pumps::class, ['station_id' => 'id']);
    }
}
