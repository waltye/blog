<?php
use yii\helpers\Url;


/* @var $this yii\web\View */
$this->title = '首页';
?>
<div class="site-index row">
    <div class="col-lg-9">
        <?php
        if(is_array($indexData['article'])){
            foreach($indexData['article'] as $val){
            $articleUrl = Url::to(['site/article', 'dir' => $val['category'], 'name' => $val['fileName']]);
            $categoryUrl = Url::to(['site/category', 'id' => $val['category'],]);
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="<?= $articleUrl ?>" class="article-title"><?= $val['fileName']?></a>
                    </div>
                    <div class="panel-body">
                        <?= $val['articleBody']?>
                    </div>
                    <ul class="list-inline article-info">
                        <li class="text-muted"><i class="fa fa-calendar"></i> <?=  Yii::$app->formatter->asDate($val['createTime'], 'long') ?></li>
                        <li class="text-muted"><i class="fa fa-list-alt"></i> <a href="<?= $categoryUrl ?>" class="text-muted"><?= $val['category'] ?></a></li>
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
                    foreach($indexData['category'] AS $val){
                        $url = Url::to(['site/category', 'dir' => $val['categoryName'],]);
                        ?>
                        <a class="list-group-item" href="<?= $url ?>"><span class="badge"><?= $val['fileCount'] ?></span><?= $val['categoryName'] ?></a>
                    <?php } ?>
                </div>
        </div>
    </div>
</div>
