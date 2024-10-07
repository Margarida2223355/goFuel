<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_info".
 *
 * @property int $id
 * @property int $user_id
 * @property int $nif
 * @property string $role
 * @property string $name
 * @property string $address
 * @property string $postal_code
 *
 * @property Invoice[] $invoices
 * @property User $user
 */
class UserInfo extends \yii\db\ActiveRecord
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
            [['user_id', 'nif', 'role', 'name', 'address', 'postal_code'], 'required'],
            [['user_id', 'nif'], 'integer'],
            [['role'], 'string'],
            [['name', 'address'], 'string', 'max' => 255],
            [['postal_code'], 'string', 'max' => 20],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'name' => 'Name',
            'address' => 'Address',
            'postal_code' => 'Postal Code',
        ];
    }

    /**
     * Gets query for [[Invoices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::class, ['client_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
