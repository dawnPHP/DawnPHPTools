-- 这是数据库细节。
---- http://blog.csdn.net/renfufei/article/details/48381093
---- catalog  中文翻译为: 目录;
---- category 中文翻译为: 类别;
---- 
---- 
---- 链接：http://www.zhihu.com/question/20459868/answer/18164336
---- item category: 可以用来定义物料的类别,比如文具类,五金类
---- item catalog: 用来描述这个物料具体有哪些性质,比如款号,色彩,尺码等

CREATE TABLE `article` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL,
  `content` text,
  `modi_time` varchar(30) DEFAULT NULL,
  `add_time` varchar(30) DEFAULT NULL,
  `u_id` int(10) DEFAULT NULL,
  `cate_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `u_id` (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

mysql> desc article;
+-----------+-------------+------+-----+---------+----------------+
| Field     | Type        | Null | Key | Default | Extra          |
+-----------+-------------+------+-----+---------+----------------+
| id        | int(10)     | NO   | PRI | NULL    | auto_increment |
| title     | varchar(30) | YES  |     | NULL    |                |
| content   | text        | YES  |     | NULL    |                |
| modi_time | varchar(30) | YES  |     | NULL    |                |
| add_time  | varchar(30) | YES  |     | NULL    |                |
| u_id      | int(10)     | YES  | MUL | NULL    |                |
| cate_id   | int(10)     | YES  |     | NULL    |                |
+-----------+-------------+------+-----+---------+----------------+
insert into article(title,content,add_time,u_id,cate_id) values
	('title of html1','content of html1',1449711107,2,1),
	('title of html2','content of html2',1449712107,2,1),
	('title of html3','content of html3',1449713107,2,1),
	
	('title of css1','content of css1',1449714107,2,2),
	('title of css2','content of css2',1449715107,2,2),
	
	('title of js1','content of js1',1449716107,2,3),
	('title of js2','content of js2',1449717107,2,3),
	
	('title of php1','content of php1',1449718107,2,4);
	


CREATE TABLE `category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `u_id` int(10) DEFAULT NULL,
  `u_rank` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `u_id` (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

mysql> desc category;
+--------+-------------+------+-----+---------+----------------+
| Field  | Type        | Null | Key | Default | Extra          |
+--------+-------------+------+-----+---------+----------------+
| id     | int(10)     | NO   | PRI | NULL    | auto_increment |
| name   | varchar(30) | YES  |     | NULL    |                |
| u_id   | int(10)     | YES  | MUL | NULL    |                |
| u_rank | int(10)     | YES  |     | NULL    |                |
+--------+-------------+------+-----+---------+----------------+

insert into category(name,u_id,u_rank) values('html',2,1),('css',2,2),('javascript',2,3),('php',2,4);

insert into category(name,u_id,u_rank) values('angular',1,1);

CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(15) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `email` varchar(40) NOT NULL DEFAULT '',
  `regdate` int(10) unsigned NOT NULL DEFAULT '0',
  `lastlogin` int(10) unsigned NOT NULL DEFAULT '0',
  `usergroup` int(10) unsigned NOT NULL DEFAULT '0',
  `session_id` char(30) NOT NULL,
  `portrait` varchar(30),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

mysql> desc user;
+------------+------------------+------+-----+---------+----------------+
| Field      | Type             | Null | Key | Default | Extra          |
+------------+------------------+------+-----+---------+----------------+
| id         | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| username   | char(15)         | NO   |     |         |                |
| password   | char(32)         | NO   |     |         |                |
| email      | varchar(40)      | NO   |     |         |                |
| regdate    | int(10) unsigned | NO   |     | 0       |                |
| lastlogin  | int(10) unsigned | NO   |     | 0       |                |
| usergroup  | int(10) unsigned | NO   |     | 0       |                |
| session_id | char(30)         | NO   |     | NULL    |                |
| portrait   | varchar(30)      | YES  |     | NULL    |                |
+------------+------------------+------+-----+---------+----------------+

