	
http://blog.csdn.net/renfufei/article/details/48381093
catalog  中文翻译为: 目录;
category 中文翻译为: 类别;


链接：http://www.zhihu.com/question/20459868/answer/18164336
item category: 可以用来定义物料的类别,比如文具类,五金类
item catalog: 用来描述这个物料具体有哪些性质,比如款号,色彩,尺码等

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