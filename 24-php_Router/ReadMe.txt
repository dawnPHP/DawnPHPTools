


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


demo1：常用参数实例。

demo2:借助反射函数求出类中方法的参数列表，并带入进去。config/function.php中的









参考：
1.分享一个PHP项目或者框架可用的路由类Router.class.php
http://www.oschina.net/code/snippet_1424211_51033

2.基于原生PHP的路由分配实现
http://blog.csdn.net/helencoder/article/details/52065969

3.PHP实现一个简单url路由功能
http://www.cnblogs.com/meteoric_cry/archive/2012/07/17/2595375.html

4.用原生PHP写一个像CodeIgniter的路由功能
http://www.nowamagic.net/librarys/veda/detail/1938

5.php路由实现的两种方式
http://yanue.net/post-92.html

