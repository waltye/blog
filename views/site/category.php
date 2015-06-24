<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = $categoryName;
?>
<div class="site-category row">
    <div class="col-lg-9">
        <ul class="list-unstyled">
        <?php
            foreach($articleList as $article){
                $articleUrl = Url::to(['site/article', 'dir' => $article['category'], 'name' => $article['articleName']]);
        ?>
                <li>
                    <a href='<?= $articleUrl ?>'><?= $article['articleName'] ?></a>
                    <span class="pull-right"><?=  Yii::$app->formatter->asDate($article['postDate'], 'php:Y年n月j日') ?></span>
                </li>
                <hr>
        <?php } ?>
        </ul>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-book fa-fw"></i> 文章分类</div>
            <div class="list-group">
                <?php
                foreach($categoryList AS $category){
                    $url = Url::to(['site/category', 'dir' => $category['categoryName'],]);
                    ?>
                    <a class="list-group-item" href="<?= $url ?>"><span class="badge"><?= $category['fileCount'] ?></span><?= $category['categoryName'] ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
