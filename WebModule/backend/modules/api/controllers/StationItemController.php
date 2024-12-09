<?php
    namespace app\modules\api\controllers;

    use common\models\StationItem;
    use yii\rest\ActiveController;
    use yii\web\UnauthorizedHttpException;

    class StationItemController extends ActiveController {
        public $modelClass = StationItem::class;

        // Disable default action "index"
        public function actions()
        {
            $actions = parent::actions();
            unset($actions['index']);
            return $actions;
        }

        public function actionIndex() {
            $stationID = \Yii::$app -> request -> getHeaders() -> get('X-STATION-ID');

            if (!$stationID) {
                throw new UnauthorizedHttpException('No station ID provided');
            }

            return StationItem::find()
                ->joinWith('station')
                ->where(['station_id' => $stationID])
                ->all();
        }
    }
?>