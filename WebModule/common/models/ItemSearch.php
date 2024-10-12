<?php

class ItemSearch extends \yii\base\Model
{
    public $stationId;

    public function rules()
    {
        return [
            [['stationId'], 'integer'],
        ];
    }
}
