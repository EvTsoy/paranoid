<?php

namespace app\controllers;

use app\models\Order;
use app\models\OrderProduct;
use yii\web\Response;

class OrderController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Order';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']); // Disable default index action
        return $actions;    }

    public function actionCreate()
    {
        $request = \Yii::$app->getRequest();
        $response = \Yii::$app->getResponse();

        // Parse incoming JSON data
        $data = $request->getBodyParams();

        // Validate and process data
        // ...

        // Create order
        $order = new Order();
        $order->client_id = $data['client_id'];
        $order->created_at = date('Y-m-d H:i:s');
        $order->save();

        // Create order items
        foreach ($data['products'] as $productData) {
            $orderItem = new OrderProduct();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $productData['product_id'];
            $orderItem->quantity = $productData['quantity'];
            $orderItem->save();
        }

        // Return response
        $response->format = Response::FORMAT_JSON;
        return ['success' => true, 'message' => 'Order created successfully.'];
    }
}

