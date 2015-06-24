<?php
use yii\helpers\Url;


/* @var $this yii\web\View */
$this->title = '首页';
?>
<div class="site-index row">
    <div class="col-lg-9">
        <?php
        if(is_array($indexData['articles'])){
            foreach($indexData['articles'] as $article){
            $articleUrl = Url::to(['site/article', 'dir' => $article['category'], 'name' => $article['articleName']]);
            $categoryUrl = Url::to(['site/category', 'dir' => $article['category'],]);
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="<?= $articleUrl ?>" class="article-title"><?= $article['articleName']?></a>
                    </div>
                    <div class="panel-body">
                        <?= $article['articleBody']?>
                    </div>
                    <ul class="list-inline article-info">
                        <li class="text-muted"><i class="fa fa-calendar"></i> <?=  Yii::$app->formatter->asDate($article['postDate'], 'php:Y年n月j日') ?></li>
                        <li class="text-muted"><i class="fa fa-list-alt"></i> <a href="<?= $categoryUrl ?>" class="text-muted"><?= $article['category'] ?></a></li>
                    </ul>
                </div>
            <?php
            }
        } ?>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-book fa-fw"></i> 文章分类</div>
                <div class="list-group">
                    <?php
                    foreach($indexData['category'] AS $category){
                        $url = Url::to(['site/category', 'dir' => $category['categoryName'],]);
                        ?>
                        <a class="list-group-item" href="<?= $url ?>"><span class="badge"><?= $category['fileCount'] ?></span><?= $category['categoryName'] ?></a>
                    <?php } ?>
                </div>
        </div>
    </div>
</div>
