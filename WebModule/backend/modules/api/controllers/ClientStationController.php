<?php
    namespace app\modules\api\controllers;

    use common\models\ClientStation;
    use yii\rest\ActiveController;

    class ClientStationController extends ActiveController {
        public $modelClass = ClientStation::class;

        // Disable default action "index"
        public function actions()
        {
            $actions = parent::actions();
            unset($actions['index']);
            return $actions;
        }

        public function actionIndex() {
            $userID = \Yii::$app -> request -> getHeaders() -> get('X-USER-ID');

            if (!$userID) {
                throw new UnauthorizedHttpException('No user ID provided');
            }

            return ClientStation::find()
                -> where(['client_id' => $userID])
                -> all();
        }
    }
?>