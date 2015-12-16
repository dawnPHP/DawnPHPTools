<?php
session_start();
if(!isset($_SESSION['uid'])){
	Dawn::died();
}
$uid=$_SESSION['uid'];

define("BathPath","D:/xampp/htdocs/php/DawnPHPTools/php_category/dawnPHP/");
include('dawnPHP/mylib.php');

//获取条目详细数据
$a_id=Dawn::get('a_id','');
if($a_id==''){
	Dawn::died();
}
?>
<html>
<head>
<link rel="stylesheet" href="public/css/category.css" />
<link rel="stylesheet" href="public/css/edit.css" />
<script src='public/js/ajaxObjPrototype.js'></script>
<script src='public/js/dom.js'></script>

</head>

<body>
<div class='header'>
	<h1>详情&gt;条目信息</h1>
		<a href='index.php'><input type='button' class=btn value='&lt;&lt;返回首页' /></a>

</div>
<style>
.main .box{color:#ccc; line-height: 20px; font-size: 12px;
	font-family: "Hiragino Sans GB W3","Hiragino Sans GB",Arial,Helvetica,simsun;}
#title{
	line-height: 38px;
	font-size: 26px;
    font-weight: bold;
}

#detail div{margin:10px;}
#detail .info p{float:left;}
#detail .info{clear:both;}
#detail .control,
#detail .context{border:1px dashed #CCBEBE; overflow:hidden;}

#detail .content{border:1px dashed #eee; overflow:hidden; min-height:100px; padding:5px;}

#detail .flow_right{float:right;}
#detail .flow_left{float:left;}
#detail .box{border-right:1px solid grey;padding:0 5px;}
#detail .last{border-right:0;}
.clear{clear:left;height:10px;}
</style>
<div class=main>
	<div id='detail'>
		<div class=context>
			<p class='flow_right'><a href='index.php'>后一篇</a>&gt;</p>
			<p class='flow_left'>&lt;<a href='index.php'>前一篇</a></p>
		</div>
	
		<div id=title>
			这是标题
		</div>
		<div class=info>
			<p class=box><span id=add_time>2015-10-25 10:10:10</span></p>
			<p class=box>分类:<a id=cate href='index.php'>默认分类</a></p>
			<p class=box id=tags>标签:<a href='index.php'>tag1</a><a href='index.php'>tag2</a></p>
			<p class='box last'>更新于:<span id=modi_time>2015-10-25 10:10:10</span></p>
		</div>
		<p class=clear></p>
		<div class=content>
			这是正文内容
		</div>

		<div class=control>
			<span class='box'>阅读(<span class=''>0</span>)</span>
			<span class='box'>评论(<span class=''>0</span>)</span>
			<span class='box'><a href='index.php'>编辑</a></span>
			<span class='box last'><a href='index.php'>删除</a></span>
		</div>
		<div class='context'>
			<p class='flow_right'><a href='index.php'>后一篇</a>&gt;</p>
			<p class='flow_left'>&lt;<a href='index.php'>前一篇</a></p>
		</div>
		
	</div>
</div>

<script>
var u_id=<?php echo $uid;?>;
var a_id=<?php echo $a_id;?>;

window.onload=function(){
	var oDetail=$('detail');
	var aContext=oDetail.getElementsByClassName('context');
		aContext[0].innerHTML='';
	aContext[1].innerHTML='';
	
	//页面初始化 拉去当前和其后页面信息
	var ajax=new Ajax();
	var url='cateAction.php?a=detail&u_id='+u_id+'&a_id='+a_id;
	ajax.get(url,function(str){
		//console.log(str);
		objs=eval("("+str+")");
		insertDetailPage(objs,oDetail);
	});
	
	
	//处理ajax
	function insertDetailPage(objs){
		var main=objs[0],uDom=objs[1],dDom=objs[2];
		
		//1.处理main数据
		//Object {id: "2", title: "title of html2", content: "content of html2", modi_time: null, add_time: "2015-12-10 09:48:27"…}
		
		$('title').innerHTML=main['title'];//标题
		$('add_time').innerHTML=main['add_time'];//创建时间
		
		$('cate').innerHTML=main['cate_id'];//分类todo 获得分类名
		$('cate').setAttribute('href','index.php?cate_id='+u_id);//修改url
		
		//标签没有 todo
		$('tags').innerHTML="标签：无";//标签
		
		//更新日期
		$('modi_time').innerHTML=main['add_time'];
		if(main['modi_time']!=null){
			$('modi_time').innerHTML=main['modi_time'];
		}
		
		
		//2.处理上下文菜单
		//Object {id: "1", title: "title of html1", status: "pre"}
		//Object {id: "4", title: "title of css1", status: "next"}
		var aCtx=getContextDom(uDom,dDom);//获取元素
		//顶部上下文菜单
		aContext[0].appendChild(aCtx[0]);
		aContext[0].appendChild(aCtx[1]);
		//底部上下文菜单
		aContext[1].innerHTML=aContext[0].innerHTML;
	}
	
	
	
}
</script>

<?php include('footer.php');?>