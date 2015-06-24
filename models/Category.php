<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * 文章管理Model
 * @author waltye<yly520161@gmail.com>
 * @since 1.0
 */

class Category extends Model
{
    /**
     * dir
     */
    const GET_TYPE_DIR = 'dir';

    /**
     * files
     */
    const GET_TYPE_FILE = 'file';

    /**
     * markdown
     */
    const GET_TYPE_MD = 'markdown';

    /**
     * articles根路径
     */
    const ARTICLE_ROOT_DIR = '../articles';


    /**
     * 获取首页需要展示的数据
     * @param int $limit 首页默认展示条数,不传值显示所有
     * @return array
     */
    public function getIndexData($limit = null)
    {
        $allArticle = array();
        $categoryList = self::getCategoryList();

        //获取当前所有文章信息
        $i = 0;
        foreach ($categoryList AS $category){
            //获取该分类下所有文章
            $tmpArr = self::getArticleList($category['categoryName']);
            foreach($tmpArr AS $article){
                $allArticle[$i] = $article;
                $i++;
            }
        }

        //按发表时间逆序得到最近的十篇文章
        usort($allArticle, function($a, $b){
            $al = $a['postDate'];
            $bl = $b['postDate'];
            if ($al == $bl)
                return 0;
            return ($al > $bl) ? -1 : 1;
        });
        $allArticle = array_slice($allArticle, 0, $limit);

        //获取文章具体内容以及把.md转成HTML
        $parser = new GithubMarkdown();
        $returnArr['articles'] = array();
        foreach($allArticle as $key => $article){
            $articleInfo = self::getArticleBody($article['category'], $article['articleName']);
            $returnArr['articles'][$key]['id'] = $articleInfo['id'];
            $returnArr['articles'][$key]['category'] = $articleInfo['category'];
            $returnArr['articles'][$key]['articleName'] = $articleInfo['articleName'];
            $returnArr['articles'][$key]['articleBody'] = $parser->parse(mb_substr($articleInfo['content'], 0, 300, 'utf-8'));
            $returnArr['articles'][$key]['postDate'] = $articleInfo['postDate'];
        }
        $returnArr['category'] = $categoryList;
        return $returnArr;
    }

    /**
     * 获取文章分类信息
     * @return array|bool
     */
    public function getCategoryList()
    {
        //获取articles下的文章分类目录
        $categories = self::getFilesByDir(self::ARTICLE_ROOT_DIR, self::GET_TYPE_DIR);
        $categoryList = array();
        $i = 0;
        //根据分类目录获取该目录下的markdown文件。
        foreach($categories AS $category){
            $path = self::ARTICLE_ROOT_DIR . '/' . $category;
            $categoryList[$i]['categoryName'] = $category;
            $categoryList[$i]['fileCount'] = count(self::getFilesByDir($path, self::GET_TYPE_MD));
            $i++;
        }
        //排序，单纯为了展示更美观而已
        usort($categoryList, function($a, $b){
            $al = $a['categoryName'];
            $bl = $b['categoryName'];
            if ($al == $bl)
                return 0;
            return ($al < $bl) ? -1 : 1;
        });
        return $categoryList;
    }

    /**
     * 根据文章分类获取该分类下的所有文章数组
     * 约束条件：必须为文件、必须是以.md结尾
     * @param $category
     * @return array|bool
     */
    public function getArticleList($category)
    {
        $realDir = self::ARTICLE_ROOT_DIR .'/'. $category;
        $files = self::getFilesByDir($realDir, self::GET_TYPE_MD);
        $articleList = array();
        $i = 0;
        foreach($files AS $file){
            $articleInfo = self::getArticleBody($category, $file);
            $articleList[$i]['id'] = $articleInfo['id'];
            $articleList[$i]['category'] = $articleInfo['category'];
            $articleList[$i]['articleName'] = $articleInfo['articleName'];
            $articleList[$i]['postDate'] = $articleInfo['postDate'];
            $i++;
        }
        //按发表时间逆序排序
        usort($articleList, function($a, $b){
            $al = $a['postDate'];
            $bl = $b['postDate'];
            if ($al == $bl)
                return 0;
            return ($al > $bl) ? -1 : 1;
        });

        return $articleList;
    }

    /**
     * 根据文章路径获取文章具体信息
     * @param string $category 目录
     * @param string $articleName 文章名称
     * @return array
     */
    public function getArticleBody($category, $articleName)
    {
        $article = array();
        $path = self::ARTICLE_ROOT_DIR . '/' . $category . '/' . $articleName;
        //文章名带文件格式
        $partnerArr = ['.md', '.MD', '.markdown', '.MARKDOWN'];
        if(in_array(strrchr($articleName, '.'), $partnerArr)){
            if(is_file($path)){
                $articleName = substr($articleName, 0 ,strrpos($articleName, '.'));
                $article = self::getArticleCache($articleName, filectime($path));
                $article['category'] = $category;
                $article['content'] = file_get_contents($path);
            }
        } else {
            $pathArr = [$path . '.md', $path . '.MD',  $path . '.markdown', $path . '.MARKDOWN'];
            foreach($pathArr AS $path){
                if(is_file($path)){
                    $article = self::getArticleCache($articleName, filectime($path));
                    $article['category'] = $category;
                    $article['content'] = file_get_contents($path);
                    break;
                }
            }
        }

        return (array)$article;
    }

    /**
     * 根据文章名称获取文章缓存信息，包括id,articleName,postDate
     * @param string $articleName 文章名称
     * @param int $postDate 发表时间（时间戳）
     * @return array
     */
    private function getArticleCache($articleName, $postDate){
        $analysisFile = Yii::getAlias("@runtime") . '/articles.info';
        $analysisData = file_get_contents($analysisFile);
        $returnArr = array();
        if(!empty($analysisData)){
            $articles = array();
            $first = explode(';', $analysisData);
            //有数据，查询数据；没数据，重新生成
            foreach($first AS $string){
                if(empty($string)) continue;
                $tmpArr = explode(',', $string);
                $articles[$tmpArr[1]]['id'] = $tmpArr[0];
                $articles[$tmpArr[1]]['articleName'] = $tmpArr[1];
                $articles[$tmpArr[1]]['postDate'] = $tmpArr[2];
            }
            //文件已存在文章信息文件中
            if(!empty($articles[$articleName])){
                $returnArr['id'] = $articles[$articleName]['id'];
                $returnArr['articleName'] = $articles[$articleName]['articleName'];
                $returnArr['postDate'] = $articles[$articleName]['postDate'];
            }else{
                $id = count($articles) + 1;
                $string = "{$id},{$articleName},{$postDate};";
                file_put_contents($analysisFile, $string, FILE_APPEND);
                $returnArr['id'] = $id;
                $returnArr['articleName'] = $articleName;
                $returnArr['postDate'] = $postDate;
            }
        }else{
            $id = 1;
            $string = "{$id},{$articleName},{$postDate};";
            if(file_put_contents($analysisFile, $string, FILE_APPEND) !== FALSE){
                $returnArr['id'] = $id;
                $returnArr['articleName'] = $articleName;
                $returnArr['postDate'] = $postDate;
            }
        }
        return (array)$returnArr;

    }

    /**
     * 根据目录名称获取该目录下的所有文件名称
     * @param string $categoryName 目录名称
     * @param string $type 分别对应从目录获取目录，从目录获取文件，从目录获取Markdown文件
     * @return array
     */
    private function getFilesByDir($categoryName, $type = self::GET_TYPE_DIR)
    {
        $returnArr = array();
        if(!is_dir($categoryName)) return $returnArr;
        $tmpArr = array_diff(scandir($categoryName), ['..', '.']);
        switch($type){
            case self::GET_TYPE_FILE:
                foreach($tmpArr AS $fileName){
                    $path = $categoryName. '/' . $fileName;
                    if(is_file($path)) $returnArr[] = $fileName;
                }
                break;
            case self::GET_TYPE_MD:
                foreach($tmpArr AS $fileName){
                    $path = $categoryName. '/' . $fileName;
                    $fileType = strtolower(strrchr($fileName, '.'));
                    if(is_file($path) && ($fileType == '.md' || $fileType == '.markdown')) $returnArr[] = $fileName;
                }
                break;
            case self::GET_TYPE_DIR:
            default:
                foreach($tmpArr AS $dirName){
                    $path = $categoryName. '/' . $dirName;
                    if(is_dir($path)) $returnArr[] = $dirName;
                }
        }
        return (array)$returnArr;
    }
}