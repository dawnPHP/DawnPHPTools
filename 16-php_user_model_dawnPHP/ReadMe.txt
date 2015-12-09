------------------------
Log format for each tools:
------------------------
title: 16-php_user_model_dawnPHP（我的OOP框架、ORM模型）
Description:我的框架。

keywords:用户模型、OOP、ORM
pros&cons: 
	pros:使用了自动加载类。建立了框架初步模型。
	cons:没有实现MVC。因为还不熟悉。

version: v1.0.0
time:[15:59 2015-12-09]
auther: Dawn
Email: jimmymall@live.com

Files&Functions:
==================================================
|- dawnPHP	//我的OOP框架
	|- class	类文件
		|- User.class.php  【经典】用户类。
				对象关系映射（Object Relational Mapping，简称ORM）
	|- conn.php	数据库连接
	|- mylib.php	框架入口
	|- function.php //【无关】验证码 随机数函数
	|- yanzhengma.php //【无关】验证码 图片生成函数
|- newUser.php	例子：新建用户
|- changePsw.php 例子：改变密码
|- public	公开文件

|- ReadMe.txt
|- sql.sql	sql语句
|- seeSession.php  //【无关】看验证码session
|- devLog.txt	开发日记：ORM模型。

==================================================
Databases: WROX_PENDING(没用到), WROX_USER

DROP TABLE IF EXISTS WROX_PENDING;
DROP TABLE IF EXISTS WROX_USER;

CREATE TABLE WROX_USER (
	USER_ID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT, 
	USERNAME VARCHAR(20) NOT NULL, 
	PASSWORD CHAR(40) NOT NULL, 
	EMAIL_ADDR VARCHAR(100) NOT NULL, 
	IS_ACTIVE TINYINT(1) DEFAULT 0, 
	PRIMARY KEY (USER_ID) 
)ENGINE=MyISAM DEFAULT CHARACTER SET utf8;

CREATE TABLE WROX_PENDING (
	USER_ID INTEGER UNSIGNED PRIMARY KEY NOT NULL, 
	TOKEN CHAR(10) NOT NULL, 
	CREATED_DATE TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
	FOREIGN KEY (USER_ID) 
	REFERENCES WROX_USER(USER_ID) 
)ENGINE=MyISAM DEFAULT CHARACTER SET utf8;