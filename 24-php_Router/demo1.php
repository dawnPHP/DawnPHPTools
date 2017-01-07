<?php 

/**
1.目的：测试几个常见url获取和处理方法
建议参考一下tp或者yii等开源框架url路由的写法，总结出来自己的东西。



2.简易路由的建立顺序

https://www.zhihu.com/question/22968258
一、开启apache的mod_rewrite（URL重写模块），并使Apache支持.htaccess
这个自行百度。

二、配置.htaccess
开启了mod_rewrite后，只是开启了URL重写模块，但是没有配置URL重写规则。所以要写一下规则（这些规则是用正则表达式写的，如果不会就很麻烦了）。
在网站根目录创建一个.htaccess文件，然后里面输入：
RewriteEngine On
RewriteRule ^([a-zA-Z0-9/]*)$ index.php/$1

上面是我随手写的规则，肯定有更好的。
我解释一下上面的规则：
假如有一个URL:
http://127.0.0.1/abc/def
经过上面的解析后，就变成了http://127.0.0.1/index.php/abc/def

三、创建index.php
<?php
$pathinfo = explode('/',$_SERVER['PATH_INFO']);
echo '控制器：',$pathinfo[1];
echo '<br />';
echo '模块：',$pathinfo[2] != ''?$pathinfo[2]:'index';
echo '<br />';
echo '参数：',var_dump($_GET);
效果如下：

*/


echo '<pre>';
debug('PHP_SELF = '.$_SERVER['PHP_SELF']);

//$_SERVER['DOCUMENT_ROOT']是Apache配置文件中设置的DocumentRoot的值,是指服务器中定义的文档根目录（当前脚本所在的）
debug( 'DOCUMENT_ROOT = '.$_SERVER['DOCUMENT_ROOT'] );//F:/xampp/htdocs/
//是指当前脚本的绝对路径和文件名。
debug( 'PATH_INFO = '.$_SERVER['PATH_INFO'] );//获取path_info信息 id/2007

debug( 'REQUEST_URI = '.$_SERVER['REQUEST_URI'] );
debug( '__FILE__ = '.__FILE__ );  //F:\xampp\htdocs\DawnPHPTools\24-php_Router\index.php



//============================================
//http://localhost/DawnPHPTools/24-php_Router/Article/index/id/2007
$pathinfo = explode('/',$_SERVER['PATH_INFO']); ///Article/index/id/2007
echo '控制器：',$pathinfo[1] .'<br />'; //Article
echo '模块：',$pathinfo[2] != ''?$pathinfo[2]:'index' , '<br />';//index
echo '参数：',var_dump($_GET);
//============================================

//$_SERVER['REDIRECT_STATUS']=404;//有啥用？

echo '服务器数组： _SERVER=';
debug($_SERVER);