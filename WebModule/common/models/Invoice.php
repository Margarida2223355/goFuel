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
 * @property Invoicestate $state
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
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoicestate::class, 'targetAttribute' => ['state_id' => 'id']],
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
        return $this->hasOne(Invoicestate::class, ['id' => 'state_id']);
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

    public function fields()
    {
        $fields = parent::fields();

        // Remove client_id, station_id and state_id fields
        unset($fields['client_id'], $fields['station_id'], $fields['state_id']);

        // Add client and station fields
        $fields['client'] = function () {
            $client = $this->getClient()->one();
            return $client ? $client : null;
        };

        $fields['station'] = function () {
            $station = $this->getStation()->one();
            return $station ? $station : null;
        };

        $fields['state'] = function () {
            $state = $this->getState()->one();
            return $state ? $state : null;
        };

        return $fields;
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


    public function generateRandomCode()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Letras maiúsculas e dígitos
        $randomCode = '';

        for ($i = 0; $i < 6; $i++) {
            $index = rand(0, strlen($characters) - 1); // Gera um índice aleatório
            $randomCode .= $characters[$index];
        }

        $this->code = $randomCode;
        $this->update();
    }

    public function generateFinalCode() {
        $this->code = 'F' . date('Y', strtotime($this->invoice_date)) . 'S' . $this->station_id . '/' . $this->id;
    }
}
