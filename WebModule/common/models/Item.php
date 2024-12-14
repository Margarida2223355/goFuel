<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property int $id
 * @property string $description
 * @property int $subcategory_id
 * @property int $restock_qty
 *
 * @property InvoiceLine[] $invoiceLines
 * @property ItemStock[] $itemStocks
 * @property StationItem[] $stationItems
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
            [['description', 'subcategory_id'], 'required'],
            [['subcategory_id', 'restock_qty'], 'integer'],
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
            'subcategory_id' => 'Subcategory ID',
            'restock_qty' => 'Restock Quantity',
        ];
    }

    /**
     * Gets query for [[InvoiceLines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceLines()
    {
        return $this->hasMany(InvoiceLine::class, ['item_id' => 'id']);
    }

    /**
     * Gets query for [[StationItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStationItems()
    {
        return $this->hasMany(StationItem::class, ['item_id' => 'id']);
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

    public function fields() {
        $fields = parent::fields();

        // Remove subcategory_id field
        unset($fields['subcategory_id'],  $fields['category_id']);

        // Add subcategory field
        $fields['subcategory'] = function() {
            $subcategory = $this->getSubcategory()->one(); // Busca a subcategoria
            return $subcategory ? $subcategory : null;
        };

        return $fields;
    }
}
