<?php
    namespace app\modules\api\controllers;

    use common\models\Station;
    use yii\rest\ActiveController;

    class StationController extends ActiveController {
        public $modelClass = Station::class;
    }
?>