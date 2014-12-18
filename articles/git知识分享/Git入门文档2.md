一、Git基本设置
==========

##1、Git的相关设置
在安装好Git之后，最开始还需要进行一些配置，下面就是配置Git的用户名和邮箱。只有这样，在你提交时，才能显示提交人信息。

    git config --global user.name "yelongyi"
    git config --global user.email "yly520161@gmail.com"
    git config --global --list    //查看当前设置
    user.name=yelongyi
    user.email=yly520161@gmail.com
    
* *还有很多关于Git的设置我们没有说到，但上面两个是**必须的**，其他设置可以参考：<https://www.kernel.org/pub/software/scm/git/docs/git-config.html>*

##2、创建版本库
创建版本库很简单，用Git的 `git init` 命令就行

```
cd ~
mkdir project
cd project/
git init
```

上面的操作我们先创建了project目录，然后在目录里面执行 `git init` 。这样，我们就创建好了Git项目目录。此时，在该目录会产生一个 `.git` 目录，该目录主要用来存放版本库的元数据。

##3、添加和提交记录
在添加和提交之前，我们必须搞清楚Git项目下的文件状态的含义，在Git中有三个地方可以存放你的代码，**工作目录树，暂存区域，版本库**    
![git代码空间图示](http://images.cnblogs.com/cnblogs_com/way-peng/201206/201206071837144259.png  "git代码空间图示")

* **工作目录 :** 就是你新建立一个文件，或者直接从别的地方拷贝到Git项目目录来的文件，都在这个目录。
* **缓存区域 :** 在工作目录中的文件，使用 `git add` 命令就可以将该文件或目录放到缓存区域。
* **版本库 :** 在缓存区域中的文件，使用 `git commit` 命令就可以加入版本库。




加粗**加粗** *xieti*
<http://www.jjwxc.net>

