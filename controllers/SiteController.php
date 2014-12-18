<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\ContactForm;
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
        $name = Yii::$app->request->get('name');
        $list = Yii::getAlias('@articles') .'/'.$category.'/'.$name;
        $category = new Category();
        $articleBody = $category->getArticleBody($list);
        $parser = new GithubMarkdown();
        $articleBody = $parser->parse($articleBody);
        $categoryList = $category->getCategoryList();
        return $this->render('article',[
            'articleBody' => $articleBody,
            'categoryList' => $categoryList,
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

    public function actionAbout()
    {
        return $this->render('about');
    }
}
