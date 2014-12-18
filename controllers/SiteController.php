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

    public function actionIndex()
    {
        $category = new Category();
        $indexData = $category->getIndexData();
        return $this->render('index', [
            'indexData'=> $indexData,
        ]);
    }

    public function actionCategory(){
        $name = Yii::$app->request->get('id');

        $category = new Category();
        $articleList = $category->getArticleList($name);
        $categoryList = $category->getCategoryList();
        return $this->render('category',[
            'articleList' => $articleList,
            'categoryList' => $categoryList,
        ]);
    }

    public function actionArticle(){
        $category = Yii::$app->request->get('dir');
        $fileName = Yii::$app->request->get('name');
        $list = Yii::getAlias('@articles') . '/' . $category . '/' . $fileName;
        $category = new Category();
        $articleBody = $category->getArticleBody($list);
        $parser = new GithubMarkdown();
        $articleBody['content'] = $parser->parse($articleBody['content']);
        return $this->render('article',[
            'article' => $articleBody,
        ]);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

}
