<?php
use yii\helpers\Url;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
$this->title = '首页';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-9">
                <?php
                if(is_array($indexData['article'])){
                    foreach($indexData['article'] as $val){
                    $articleUrl = Url::to(['site/article', 'dir' => $val['category'], 'name' => $val['fileName']]);
                    $categoryUrl = Url::to(['site/category', 'id' => $val['category'],]);
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href="<?= $articleUrl ?>" class="gb-index-a"><?= $val['fileName']?></a>
                            </div>

                            <div class="panel-body">
                                <?= $val['articleBody']?>
                            </div>

                            <ul class="list-inline gb-index-ul">
                                <li class="text-muted">发布时间: <?=  Yii::$app->formatter->asDate($val['createTime'], 'long') ?></li>
                                <li class="text-muted">所属分类: <a href="<?= $categoryUrl ?>"><?= $val['category'] ?></a></li>
                                <li><a href="<?= $articleUrl ?>">查看文章详情</a></li>
                            </ul>
                        </div>
                    <?php
                    }
                } ?>
            </div>
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-user"></i> 关于我</div>
                        <div class="thumbnail">
                            <img src="../img/blogger.png" class="img-responsive img-circle" width="150">
                            <div class="caption">
                                <h3>有厨师天赋的程序猿</h3>
                                <p>编程是一门艺术</p>
                                <ul class="list-inline">
                                    <li><a href="https://github.com/waltye" target="_blank" class="text-muted"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-github fa-stack-1x fa-inverse"></i></span></a></li>
                                    <li><a href="https://twitter.com/waltye1" target="_blank" class="text-muted"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-twitter fa-stack-1x fa-inverse"></i></span></a></li>
                                    <li><a href="http://www.weibo.com/u/1579548053" target="_blank" class="text-muted"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-weibo fa-stack-1x fa-inverse"></i></span></a></li>
                                    <li>
                                        <?php
                                        Modal::begin([
                                        'header' => '<h2>PHP技术文章</h2><p>我的个人微信公众号，有一些有趣的小功能，也会不定期分享一些技术文章。</p><p>扫一扫试试吧!</p>',
                                        'toggleButton' => ['label' => '<i class="text-muted"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-wechat fa-stack-1x fa-inverse"></i></span></i>'],
                                        ]);
                                        echo '<img src="../img/wechat.jpg" class="img-responsive img-thumbnail" alt="微信公众号，试着扫一扫。">';
                                        Modal::end();
                                        ?>
                                    </li>
                                </ul>
                            </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-book fa-fw"></i> 文章分类</div>
                        <div class="list-group">
                            <?php
                            foreach($indexData['category'] AS $val){
                                $url = Url::to(['site/category', 'id' => $val['categoryName'],]);
                                ?>
                                <a class="list-group-item" href="<?= $url ?>"><span class="badge"><?= $val['fileCount'] ?></span><?= $val['categoryName'] ?></a>
                            <?php } ?>
                        </div>
                </div>

            </div>
        </div>
    </div>
</div>
