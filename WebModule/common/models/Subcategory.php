<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subcategories".
 *
 * @property int $id
 * @property string $description
 * @property int $category_id
 *
 * @property Category $category
 * @property Item[] $items
 */
class Subcategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subcategories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'category_id'], 'required'],
            [['category_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
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
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Items]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::class, ['subcategory_id' => 'id']);
    }

    /**
     * Customize fields returned from API
     * 
     * @return array
     */
    public function fields() {
        $fields = parent::fields();

        // Remove category_id field
        unset($fields['category_id']);

        // Add category field
        $fields['category'] = function() {
            $category = $this->getCategory()->one();
            return $category ? $category : null;
        };

        return $fields;
    }
}
