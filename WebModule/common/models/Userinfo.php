<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_info".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $nif
 * @property string|null $role
 * @property string|null $email
 * @property string|null $name
 * @property string|null $address
 * @property string|null $postal_code
 */
class Userinfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'user_id', 'nif'], 'integer'],
            [['role'], 'string'],
            [['email', 'name', 'address'], 'string', 'max' => 255],
            [['postal_code'], 'string', 'max' => 20],
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
            'user_id' => 'User ID',
            'nif' => 'Nif',
            'role' => 'Role',
            'email' => 'Email',
            'name' => 'Name',
            'address' => 'Address',
            'postal_code' => 'Postal Code',
        ];
    }
}
