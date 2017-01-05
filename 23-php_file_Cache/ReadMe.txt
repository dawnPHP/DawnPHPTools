------------------------
Log format for each tools:
------------------------
title: 23-php_file_Cache 
Description:文件缓存实例

keywords: cache
pros&cons: 
	pros: 三种文件缓存实例。
	cons:

version: v1.0.0
mod_time:[]
add_time:[10:19 2017/01/05]
auther: Dawn
Email: jimmymall@live.com

Files&Functions:
==================================================
文件结构：
index.php 	#入口文件
Cache.class.php 核心文件。

==================================================
Databases: 没有.sql文件。



#php页面缓存的机制
一、常用的缓存包括页面缓存，和数据库缓存。

缓存的技术特点：
1、时间触发缓存：
检查文件是否存在并且时间戳小于设置的过期时间,如果文件修改的时间戳比当前时间戳减去过期时间戳大，那么就用缓存，否则更新缓存。
2、内容触发缓存：
当插入数据或更新数据时，强制更新PHP缓存机制。
3、静态缓存：
这里所说的静态缓存是指静态化，直接生成HTML或XML等文本文件，有更新的时候重生成一次，适合于不太变化的页面，这就不说了。。


二，下面是一些php自带缓存指令：
http://www.cnblogs.com/usa007lhy/p/5421545.html

ob_start()  //开启缓存
ob_clean()  //清空缓存
ob_end_clean()  //清空缓存，关闭缓存
ob_flush() //刷新缓存(将缓存现有内容输出)
ob_end_flush()  //刷新缓存，并关闭缓存
$contents = ob_get_contents() //获得缓存内容
file_put_contents("d:/log.txt",$contents) //将缓存内容打印到文本


<?php
ob_start();
echo “aaa”;
header(“content-type:text/html;charset=utf-8”);
echo “hello”;
?>
　　执行第1行开启缓存，执行第2行，将默认消息头以及aaa作为消息体一部分发送给output buffer，执行第3行，修改消息头，执行第4行，将hello发送给output buffer，程序执行完后，output buffer将消息发送给程序缓存，程序缓存输出。


三、php文件缓存
要点：ob_start();开启缓存；文件部分暂时输出到缓存； $content = ob_get_clean(); 清除缓存并保存到变量$content中。
基于这两个函数可以实现基于文件的缓存。可以实现带“继承”的模板系统。
=======================
01	简易带继承的模板系统。

=======================
02 基于时间的缓存

=======================
03 基于内容更新的缓存

=======================
04 怎么主动更新缓存？




