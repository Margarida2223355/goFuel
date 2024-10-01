<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoices".
 *
 * @property int $id
 * @property int|null $client_id
 * @property int|null $station_id
 * @property string|null $invoice_date
 * @property float|null $total
 * @property int|null $state_id
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'client_id', 'station_id', 'state_id'], 'integer'],
            [['invoice_date'], 'safe'],
            [['total'], 'number'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'station_id' => 'Station ID',
            'invoice_date' => 'Invoice Date',
            'total' => 'Total',
            'state_id' => 'State ID',
        ];
    }
}
