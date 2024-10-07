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
 * @property ItemStock[] $itemStocks
 * @property Subcategory $subcategory
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
            [['subcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subcategory::class, 'targetAttribute' => ['subcategory_id' => 'id']],
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
        return $this->hasMany(ItemStock::class, ['item_id' => 'id']);
    }

    /**
     * Gets query for [[Subcategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory()
    {
        return $this->hasOne(Subcategory::class, ['id' => 'subcategory_id']);
    }

    /**
     * Customize fields returned from API
     * 
     * @return array
     */
    public function fields() {
        $fields = parent::fields();

        // Remove subcategory_id field
        unset($fields['subcategory_id']);

        // Add subcategory field
        $fields['subcategory'] = function() {
            $subcategory = $this->getSubcategory()->one();
            return $subcategory ? $subcategory : null;
        };

        return $fields;
    }
}
