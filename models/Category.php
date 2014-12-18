<?php
namespace app\models;

use Yii;
use yii\base\Model;
use cebe\markdown\GithubMarkdown;
/**
 * 文章分类Model
 * @author waltye<yly520161@gmail.com>
 * @since 1.0
 */

class Category extends Model
{
    /*
     * 获取文章分类
     */
    public function getCategoryList()
    {
        $categoryList = [];
        $articleDir = Yii::getAlias('@articles');
        if(!is_dir($articleDir)) return false;
        if($dh = opendir($articleDir))
        {
            $i = 0;
            while (($file = readdir($dh)) !== false)
            {
                $realFileName = $articleDir.'/'.$file;
                if($file == '.' || $file == '..' || filetype($realFileName) != 'dir') continue;
                $categoryList[$i]['categoryName'] = $file;
                //获取文章分类下有多少文章，-2是去除.和..目录
                $categoryList[$i]['fileCount'] = count(scandir($realFileName)) - 2;
                $i++;
            }
            closedir($dh);
        }
        return $categoryList;
    }

    /**
     * 根据文章分类获取该分类下的所有文章名称
     * @param $category
     * @return array|bool
     */
    public function getArticleList($category)
    {
        $articleList = [];
        $realDir = Yii::getAlias('@articles') .'/'. $category;
        if(!is_dir($realDir)) return false;
        if($dh = opendir($realDir))
        {
            while (($file = readdir($dh)) !== false)
            {
                $realFileName = $realDir.'/'.$file;
                if($file == '.' || $file== '..' || filetype($realFileName) != 'file') continue;

                $articleList[] = [
                    'category' => $category,
                    'fileName' => substr($file, 0, strrpos($file, '.')),
                    'createTime' => filectime($realFileName),
                    'modifyTime' => filemtime($realFileName),
                ];
            }
            closedir($dh);
        }

        return $articleList;
    }

    /**
     * 获取首页需要展示的数据
     * @param int $limit 首页默认展示条数
     * @return array  首页可用数据
     */
    public function getIndexData($limit = 10){
        $tmpArr = array();
        $allArticle = array();
        $categoryList = self::getCategoryList();

        //获取当前所有文章信息
        foreach ($categoryList as $v)
        {
            $allArticle[] = self::getArticleList($v['categoryName']);
        }

        foreach($allArticle as $val)
        {
            foreach($val as $value)
            {
                $tmpArr[] = $value;
            }
        }

        //按发表时间逆序得到最近的十篇文章
        usort($tmpArr, function($a, $b) {
            $al = $a['createTime'];
            $bl = $b['createTime'];
            if ($al == $bl)
                return 0;
            return ($al > $bl) ? -1 : 1;
        });
        $tmpArr = array_slice($tmpArr, 0, $limit);

        //获取文章具体内容以及把.md转成HTML
        $key = null;
        $val = null;
        $realDir = Yii::getAlias('@articles');
        $parser = new GithubMarkdown();
        $returnArr['article'] = array();
        foreach($tmpArr as $key => $val){
            $link = $realDir . '/' . $val['category'] . '/' . $val['fileName'];
            $articleBody = self::getArticleBody($link);
            $returnArr['article'][$key]['articleBody'] = $parser->parse(mb_substr($articleBody['content'], 0, 300, 'utf-8'));

            $returnArr['article'][$key]['category'] = $val['category'];
            $returnArr['article'][$key]['fileName'] = $val['fileName'];
            $returnArr['article'][$key]['createTime'] = $val['createTime'];
            $returnArr['article'][$key]['modifyTime'] = $val['modifyTime'];
        }
        $returnArr['category'] = $categoryList;
        return $returnArr;
    }


    /**
     * 根据文章路径获取文章具体信息
     * @param $link *这里是绝对路径
     * @return array 结果数组
     */
    function getArticleBody($link){
        $bodyArr = array();
        $link = strpos($link, '.md') === false ? $link . '.md' : $link;
        if(is_file($link))
        {
            $tmpArr = explode('/', $link);
            $fileName = array_pop($tmpArr);
            $category = array_pop($tmpArr);
            $bodyArr['category'] = $category;
            $bodyArr['fileName'] = substr($fileName, 0, strrpos($fileName, '.'));
            $bodyArr['content'] = file_get_contents($link);
            $bodyArr['createTime'] = filectime($link);
            $bodyArr['modifyTime'] = filemtime($link);
        }

        return $bodyArr;
    }
}