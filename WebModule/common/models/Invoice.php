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
 * @property string|null $code
 *
 * @property User $client
 * @property InvoiceLine[] $invoiceLines
 * @property InvoiceState $state
 * @property Station $station
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
            [['client_id', 'station_id', 'total'], 'required'],
            [['client_id', 'station_id', 'state_id'], 'integer'],
            [['invoice_date'], 'safe'],
            [['total'], 'number'],
            [['code'], 'string', 'max' => 45],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['client_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => InvoiceState::class, 'targetAttribute' => ['state_id' => 'id']],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Station::class, 'targetAttribute' => ['station_id' => 'id']],
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
            'code' => 'Code',
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

    public function updateTotal()
    {
        $total = 0;
        foreach ($this->invoiceLines as $line) {
            $total += $line->total;
        }

        $this->total = $total;
        $this->update();
    }
}
