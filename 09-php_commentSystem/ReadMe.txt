
------------------------
Log format for each tools:
------------------------
title: PHP评论系统(多表系统)
version: v2.0.0
time:[21:48 2015-10-10]
auther: Dawn
Email: jimmymall@live.com
Description:适用于博客文章、照片等的评论
keywords:评论
pros&cons: 还没有添加注册用户系统，后续还需要改版
	重要思路：
		1.共2个表：评论表comment和回复表reply；
			
		表格设计上加父评论id(pid)，一级父评论pid=0，二级回复pid为真实值；
		2.所有评论递归循环输出；
		3.使用php输出各评论的dom的id给js，使用js给条目添加删除和回复事件；
		4.一旦删除某条评论，则级联删除其子评论，及子评论的评论...
		
		5.dom的添加和三个函数密切相关：
createElement(tagName), setAttribute(attr,value), pId.appendChild(sonId)
		删除和1个函数密切相关removeChild()
	缺点：
		1.帖子楼层怎么显示？删除一个之后楼层不能变。难道再建一个回复评论的表？
		2.最终修改成完全的php返回json，一切排版给js？

Files&Functions:
==================================================
---共4个文件：
 |- comment.php	显示评论的演示 
 |- conn.php	连接数据库
 |- action.php	执行增删的文件（没有改）
 |- function.php	一些自定义函数
 |
 |-diguiDemo.php 遇到一个php函数递归return的bug。附有解决方案。
==================================================
Databases: 

分别建立
评论表comment(id, article_id, user_id, content, add_time, story)，
回复表reply(id, comment_id, parent_id, user_id, content, add_time);


其中评论表是一级评论，select * from comment where article_id='1' ;
story表示楼层数，每次插入前先查询最大楼层数，加1再插入；




其中回复表的comment_id指向comment表的id。
reply表的parent_id指向该条目评论的条目的id，如果回复一级评论，则pid=0，否则为reply表中某一个id。


--
-- 表的结构 `博客系统`
--
----------------
用户表：user
id--用户id
usr--用户名
psw--密码
email--用户email
reg_time--注册时间
portrait--头像

CREATE TABLE IF NOT EXISTS `user`(
	id int(10) auto_increment not null primary key,
	usr varchar(30),
	psw varchar(30),
	email varchar(30),
	reg_time varchar(30),
	portrait varchar(30)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

 

----------------
文章表: article
id--文章id
title--标题
content--内容
modi_time--修改时间
add_time--新建时间
u_id--用户id
cate_id--目录id

CREATE TABLE IF NOT EXISTS `article`(
	id int(10) auto_increment not null primary key,
	title varchar(30),
	content text,
	modi_time varchar(30),
	add_time varchar(30),
	u_id int(10),
	cate_id int(10)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
--添加索引
ALTER TABLE article ADD INDEX u_id (u_id); 
----------------
评论表: comment
id——自动生成，评论的ID
a_id——文章的id
comment--内容
add_time--评论时间
u_id--评论人的用户编号
story--楼层号(按照a_id过滤后排序)

CREATE TABLE IF NOT EXISTS `comment`(
	id int(10) auto_increment not null primary key,
	a_id int(10),
	comment text,
	add_time varchar(30),
	u_id int(10),
	story int(10)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
--添加索引
ALTER TABLE comment ADD INDEX a_id (a_id); 
ALTER TABLE comment ADD INDEX u_id (u_id); 
----------------
回复表: reply
id——自动生成，评论的ID
p_id——父评论的id
reply——内容
add_time--评论时间
u_id——评论人的用户编号
reply_to--被回复用户的u_id

CREATE TABLE IF NOT EXISTS `reply`(
	id int(10) auto_increment not null primary key,
	p_id int(10),
	reply text,
	add_time varchar(30),
	u_id int(10),
	reply_to int(10)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
--添加索引
ALTER TABLE reply ADD INDEX p_id (p_id); 
ALTER TABLE reply ADD INDEX u_id (u_id); 
ALTER TABLE reply ADD INDEX reply_to (reply_to); 