<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_info".
 *
 * @property int $id
 * @property int $nif
 * @property string $name
 * @property string $address
 * @property string $postal_code
 * @property string $phone
 *
 * @property User $id0
 * @property Invoice[] $invoices
 * @property ManagerStation[] $managerStations
 * @property StationUser[] $stationUsers
 * @property Station[] $stations
 * @property Station[] $stations0
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
            [['nif', 'name', 'address', 'postal_code', 'phone'], 'required'],
            [['nif'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
            [['postal_code'], 'string', 'max' => 20],
            [['phone'], 'string', 'max' => 13],
            [['nif'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nif' => 'Nif',
            'name' => 'Name',
            'address' => 'Address',
            'postal_code' => 'Postal Code',
            'phone' => 'Phone',
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(User::class, ['id' => 'id']);
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
     * Gets query for [[ManagerStations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManagerStations()
    {
        return $this->hasMany(ManagerStation::class, ['manager_id' => 'id']);
    }

    /**
     * Gets query for [[StationUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStationUsers()
    {
        return $this->hasMany(StationUser::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Stations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStations()
    {
        return $this->hasMany(Station::class, ['id' => 'station_id'])->viaTable('manager_station', ['manager_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id']);
    }

    public static function getLoggedInUserRole()
    {
        $userId = Yii::$app->user->id;
        $userInfo = self::findOne(['user_id' => $userId]);
        return $userInfo ? $userInfo->role : null;
    }
}
