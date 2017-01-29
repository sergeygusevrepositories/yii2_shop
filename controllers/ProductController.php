<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 26.01.17
 * Time: 21:33
 */

namespace app\controllers;
use app\models\Product;
use app\models\Category;
use Yii;

class ProductController extends AppController
{
    public function actionView($id)
    {
        $product = Product::findOne($id);
        if(empty($product))
            throw new \yii\web\HttpException(404, 'Такго товара нет.');
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        $this->setMeta("E-SHOPPER | " . $product->name, $product->keywords, $product->description);

        return $this->render('view', compact('product', 'hits'));
    }
}