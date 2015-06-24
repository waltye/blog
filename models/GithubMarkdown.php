<?php
namespace app\models;

use cebe\markdown\GithubMarkdown as GFM;

/**
 * 使用Github风格的markdown解析器
 * Class GithubMarkdown
 * @package app\models
 * @since 1.0
 */
class GithubMarkdown extends GFM
{
    /**
     * 回车等于<br />
     * @var bool
     */
    public $enableNewlines = true;

    /**
     * 使用html5标签解析
     * @var bool
     */
    public $html5 = true;

}