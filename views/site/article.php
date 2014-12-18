<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = '首页';
$categoryUrl = Url::to(['site/category', 'id' => $article['category'],]);
//$articleUrl = Url::to(['site/article', 'dir' => $article['category'], 'name' => $article['fileName']]);
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><?= $article['fileName']?></h4>
                    </div>

                    <div class="panel-body">
                        <?= $article['content']?>
                    </div>

                    <ul class="list-inline gb-index-ul">
                        <li class="text-muted">发布时间: <?=  Yii::$app->formatter->asDate($article['createTime'], 'long') ?></li>
                        <li class="text-muted">所属分类: <a href="<?= $categoryUrl ?>"><?= $article['category'] ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
