<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoice_lines".
 *
 * @property int $id
 * @property int $qty
 * @property float $total
 * @property int $invoice_id
 *
 * @property Invoice $invoice
 */
class InvoiceLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice_lines';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['qty', 'total', 'invoice_id'], 'required'],
            [['qty', 'invoice_id'], 'integer'],
            [['total'], 'number'],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::class, 'targetAttribute' => ['invoice_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'qty' => 'Qty',
            'total' => 'Total',
            'invoice_id' => 'Invoice ID',
        ];
    }

    /**
     * Gets query for [[Invoice]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::class, ['id' => 'invoice_id']);
    }

    /**
     * Customize fields returned from API
     * 
     * @return array
     */
    public function fields() {
        $fields = parent::fields();

        // Remove invoice_id field
        unset($fields['invoice_id']);

        // Add invoice field
        $fields['invoice'] = function() {
            $invoice = $this->getInvoice()->one();
            return $invoice ? $invoice : null;
        };

        return $fields;
    }
}
