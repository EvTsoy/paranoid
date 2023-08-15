<?php


namespace app\controllers;

use app\models\Product;
use Yii;
use yii\rest\ActiveController;
use yii\web\Response;

class ProductController extends ActiveController
{
    public $modelClass = 'app\models\Product';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']); // Disable default index action
        return $actions;
    }

    public function actionIndex()
    {
        $cacheKey = 'product_list';

        // Try to retrieve data from cache
        $data = Yii::$app->cache->get($cacheKey);

        if ($data === false) {
            // Cache miss, fetch and cache the data
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => Product::find(), // Fetch all products
            ]);
            $data = $dataProvider->getModels();
            Yii::$app->cache->set($cacheKey, $data, 3600); // Cache for 1 hour
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
    }
}
