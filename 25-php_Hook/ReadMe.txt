------------------------
Log format for each tools:
------------------------
title: 25-php_Hook 
Description:php钩子机制

keywords: router
pros&cons: 
	pros: php钩子有很多种，一一实现。
	cons: 不能挂载类中的方法，只能挂载函数。

version: v1.0.0
mod_time:[]
add_time:[09:35 2017/02/15]
auther: Dawn
Email: jimmymall@live.com

Files&Functions:
==================================================
文件结构：
lib/Hook.class.php 钩子类
lib/function.php 钩子函数库
hookDemo1.php 钩子实例

==================================================
Databases: 没有.sql文件。


/*
1.需要执行的地方放好钩子;
2.支持在钩子上注册函数，可以注册0个，一个或多个；
3.支持传递参数；

4.可以调用函数，也可以调动类的方法。

refer：tp的行为,ci的hook类, wp的plugin机制,
drupal更有资格说hook,
wordpress、discuz的源代码有更多插件机制（简易版参考002/目录）
tp叫事件和行为。
sy2，yii2叫event
*/



==================================================
使用方法
--------------------------------------------------
预先给钩子注册函数。
然后在代码需要的位置上监听钩子。
参考demo例子。


refer:
http://blog.csdn.net/ljuncong/article/details/50753908
https://github.com/bainternet/PHP-Hooks

http://baijunyao.com/article/85