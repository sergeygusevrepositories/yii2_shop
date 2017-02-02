<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 24.01.17
 * Time: 21:51
 */

namespace app\controllers;
use app\models\Product;
use app\models\Category;
use Yii;
use yii\data\Pagination;


class CategoryController extends AppController
{
    
    public function actionIndex()
    {
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        $this->setMeta("E-SHOPPER");
        
        return $this->render('index', compact('hits'));
    }

    public function actionView($id)
    {
        $category = Category::findOne($id);
        if(empty($category))
            throw new \yii\web\HttpException(404, 'Такой категории нет.');
        $query = Product::find()->where(['category_id' => $id]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        $this->setMeta("E-SHOPPER | " . $category->name, $category->keywords, $category->description);
        return $this->render('view', compact('products', 'pages', 'category'));
    }

    public function actionSearch()
    {
        $q = Yii::$app->request->get('q');
        $this->setMeta("E-SHOPPER | Поиск: " . $q);
        if(!$q)
            return $this->render('search');
        $query = Product::find()->where(['like', 'name', $q]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('search', compact('products', 'pages', 'q'));
    }
    
}