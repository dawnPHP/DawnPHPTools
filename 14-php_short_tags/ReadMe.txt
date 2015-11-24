------------------------
Log format for each tools:
------------------------
title: 基于标签的分类系统
Description:给博客、图片加上标签，并按照标签进行分类和显示

keywords:标签、js特效、仿163博客底部标签
pros&cons: 
	pros:很多js特效。详情看开发日志: devLog.txt;
	
	cons:没有一个类。不好做成类。怎么办？

version: v1.0.0
time:[11:42 2015-11-24]
auther: Dawn
Email: jimmymall@live.com

Files&Functions:
==================================================
  845 index.php	首页：显示，按照标签分类
7,600 new.php	新建条目编号，及标签
8,282 edit.php	编辑标签
2,910 action.php	执行操作
      common	通用文件：数据库连接、函数库
		|-conn.php
		|-function.php
  607 header.php	通用文件头：设置一些常用配制：字符编码、时区
      images	图片
1,968 tags.css	样式表
      dustbin	垃圾箱 不备份的文件
==================================================
Databases: 标签表、文章标签关联表


--清空表
--truncate table table_name;

--建立tags表
create table tags(
	id int(10) not null auto_increment primary key,
	u_id int(10),
	tag varchar(20)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--建立关联表article_tags表
create table article_tags(
	a_id int(10) not null,
	t_id int(10) not null,
	primary key(a_id,t_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;