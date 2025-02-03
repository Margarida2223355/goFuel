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
 * @property string|null $phone
 * @property int $is_deleted
 *
 * @property ClientStation[] $clientStations
 * @property User[] $clients
 * @property Invoice[] $invoices
 * @property Item[] $items
 * @property User $manager
 * @property ManagerStation[] $managerStations
 * @property User[] $managers
 * @property Pump[] $pumps
 * @property StationItem[] $stationItems
 * @property StationUser[] $stationUsers
 * @property User[] $users
 */
class Station extends \yii\db\ActiveRecord
{
    public $imageFile;
    public static function tableName()
    {
        return 'stations';
    }
    public $pumps_count; // Adicione esta propriedade

    // Se usar regras de validação, adicione:

    public function rules()
    {
        return [
            [['name', 'address', 'postal_code', 'manager_id'], 'required'],
            [['manager_id', 'is_deleted'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
            [['postal_code'], 'string', 'max' => 20],
            [['phone'], 'string', 'max' => 45],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['manager_id' => 'id']],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'postal_code' => 'Postal Code',
            'manager_id' => 'Manager ID',
            'phone' => 'Phone',
            'is_deleted' => 'Is Deleted',
        ];
    }

    public function getClientStations()
    {
        return $this->hasMany(ClientStation::class, ['station_id' => 'id']);
    }

    public function isFavoritedByUser($userId)
    {
        if ($this->getClientStations()->where(['client_id' => $userId])->exists()) {
            return true;
        } else {
            return false;
        }
        return $this->getClientStations()
            ->where(['client_id' => $userId])
            ->exists();
    }

    public function getClients()
    {
        return $this->hasMany(User::class, ['id' => 'client_id'])->viaTable('client_station', ['station_id' => 'id']);
    }

    public function getInvoices()
    {
        return $this->hasMany(Invoice::class, ['station_id' => 'id']);
    }

    public function getItems()
    {
        return $this->hasMany(Item::class, ['id' => 'item_id'])->viaTable('station_items', ['station_id' => 'id']);
    }

    public function getManager()
    {
        return $this->hasOne(User::class, ['id' => 'manager_id']);
    }

    public function getManagerStations()
    {
        return $this->hasMany(ManagerStation::class, ['station_id' => 'id']);
    }

    public function getManagers()
    {
        return $this->hasMany(User::class, ['id' => 'manager_id'])->viaTable('manager_station', ['station_id' => 'id']);
    }

    public function getPumps()
    {
        return $this->hasMany(Pump::class, ['station_id' => 'id']);
    }

    public function getStationItems()
    {
        return $this->hasMany(StationItem::class, ['station_id' => 'id']);
    }

    public function getStationUsers()
    {
        return $this->hasMany(StationUser::class, ['station_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('station_users', ['station_id' => 'id']);
    }

    public function upload()
    {
        if ($this->imageFile) {
            $uploadPath = __DIR__ . '/../../images/stations/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $fileName = $this->imageFile->name;
            $filePath = $uploadPath .  $this->name . '.png';

            if ($this->imageFile->saveAs($filePath)) {
                $this->image = base64_encode(file_get_contents($uploadPath .  $this->name . '.png'));
                $this->save();
                return true;
            }
        }

        return false;
    }
}
