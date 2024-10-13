<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stations".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $postal_code
 *
 * @property Invoice[] $invoices
 * @property ManagerStation[] $managerStations
 * @property UserInfo[] $managers
 * @property Pump[] $pumps
 * @property StationItem[] $stationItems
 * @property StationUser[] $stationUsers
 * @property UserInfo[] $users
 */
class Station extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'address', 'postal_code'], 'required'],
            [['name', 'address'], 'string', 'max' => 255],
            [['postal_code'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
        return $this->hasMany(Invoice::class, ['station_id' => 'id']);
    }

    /**
     * Gets query for [[ManagerStations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManagerStations()
    {
        return $this->hasMany(ManagerStation::class, ['station_id' => 'id']);
    }

    /**
     * Gets query for [[Managers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManagers()
    {
        return $this->hasMany(UserInfo::class, ['id' => 'manager_id'])->viaTable('manager_station', ['station_id' => 'id']);
    }

    /**
     * Gets query for [[Pumps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPumps()
    {
        return $this->hasMany(Pump::class, ['station_id' => 'id']);
    }

    /**
     * Gets query for [[StationItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStationItems()
    {
        return $this->hasMany(StationItem::class, ['station_id' => 'id']);
    }

    /**
     * Gets query for [[StationUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStationUsers()
    {
        return $this->hasMany(StationUser::class, ['station_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(UserInfo::class, ['id' => 'user_id'])->viaTable('station_users', ['station_id' => 'id']);
    }
}
