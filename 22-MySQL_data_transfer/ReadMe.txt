------------------------
Log format for each tools:
------------------------
title: 22-MySQL_data_transfer 
Description:MySQL数据查询和搬迁。

keywords: cache
pros&cons: 
	pros: 几个常用操作MySQL的脚本。
	cons:

version: v1.0.0
mod_time:[]
add_time:[10:19 2017/01/01]
auther: Dawn
Email: jimmymall@live.com

Files&Functions:
==================================================
文件结构：
modify_mysql_user.php #可以直接用。
log_reader.php #读取日志文件。
utils/db/MysqlHelper.class.php 核心类

==================================================
Databases: think_user表
show create table think_user;

CREATE TABLE `think_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user` varchar(20) DEFAULT NULL,
  `passwd` char(35) DEFAULT 'e10adc3949ba59abbe56e057f20f883e',
  `email` varchar(100) DEFAULT NULL,
  `add_time` varchar(30) DEFAULT NULL,
  `modi_time` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8

*/

//todo: file_put_contents()用在__destruct中记录失败，why?


