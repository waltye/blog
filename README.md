###基本概述
**一个轻便的博客发表系统。它能非常简单的帮你部署你自己的博客并能很好的保证你的劳动成果不会遗失。**
* 框架采用: Yii2
* 前端采用: Bootstrap/Font Awesome
* 评论采用: 多说

###特性
* 部署简单。下载压缩包至服务器上然后解压开来就完成了部署。
* 界面清爽、简洁。页面布局简洁，并直接把Markdown文件解析成美观的HTML页面。
* 放弃数据库，文章按原格式永久存储。你书写的文档会按原格式存储，并至少存储在三个地方。
* 发博文简便。文章在本地用Markdown书写后推送到服务器上即可。
* 迁移方便。迁移直接把服务器上文件转存一下即可，无需额外操作。
* 自由度高。这个系统只是一个最简单博客系统实现，你可以在这个系统上随意自定义更改。

###环境需求
PHP >= 5.4

###安装方法
1. 下载最新稳定版本并解压至你的服务器Web根目录。[下载页面](https://github.com/waltye/blog/releases "Download blog")
2. 博客已经部署好了，现在可以直接访问: `http://你的域名/web/index.php` 查看效果了。

###文章目录管理
1. 编辑 `/articles/` 目录的子目录即可。如：你在 `/articles/` 目录下新建一个目录，就增加了一个目录。可以随意增删改，网站目录页面会自己改变。
2. 推送至服务器。

###发布文章
发布文章仅支持Markdown格式的文件。所以发布文章的流程是这样的：
1. 使用本地或在线Markdown编辑器写好文章并保存为 `.md` 后缀结尾的Markdown文件。
2. 拷贝至 `/articles/` 下的任意目录下。
3. 推送至服务器。

###文章评论
文章评论采用的是[多说](http://www.duoshuo.com/)，默认不显示，但仍旧占用资源，所以建议还是开启。
* 开启评论模块方法: 修改 `/views/site/article.php` 文件中的 多说应用名称 `short_name` 为你自己的。


###支持
* 欢迎 `Fork` 并提出 `Pull Request` 请求
* 关于此系统的详细信息，参见：[详细文档](http://www.yelongyi.com/site/article?dir=%E5%B7%A5%E5%85%B7%E6%8C%87%E5%8D%97&name=%E8%BD%BB%E4%BE%BF%E5%8D%9A%E5%AE%A2%E5%8F%91%E5%B8%83%E7%B3%BB%E7%BB%9F%E4%BD%BF%E7%94%A8%E6%8C%87%E5%8D%97)
* 此系统搭建的博客示例： [叶龙意的刻画板](http://www.yelongyi.com)
