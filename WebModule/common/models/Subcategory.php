<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subcategories".
 *
 * @property int $id
 * @property string|null $description
 * @property int|null $category_id
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
            [['id'], 'required'],
            [['id', 'category_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'category_id' => 'Category ID',
        ];
    }
}
