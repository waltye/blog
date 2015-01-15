<?php
/**
 * font-awesome 资源包
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Twitter bootstrap css files.
 *
 * @author waltye <yly520161@gmail.com>
 * @since 2.0
 */
class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@vendor/fortawesome/font-awesome';
    public $css = [
        'css/font-awesome.min.css',
    ];
}