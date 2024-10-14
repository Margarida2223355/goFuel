<?php
    namespace app\modules\api\controllers;

    use common\models\StationItem;
    use yii\rest\ActiveController;

    class StationItemController extends ActiveController {
        public $modelClass = StationItem::class;
    }
?>