<?php
    namespace app\modules\api\controllers;

    use common\models\Userinfo;
    use yii\rest\ActiveController;

    class UserinfoController extends ActiveController {
        public $modelClass = Userinfo::class;
    }
?>