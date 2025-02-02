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
 * @property int $is_deleted
 * @property string|null $image
 *
 * @property InvoiceLine[] $invoiceLines
 * @property StationItem[] $stationItems
 * @property Station[] $stations
 * @property Subcategory $subcategory
 */
class Item extends \yii\db\ActiveRecord
{
    public $imageFile;
    public static function tableName()
    {
        return 'items';
    }

    public function rules()
    {
        return [
            [['description', 'subcategory_id', 'restock_qty'], 'required'],
            [['subcategory_id', 'restock_qty', 'is_deleted'], 'integer'],
            [['image'], 'string'],
            [['description'], 'string', 'max' => 255],
            [['subcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subcategory::class, 'targetAttribute' => ['subcategory_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'subcategory_id' => 'Subcategory ID',
            'restock_qty' => 'Restock Qty',
            'is_deleted' => 'Is Deleted',
            'image' => 'Image',
        ];
    }

    public function getInvoiceLines()
    {
        return $this->hasMany(InvoiceLine::class, ['item_id' => 'id']);
    }

    public function getStationItems()
    {
        return $this->hasMany(StationItem::class, ['item_id' => 'id']);
    }

    public function getStations()
    {
        return $this->hasMany(Station::class, ['id' => 'station_id'])->viaTable('station_items', ['item_id' => 'id']);
    }

    public function getSubcategory()
    {
        return $this->hasOne(Subcategory::class, ['id' => 'subcategory_id']);
    }

    public function fields()
    {
        $fields = parent::fields();

        unset($fields['subcategory_id'],  $fields['category_id']);

        $fields['subcategory'] = function () {
            $subcategory = $this->getSubcategory()->one();
            return $subcategory ? $subcategory : null;
        };

        return $fields;
    }

    /*public function upload()
    {
        if ($this->imageFile) {
            $uploadPath = __DIR__ . '/../../images/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $fileName = 'item_' . $this->id . '.' . $this->imageFile->extension;
            $filePath = $uploadPath . $fileName;

            if ($this->imageFile->saveAs($filePath)) {
                $this->image = $fileName;
                $this->save();
                return true;
            }
        }
        dd('Erro na imagem');
        return false;
    }*/

    public function upload()
    {
        if ($this->imageFile) {
            $uploadPath = __DIR__ . '/../../images/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $fileName = $this->imageFile->name;
            $filePath = $uploadPath . $fileName;

            if ($this->imageFile->saveAs($filePath)) {
                $this->image = $fileName;
                $this->save();
                return true;
            }
        }

        return false;
    }
}
