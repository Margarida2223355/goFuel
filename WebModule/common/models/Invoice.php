<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoices".
 *
 * @property int $id
 * @property int $client_id
 * @property int $station_id
 * @property string $invoice_date
 * @property float $total
 * @property int $state_id
 *
 * @property UserInfo $client
 * @property InvoiceLine[] $invoiceLines
 * @property InvoiceState $state
 * @property Stations $station
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
            [['client_id', 'station_id', 'total', 'state_id'], 'required'],
            [['client_id', 'station_id', 'state_id'], 'integer'],
            [['invoice_date'], 'safe'],
            [['total'], 'number'],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => InvoiceState::class, 'targetAttribute' => ['state_id' => 'id']],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Station::class, 'targetAttribute' => ['station_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::class, 'targetAttribute' => ['client_id' => 'id']],
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

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(UserInfo::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[InvoiceLines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceLines()
    {
        return $this->hasMany(InvoiceLine::class, ['invoice_id' => 'id']);
    }

    /**
     * Gets query for [[State]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(InvoiceState::class, ['id' => 'state_id']);
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
     * Customize fields returned from API
     * 
     * @return array
     */
    public function fields() {
        $fields = parent::fields();

        // Remove client_id and station_id fields
        unset($fields['client_id'], $fields['station_id']);

        // Add client and station fields
        $fields = array_merge($fields, [
            'client' => function() {
                $client = $this->getClient()->one();
                return $client ? $client : null;
            },

            'station' => function() {
                $station = $this->getStation()->one();
                return $station ? $station : null;
            }
        ]);

        return $fields;
    }
}
