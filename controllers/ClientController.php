<?php


namespace app\controllers;

use app\models\Client;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ClientController extends ActiveController
{
    public $modelClass = 'app\models\Client'; // Specify the namespace of your Client model

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetOrderedProducts($clientId)
    {
        $client = Client::findOne($clientId);

        if (!$client) {
            throw new NotFoundHttpException('Client not found.');
        }

        $sql = "
            SELECT product.title, product.price, order_product.quantity
            FROM `order`
            RIGHT JOIN order_product ON `order`.id = order_product.order_id
            LEFT JOIN product ON product.id = order_product.product_id
            WHERE `order`.client_id = :clientId
        ";

        $orderedProducts = Yii::$app->db->createCommand($sql, [':clientId' => $clientId])->queryAll();

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $orderedProducts;

    }
}
