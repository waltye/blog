<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = $article['articleName'];
$categoryUrl = Url::to(['site/category', 'dir' => $article['category'],]);
?>
<div class="site-index row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><?= $article['articleName']?></h4>
            </div>

            <div class="panel-body">
                <?= $article['content']?>
            </div>
            <ul class="list-inline article-info">
                <li class="text-muted"><i class="fa fa-calendar"></i>  <?=  Yii::$app->formatter->asDate($article['postDate'], 'php:Y年n月j日') ?></li>
                <li class="text-muted"><i class="fa fa-list-alt"></i> <a href="<?= $categoryUrl ?>" class="text-muted"><?= $article['category'] ?></a></li>
            </ul>
        </div>
        <!-- 多说评论框 start -->
        <div class="ds-thread" data-thread-key="<?= $article['id'] ?>" data-title="<?= $article['articleName']?>" data-url="<?= $categoryUrl ?>"></div>
        <!-- 多说评论框 end -->
        <!-- 多说公共JS代码 start (一个网页只需插入一次) -->
        <script type="text/javascript">
            var duoshuoQuery = {short_name:"yelongyi"};
            (function() {
                var ds = document.createElement('script');
                ds.type = 'text/javascript';ds.async = true;
                ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
                ds.charset = 'UTF-8';
                (document.getElementsByTagName('head')[0]
                    || document.getElementsByTagName('body')[0]).appendChild(ds);
            })();
        </script>
        <!-- 多说公共JS代码 end -->
    </div>
</div>
