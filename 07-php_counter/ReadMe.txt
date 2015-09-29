------------------------
Log format for each tools:
------------------------
title: PHP计数器
Description:极其简单的PHP计数器，适用于博客文章阅读次数的统计
keywords:mysql基础操作
pros&cons: 还需完善评论计数功能

version: v1.0.0
time:[18:01 2015-09-29]
auther: Dawn modify from
	http://blog.csdn.net/wyhuan1030/article/details/6138635
Email: jimmymall@live.com

Files&Functions:
==================================================
---共2个文件：
|-counter.php	计数器的核心
|
|-poster.html	计数器用法实例



==================================================
Databases: 在count.php中配置mysql信息

/*
--
-- 表的结构 `counter`
--
CREATE TABLE IF NOT EXISTS `counter` (
  `id` int(20) NOT NULL auto_increment PRIMARY KEY ,
  `aid` varchar(20) default NULL UNIQUE KEY,
  `click_num` int(20) default NULL,
  `class` varchar(20) default 'blog'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
+-----------+---------+------+-----+---------+----------------+
| Field     | Type    | Null | Key | Default | Extra          |
+-----------+---------+------+-----+---------+----------------+
| id        | int(11) | NO   | PRI | NULL    | auto_increment |
| aid       | int(11) | YES  | UNI | NULL    |                |
| click_num | int(11) | YES  |     | NULL    |                |
+-----------+---------+------+-----+---------+----------------+
unique ky 与primary key的区别：
http://zccst.iteye.com/blog/1697043
*/
