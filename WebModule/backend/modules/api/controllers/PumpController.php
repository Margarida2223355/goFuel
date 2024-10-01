<?php
    namespace app\modules\api\controllers;

    use common\models\Pump;
    use yii\rest\ActiveController;

    class PumpController extends ActiveController {
        public $modelClass = Pump::class;
    }
?>