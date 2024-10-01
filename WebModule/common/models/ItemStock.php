<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_stocks".
 *
 * @property int $id
 * @property int|null $item_id
 * @property int|null $restock_qty
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
            [['id'], 'required'],
            [['id', 'item_id', 'restock_qty'], 'integer'],
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
            'item_id' => 'Item ID',
            'restock_qty' => 'Restock Qty',
        ];
    }
}
