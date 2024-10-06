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
 * @property string $phone
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
            [['user_id', 'nif', 'role', 'name', 'address', 'postal_code', 'phone'], 'required'],
            [['user_id', 'nif'], 'integer'],
            [['role'], 'string'],
            [['name', 'address'], 'string', 'max' => 255],
            [['postal_code'], 'string', 'max' => 20],
            [['phone'], 'string', 'max' => 13],
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
            'phone' => 'Phone',
        ];
    }

    public static function getLoggedInUserRole()
    {
        $userId = Yii::$app->user->id;
        $userInfo = self::findOne(['user_id' => $userId]);

        return $userInfo ? $userInfo->role : null;
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
