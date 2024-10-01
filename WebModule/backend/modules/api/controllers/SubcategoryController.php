<?php
    namespace app\modules\api\controllers;

    use common\models\Subcategory;
    use yii\rest\ActiveController;

    class SubcategoryController extends ActiveController {
        public $modelClass = Subcategory::class;
    }
?>