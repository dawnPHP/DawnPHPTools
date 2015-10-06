

v1.0.2
用ajax改写 添加 评论。在动态添加dom时耗时较多：
1.为了使用ajax post，重新写了ajax的prototype形式。
2.熟悉dom的添加操作。
	小心：添加第一条评论时可能会失败。
3.已经修改#comment的范围，仅仅是评论区域。
4.抽离了css和js到一个文件中；
  抽离了时区设置、编码、数据库连接到一个入口php文件。


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
		
		5.dom的添加和三个函数密切相关：
createElement(tagName), setAttribute(attr,value), pId.appendChild(sonId)
		删除和1个函数密切相关removeChild()
	缺点：
		1.帖子楼层怎么显示？删除一个之后楼层不能变。难道再建一个回复评论的表？
		2.最终修改成完全的php返回json，一切排版给js？

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
评论表: comment
id——自动生成，评论的ID
aid——文章的id
pid——父评论的id
comment——品论内容

uid——评论人的用户编号

nickName--评论人的昵称
email--评论人的email
comment_time--评论时间

--
-- 表的结构 `comment`
--
CREATE TABLE IF NOT EXISTS `comment`(
	id int(10) auto_increment not null primary key,
	aid int(10),
	pid int(10) default 0,
	comment text,
	uid int(10),
	nickName varchar(30),
	email varchar(30),
	comment_time varchar(30)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--添加索引
ALTER TABLE comment ADD INDEX aid (aid);  
ALTER TABLE comment ADD INDEX uid (uid);  

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
8 rows in set (0.01 sec)
