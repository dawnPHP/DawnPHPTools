<?php
include("menu.php");

//获得操作方法
if(!isset($_GET['a'])){
	die("非法操作!点击<a href='index.php'>浏览帖子</a>");
}
$action=$_GET['a'];

switch($action){
	case "add":
		echo "添加操作";
		//获得数据
		$name=$_POST['name'];
		$title=$_POST['title'];
		$text=$_POST['text'];
		$postTime=time();//记录发帖时间
		
		$tid=getMaxTid(DEMOFILE)+1;
		/*
		$lines=getLines(DEMOFILE);//使用自定义函数，获得行数
		//使用自定义函数，读取最后一个记录的tid
		$lastId=getLastLineId(DEMOFILE);
		$maxTid=getMaxTid(DEMOFILE);
		
		die( "总行数：{$lines}, 最后一个的ID:{$lastId}, 最大的tid为{$maxTid}, console.log");
		*/
		
		
		$tiezi= 
			"帖子ID：".$tid."<br>".
			"发帖人：".$name."<br>".
			"标题：".$title."<br>".
			"时间：".$postTime."<hr>".
			"内容：".$text."<hr>";
		echo $tiezi;

		//打开文件，追加方式添加
		$fh=fopen(DEMOFILE,"a");
		//写入文件
		fwrite($fh,"{$tid},{$name},{$title},{$postTime},{$text}\n");
		//关闭文件
		fclose($fh);

		echo "OK";
		header("location:index.php");
		break;
		
	case "del":
		echo "删除操作";
		$tid=$_GET['tid'];
		echo $tid;
		
		deleteByTid(DEMOFILE,$tid);//自定义函数，根据tid删除帖子
		
		echo "OK";
		header("location:index.php");
		break;
	case "update":
		echo "更新操作";//TODO:怎么更新文件
		
		//获得数据
		$tid=$_GET['tid'];
		$name=$_POST['name'];
		$title=$_POST['title'];
		$text=$_POST['text'];
		$postTime=time();//记录发帖时间
		$newLine="{$tid},{$name},{$title},{$postTime},{$text}\n";//连接新行,最后不用加换行\n?可能textarea的bug
		
		//获得要修改的行
		$tid=$_GET["tid"];
		//使用自定义函数，有tid获得数组：文件前半部分、待修改行、文件后半部分；
		$items=getArrayByTid(DEMOFILE,$tid);
		
		//依次写入文件
		$fh=fopen(DEMOFILE,"w");
		fwrite($fh,$items["up"]);
		fwrite($fh,$newLine);
		fwrite($fh,$items["down"]);
		fclose($fh);
		
		echo "OK";
		header("location:index.php");
		break;
}
?>