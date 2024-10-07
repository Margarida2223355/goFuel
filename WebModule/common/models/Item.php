<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property int $id
 * @property string $description
 * @property float $price
 * @property int $subcategory_id
 *
 * @property ItemStocks[] $itemStocks
 * @property Subcategories $subcategory
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'price', 'subcategory_id'], 'required'],
            [['price'], 'number'],
            [['subcategory_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['subcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subcategories::class, 'targetAttribute' => ['subcategory_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'price' => 'Price',
            'subcategory_id' => 'Subcategory ID',
        ];
    }

    /**
     * Gets query for [[ItemStocks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItemStocks()
    {
        return $this->hasMany(ItemStocks::class, ['item_id' => 'id']);
    }

    /**
     * Gets query for [[Subcategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory()
    {
        return $this->hasOne(Subcategories::class, ['id' => 'subcategory_id']);
    }
}
