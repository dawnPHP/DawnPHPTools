------------------------
Log format for each tools:
------------------------
title: 24-php_Router 
Description:基于MVC的路由。仿tp3.2的功能 

keywords: router
pros&cons: 
	pros: php的简单路由功能。
	cons:

version: v1.0.0
mod_time:[]
add_time:[17:12 2017/01/07]
auther: Dawn
Email: jimmymall@live.com

Files&Functions:
==================================================
文件结构：
index.php 	#入口文件
.htaccess 保证单入口的文件。
	除非有文件确切路径比如test.txt，否则都要经过index.php。
demo1.php 测试1 基础实验
demo2.php 测试2 功能实验。
	//todo 怎么自己配置路由？自定义路由转向？ 比如xx.com/u/20 自动转向 xx.com/User/detail/id/20

Router.class.php 路由的核心文件。

其他2个文件夹内都是辅助测试文件。
config/
controllers/

==================================================
Databases: 没有.sql文件。




目的：基于MVC的路由。仿tp3.2的功能 
优势：单文件入口，是很多php系统的标准配置。具有很多优势：可以统一过滤。

路由要有2个功能：
	1.路由分发：根据请求的url找到对应的文件并输出数组array('c'=>controller,'a'=>method,'para'=>array());，
	  如果没有文件，就给出错误页面。
	2.url生成：根据要执行的文件，生成对应的url，供显示使用。

知识点：
1.RewriteRule规则。http://yanue.net/post-92.html
2.自动加载。autoload

	
路由原理：
pathinfo方式，所谓的pathinfo，就是形如这样的url。xxx.com/index.php/c/index/aa/cc，apache在处理这个url的时候会把index.php后面的部分输入到环境变量$_SERVER['PATH_INFO']，它等于/c/index/aa/cc。




==================================================
使用方法
--------------------------------------------------
demo1：常用参数实例。

demo2:借助反射函数求出类中方法的参数列表，并带入进去。独立为一个Router类。只有2个对外方法。
1.路由分发。
	Router::init();

2.生成路由：
Router::make("Article");
Router::make("Article/index");
Router::make("Article/index/id/20");
Router::make("Article/index/id/20",array('id'=>5));//后面的会覆盖前面的id。



===============================================================================
//todo
有人认为：
	这种方式应该是路由的最基本形态。
	处理过程简单，但是路由不能随意自定义。
	像www.ruanpower.com/home/index/test/aid/5这样的路由我个人认为还不是太优雅。
	这样目录层次太深了。
	www.ruanpower.com/home/test/5
	这样会好一点。
	如果改造成自定义路由，这其中就要维护路由表，还会用到正则，最主要的是要考虑反向路由。也就是能根据路由表达式和参数生成URL地址。
所以，需要这样的路由 xx.com/item-132.html 
这样实现了简短、伪静态。
名词：路由表、反向路由。

















----------------------------------------------------------------------
参考：
1.分享一个PHP项目或者框架可用的路由类Router.class.php
http://www.oschina.net/code/snippet_1424211_51033

2.基于原生PHP的路由分配实现
http://blog.csdn.net/helencoder/article/details/52065969

开发自己PHP MVC框架（一）
http://blog.csdn.net/fengqiuzhihua/article/details/7913899



3.PHP实现一个简单url路由功能
http://www.cnblogs.com/meteoric_cry/archive/2012/07/17/2595375.html

4.用原生PHP写一个像CodeIgniter的路由功能
http://www.nowamagic.net/librarys/veda/detail/1938

5.php路由实现的两种方式
http://yanue.net/post-92.html


