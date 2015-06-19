<?php
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
$this->title = '首页';
?>
<div class="site-category row">
    <div class="col-lg-9">
        <ul class="list-unstyled">
        <?php
            foreach($articleList as $val){
                $articleUrl = Url::to(['site/article', 'dir' => $val['category'], 'name' => $val['fileName']]);
        ?>
                <li><a href='<?= $articleUrl ?>'><?= $val['fileName'] ?></a></li>
                <hr>
        <?php } ?>
        </ul>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-book fa-fw"></i> 文章分类</div>
            <div class="list-group">
                <?php
                foreach($categoryList AS $val){
                    $url = Url::to(['site/category', 'id' => $val['categoryName'],]);
                    ?>
                    <a class="list-group-item" href="<?= $url ?>"><span class="badge"><?= $val['fileCount'] ?></span><?= $val['categoryName'] ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
