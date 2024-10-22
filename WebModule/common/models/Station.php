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
 * @property int $manager_id
 *
 * @property UserInfo $manager
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
            [['name', 'address', 'postal_code', 'manager_id'], 'required'],
            [['manager_id'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
            [['postal_code'], 'string', 'max' => 20],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::class, 'targetAttribute' => ['manager_id' => 'id']],
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
            'manager_id' => 'Manager ID',
        ];
    }

    /**
     * Gets query for [[Manager]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(UserInfo::class, ['id' => 'manager_id']);
    }

    public function getStationItems()
    {
        return $this->hasMany(StationItem::class, ['station_id' => 'id']);
    }

    public function getItems()
    {
        return $this->hasMany(Item::class, ['id' => 'item_id'])->via('stationItems');
    }

    /*public function getManagers()
    {
        return $this->hasMany(UserInfo::class, ['id' => 'manager_id'])
            ->viaTable('manager_station', ['station_id' => 'id']);
    }*/

    public function getManagers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('station_users', ['station_id' => 'id'])
            ->andWhere(['role' => 'Manager']);
    }

    public function getManagerStations()
    {
        return $this->hasMany(ManagerStation::class, ['station_id' => 'id']);
    }

    public function getInCharge()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('station_users', ['station_id' => 'id'])
            ->andWhere(['role' => 'In Charge']);
    }

    public function getEmployees()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('station_users', ['station_id' => 'id'])
            ->andWhere(['role' => 'Employee']);
    }

    public function getStationUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('station_users', ['station_id' => 'id']);
    }
}
