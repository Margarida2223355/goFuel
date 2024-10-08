<?php

namespace backend\controllers;

use Yii;
use common\models\Item;
use common\models\Station;
use common\models\StationItem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class StationItemController extends Controller
{
    /**
     * Associar um item a uma estação
     */
    public function actionAddItemToStation($station_id, $item_id)
    {
        $station = Station::findOne($station_id);
        $item = Item::findOne($item_id);

        if (!$station || !$item) {
            throw new NotFoundHttpException('Estação ou Item não encontrado.');
        }

        $station->link('items', $item);

        return $this->redirect(['station/view', 'id' => $station_id]);
    }

    public function actionRemoveItemFromStation($station_id, $item_id)
    {
        $station = Station::findOne($station_id);
        $item = Item::findOne($item_id);

        if (!$station || !$item) {
            throw new NotFoundHttpException('Estação ou Item não encontrado.');
        }

        // Remove o item da estação
        $station->unlink('items', $item, true);

        return $this->redirect(['station/view', 'id' => $station_id]);
    }

    public function actionDelete($id)
    {
        // Encontra o item da estação que você deseja excluir
        $model = StationItem::findOne($id);

        if ($model !== null) {
            // Remove o registro da tabela station_item
            $model->delete();

            // Define uma mensagem de sucesso
            Yii::$app->session->setFlash('success', 'Item removed successfully.');
        } else {
            // Se o registro não for encontrado, define uma mensagem de erro
            Yii::$app->session->setFlash('error', 'Item not found.');
        }

        // Redireciona de volta para a página da estação
        return $this->redirect(['station/view', 'id' => $model->station_id]);
    }
}
