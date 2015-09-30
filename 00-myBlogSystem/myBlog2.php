<?php
/**
 * version:1.1
 * 设置输出utf8字符集
 *
 * 核心功能：
 *  -- 连接mysql数据库
 *  -- 增删改查
 * 
 * hereDoc构建sql语句
 * 
 * 设置时区、获取时间、显示时间
 * 分页显示 http://www.jb51.net/article/19711.htm
 * 
 * 
 * version:1.2
 * 增加文章浏览次数 todo 浏览摘要不应该计数
 *
 * todo
 * 分类/按日期汇总日志/标签/弹出框ajax操作/阅读计数器/评论/图片上传
*/
//输出编码表头
header("Content-Type: text/html; charset=UTF-8");
//解决编码问题：http://www.ruanyifeng.com/notes/2007/10/php_utf8.html


/**
引用
*/
include('common/conn.php');




/**
 * config
 * 
 */
//是否继续插入数据
$insertion_on=false;//是否允许插入数据
$show_short_on=false;//是否显示摘要.这里设置无效。








//删除表
//mysql_query('drop table temp_post;') or die(mysql_error());


//--------新建表--------------

//如果不存在则建立表格
$sql = <<< "HereDocs"
CREATE TABLE IF NOT EXISTS `temp_post`(
  `id` int(4) NOT NULL auto_increment,
  `title` varchar(200) default NULL,
  `content` text,
  `time` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
)DEFAULT CHARSET=utf8;
HereDocs;
//执行该sql语句
mysql_query($sql) or die(mysql_error());





//--------插入数据--------------

//设置时区
date_default_timezone_set('PRC');
//获取时间
$time=time();

//如果允许插入新数据，则插入新数据
if($insertion_on){
	//$sql="insert into temp_post(title,content,time) values('html5','is comming',{$time})";
	$sql="insert into temp_post(title,content,time) values('css3','is comming since last year',{$time}),('js6','js6 is comming soon',{$time});";

	//$sql="insert into temp_post(title,content,time) values('html5','抄的沸沸扬扬的html5 is comming',{$time}), ('css3','光怪陆离的css3 is comming since last year',{$time}),('js6','人们普遍不看好的js6 is comming soon',{$time});";
	//$sql="insert into temp_post(title,content,time) values('web2.0','web+时代的企业该怎么做才不会被淘汰',{$time}), ('OOP在PHP中的重要性','OOP使PHP变的成熟，可以胜任任何大型项目',{$time}),('读数，该读多少？','可能不需要过多，就2~3米吧',{$time});";


	//update语句用来修改内容
	$new_content='<p>很多人觉得自己技术进步很慢，学习效率低，我觉得一个重要原因是看的书少了。多少是多呢？起码得看3、4、5、6米吧。给个具体的数量，那就100本书吧。很多人知识结构不好而且不系统，因为在特定领域有一个足够量的知识量+足够良好的知识结构，系统化以后就足以应对大量未曾遇到过的问题。</p>
<p>奉劝自学者：构建特定领域的知识结构体系的路径中再也没有比学习该专业的专业课程更好的了。如果我的知识结构体系足以囊括面试官的大部分甚至吞并他的知识结构体系的话，读到他言语中的一个词我们就已经知道他要表达什么，我们可以让他坐“上位”毕竟他是面试官，但是在知识结构体系以及心理上我们就居高临下。</p>
<p>所以，阅读一百本计算机著作吧，少年！</p>';
	$new_content = mysql_real_escape_string($new_content);
	//$sql='update temp_post set content ="'.$new_content .'" where id=9';


	//执行该sql语句
	$status=mysql_query($sql) or die(mysql_error());

	//echo '<pre>';
	//看是否插入成功
	if($status){
		echo '<b>插入了';
		echo mysql_affected_rows();//看影响了多少行
		echo '行</b><hr>';
	}else{
		echo '插入失败！';
		die();
	}
}







//--------显示数据--------------
//获取输入参数，构建sql语句
if(isset($_GET['id'])){
	$show_id=mysql_real_escape_string($_GET['id']);
	$sql="select * from temp_post where id={$show_id}";
	$show_short_on=false;
}else{
	$sql="select * from temp_post";
	$show_short_on=true;
}


//分页显示的设置部分 核心代码
$item_per_page=4;// 每页显示条目数
//获取总页码数
$pageRows=mysql_query('select count(id) as TPage from temp_post;') or die('查询总条目数: '.mysql_error());
$pageRow=mysql_fetch_assoc($pageRows);
$total_item=$pageRow['TPage']; //总条目数
$total_pages=ceil( $total_item/$item_per_page)-1;
//echo 'totle_pages:'.$total_pages;
//获取当前页码数据,构建sql语句
if(isset($_GET['p'])){
	$current_page=0+($_GET['p']);
}else{
	$current_page=0;
}
//页码必须在0-最大之间
if($current_page>$total_pages) $current_page=$total_pages;
if($current_page<0) $current_page=0;
//增加页码限制
$sql .= ' limit '.($current_page*$item_per_page).', '.$item_per_page;
//die($sql);
//后续有翻页按钮


//执行该sql语句
$rows=mysql_query($sql) or die(mysql_error());

//获取当前url
$current_url=$_SERVER['PHP_SELF'];

//显示结果
echo '<pre>';
echo '<h1>我的博客(front end)</h1><hr>';
while($row=mysql_fetch_assoc($rows)){
	$id=$row['id'];
	$title=$row['title'];
	$content=$row['content'];

	//仅仅显示20字的摘要
	if($show_short_on){
		$content2=mb_substr($content, 0,23,'utf8') ;//mb_substr( $str, $start, $length, $encoding ) 
		if(mb_strlen($content)>mb_strlen($content2)){
			$content =$content2 . '...';
		}else{
			$content=$content2;
		}		
	}

	$time=date( 'Y-m-d H:i:s',$row['time']);

	echo '<h2><a target="_blank" href="'.$current_url.'?id='.$id.'">'.$title . '</a></h2>';
	echo '[帖子ID='.$id.']发表于' . $time . '<br>';
	echo '<p>'.$content.'</p>';
	
	//计数器todo:浏览目录也计数，是bug
	echo '阅读(<script language="javascript" src="common/counter.php?aid=blog'.$id.'&c=blog"></script>) |';
	echo '<hr />';
}





//翻页按钮
if($show_short_on){
	echo '<p>';
	echo '<a href="'.$current_url.'?p='.($current_page>0? ($current_page-1):0).'">&lt;</a> | ';
	echo $current_page;
	echo ' | <a href="'.$current_url.'?p='.($current_page<$total_pages? ($current_page+1):$total_pages).'">&gt;</a>';

	echo '</p>';
}else{
	echo '<p>';
	echo '<a href="'.$current_url.'">返回列表</a>';
	echo '</p>';
}




//关闭资源
//mysql_close($conn);
?>