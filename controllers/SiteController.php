<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Category;
use app\models\GithubMarkdown;

/**
 * Class SiteController
 * @package app\controllers
 * @since 1.0
 */
class SiteController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * 首页展示
     * @return string
     */
    public function actionIndex()
    {
        $category = new Category();
        $indexData = $category->getIndexData();
        return $this->render('index', [
            'indexData'=> $indexData,
        ]);
    }

    /**
     * 文章目录列表
     * @return string
     */
    public function actionCategory(){
        $name = Yii::$app->request->get('dir');
        $category = new Category();
        $articleList = $category->getArticleList($name);
        $categoryList = $category->getCategoryList();
        return $this->render('category',[
            'categoryName' => $name,
            'articleList' => $articleList,
            'categoryList' => $categoryList,
        ]);
    }

    /**
     * 具体文章显示
     * @return string
     */
    public function actionArticle(){
        $categoryName = Yii::$app->request->get('dir');
        $articleName = Yii::$app->request->get('name');
        $categoryModel = new Category();
        $articleInfo = $categoryModel->getArticleBody($categoryName, $articleName);
        $parser = new GithubMarkdown();
        $articleInfo['content'] = $parser->parse($articleInfo['content']);
        $articleInfo['category'] = $categoryName;

        return $this->render('article',[
            'article' => $articleInfo,
        ]);
    }
}
