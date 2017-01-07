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

以上是单页面应用脚本。


以下是基于类的：
utils/db/MysqlHelper.class.php 核心类
index.php 测试文件
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











------------------------
Log format for each tools:
------------------------
title: 22-MySQL_data_transfer 
Description:基于PDO的MySQL操作类。

keywords: cache
pros&cons: 
	pros: 几个常用MySQL操作。
	cons:

version: v1.0.0
mod_time:[]
add_time:[10:19 2017/01/01]
auther: Dawn
Email: jimmymall@live.com

Files&Functions:
==================================================
文件结构：
util/db/PDOHelper.class.php 
index2.php 


==================================================
Databases: think_user表
Features:
	Well tested code.
	Secured against SQL injections by using PHP Data Objects(PDO) and Prepared Statements.
	Always returns objects which you can directly use to inform the user.
	Includes proper error handling and information broadcast.

The Framework:
Mainly in SQL database we use the following 4 operations to manage our data (DML Operations)
	C – Create
	R – Read
	U – Update
	D – Delete



