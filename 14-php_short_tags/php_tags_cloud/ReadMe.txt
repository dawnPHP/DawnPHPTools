php标签云制作过程(数据表的结构和查询)
http://www.wzsky.net/html/article/php/php2/125497.html

标签云是用来做相关文章集合的功能，我们可以把很多文章都集合到些，很多做seo优化的朋友都会给网站做一些seo标签了，下面我们来看一个完整的php标签云制作过程。 

1.数据表的结构：
创建建两张数据表，结构如下：
标签tags表：
	id int(11) not null auto_increment primary key,
	u_id int(11)
	tag varchar(20),
文章article表：
	NG:其中表中的tag字段，以tag表的id字段+","+tag表的id字段，
	只有文章信息。
	
关联表：article_tags:
	a_id
	t_id

	
	========================
php实现标签云的展示：
http://codeigniter.org.cn/forums/thread-18335-1-1.html









