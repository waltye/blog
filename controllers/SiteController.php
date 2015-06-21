<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Category;
use cebe\markdown\GithubMarkdown;

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
            'articleList' => $articleList,
            'categoryList' => $categoryList,
        ]);
    }

    /**
     * 具体文章显示
     * @return string
     */
    public function actionArticle(){
        $category = Yii::$app->request->get('dir');
        $fileName = Yii::$app->request->get('name');
        $list = Yii::getAlias('@articles') . '/' . $category . '/' . $fileName;
        $category = new Category();
        $articleBody = $category->getArticleBody($list);
        $parser = new GithubMarkdown();
        $parser->html5 = true;
        $parser->enableNewlines = true;
        $articleBody['content'] = $parser->parse($articleBody['content']);
        return $this->render('article',[
            'article' => $articleBody,
        ]);
    }
}
