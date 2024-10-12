<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoice_lines".
 *
 * @property int $id
 * @property int|null $item_id
 * @property int|null $pump_id
 * @property int $qty
 * @property float $total
 * @property int $invoice_id
 *
 * @property Items $item
 * @property Pumps $pump
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
            [['item_id', 'pump_id', 'qty', 'invoice_id'], 'integer'],
            [['qty', 'total', 'invoice_id'], 'required'],
            [['total'], 'number'],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Items::class, 'targetAttribute' => ['item_id' => 'id']],
            [['pump_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pumps::class, 'targetAttribute' => ['pump_id' => 'id']],
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
            'pump_id' => 'Pump ID',
            'qty' => 'Qty',
            'total' => 'Total',
            'invoice_id' => 'Invoice ID',
        ];
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Items::class, ['id' => 'item_id']);
    }

    /**
     * Gets query for [[Pump]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPump()
    {
        return $this->hasOne(Pumps::class, ['id' => 'pump_id']);
    }


    /**
     * Customize fields returned from API
     * 
     * @return array
     */
    public function fields() {
        $fields = parent::fields();

        // Remove client_id and station_id fields
        unset($fields['item_id'], $fields['pump_id']);

        // Add client and station fields
        $fields = array_merge($fields, [
            'item' => function() {
                $item = $this->getItem()->one();
                return $item ? $item : null;
            },

            'pump' => function() {
                $pump = $this->getPump()->one();
                return $pump ? $pump : null;
            }
        ]);

        return $fields;
    }
}
