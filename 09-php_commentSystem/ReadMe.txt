


v1.0.1
用ajax改写 删除评论。在级联删除多个dom时耗时较多：
1.php通过ajax返回的序列化的数组在js中需要eval后使用。
2.熟悉dom的删除操作。


------------------------
Log format for each tools:
------------------------
title: PHP评论系统
Description:适用于博客文章、照片等的评论
	重要思路：
		1.表格设计上加父评论id(pid)，一级父评论pid=0，二级回复pid为真实值；
		2.所有评论递归循环输出；
		3.使用php输出各评论的dom的id给js，使用js给条目添加删除和回复事件；
		4.一旦删除某条评论，则级联删除其子评论，及子评论的评论...
		


keywords:评论
pros&cons: 还没有添加注册用户系统，后续还需要改版

version: v1.0.0
time:[21:50 2015-10-01]
auther: Dawn
Email: jimmymall@live.com

Files&Functions:
==================================================
---共4个文件：
 |- comment.php	显示评论的演示 
 |- conn.php	连接数据库
 |- action.php	执行增删的文件（没有改）
 |- Temp_function.php	一些自定义函数
 |
 |-diguiDemo.php 遇到一个php函数递归return的bug。附有解决方案。
==================================================
Databases: 
CREATE TABLE `comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aid` int(10) DEFAULT NULL,
  `pid` int(10) DEFAULT '0',
  `comment` text,
  `uid` int(10) DEFAULT NULL,
  `nickName` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `comment_time` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


mysql> desc comment;
+--------------+-------------+------+-----+---------+----------------+
| Field        | Type        | Null | Key | Default | Extra          |
+--------------+-------------+------+-----+---------+----------------+
| id           | int(10)     | NO   | PRI | NULL    | auto_increment |
| aid          | int(10)     | YES  | MUL | NULL    |                |
| pid          | int(10)     | YES  |     | 0       |                |
| comment      | text        | YES  |     | NULL    |                |
| uid          | int(10)     | YES  | MUL | NULL    |                |
| nickName     | varchar(30) | YES  |     | NULL    |                |
| email        | varchar(30) | YES  |     | NULL    |                |
| comment_time | varchar(30) | YES  |     | NULL    |                |
+--------------+-------------+------+-----+---------+----------------+
8 rows in set (0.08 sec)
