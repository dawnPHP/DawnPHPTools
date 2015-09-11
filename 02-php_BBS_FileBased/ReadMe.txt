------------------------
Log format for each tools:
------------------------
title:02-php_BBS_FileBased 
Description:基于文件的简易浏览版
keywords:BBS
pros&cons:不含注册登录等用户模块。


version: V1.0
time:[9:23 2015-09-11]
auther: Dawn
Email: jimmymall@live.com

Files:
===================================================
1.基于文本的留言本系统（面向过程）
文件结构:
|-menu.php //公共菜单（浏览、发帖），css表
|
|-index.php //显示帖子列表，点击查看内容
|			根据帖子id显示帖子内容；
|-add.php//发布帖子界面，调用action.php执行写入文件
|
|-edit.php //修改帖子界面，调用action.php执行写入文件
|
|-action.php //执行文件的增、删、改
|
|-function.php //自定义php函数
|
|-tiezi.txt //记录帖子内容



描述：
（1）实现了基于文件的留言板，能浏览标题，点击查看内容；
（2）对留言条目的增、删、改功能；
（3）界面略微美化；
（4）对删除做了js提示；
（5）使用配置文件定义文本文件名，便于修改；

缺点：
（1）没有用户系统；
（2）没有分页；
（3）没有使用MySql数据库，留言内容有很大的局限性；
（4）使用的面向过程，代码重用率不高；
（5）代码重复性很高。
http://firecloudphp.blog.163.com/blog/static/250822070201562645725885/

===================================================

Databases: NO
	
check: 10:25 2015-09-11 validated.