<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_stocks".
 *
 * @property int $id
 * @property int $item_id
 * @property int $restock_qty
 */
class ItemStock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_stocks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'restock_qty'], 'required'],
            [['item_id', 'restock_qty'], 'integer'],
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
            'restock_qty' => 'Restock Qty',
        ];
    }
}
