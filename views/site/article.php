<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = '首页';
$categoryUrl = Url::to(['site/category', 'id' => $article['category'],]);
?>
<div class="site-index row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><?= $article['fileName']?></h4>
            </div>

            <div class="panel-body">
                <?= $article['content']?>
            </div>
            <ul class="list-inline article-info">
                <li class="text-muted"><i class="fa fa-calendar"></i>  <?=  Yii::$app->formatter->asDate($article['createTime'], 'long') ?></li>
                <li class="text-muted"><i class="fa fa-list-alt"></i> <a href="<?= $categoryUrl ?>" class="text-muted"><?= $article['category'] ?></a></li>
            </ul>
        </div>
    </div>
</div>
