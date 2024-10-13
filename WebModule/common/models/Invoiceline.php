<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoice_lines".
 *
 * @property int $id
 * @property int $item_id
 * @property int $qty
 * @property float $total
 * @property int $invoice_id
 *
 * @property Invoice $invoice
 * @property Item $item
 */
class Invoiceline extends \yii\db\ActiveRecord
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
            [['item_id', 'qty', 'total', 'invoice_id'], 'required'],
            [['item_id', 'qty', 'invoice_id'], 'integer'],
            [['total'], 'number'],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::class, 'targetAttribute' => ['invoice_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::class, 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
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
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::class, ['id' => 'item_id']);
    }

    public function fields() {
        $fields = parent::fields();

        // Remove item_id and invoice_id fields
        unset($fields['item_id'], $fields['invoice_id']);

        // Add item, and invoice fields with array_merge
        return array_merge($fields, [
            'item' => function() {
                $item = $this->getItem()->one();
                return $item ? $item : null;
            },
            'invoice' => function() {
                $invoice = $this->getInvoice()->one();
                return $invoice ? $invoice : null;
            },
        ]);
    }
}
