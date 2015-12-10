<?php
define("BathPath","D:/xampp/htdocs/php/DawnPHPTools/php_category/dawnPHP/");
include('dawnPHP/mylib.php');

/*
1.从session中获取一个u_id，否则提示登陆。
2.如果该u_id是管理员或本文作者，则显示，否则不显示。
3.

*/
?>
<html>
<head>
<link rel="stylesheet" href="public/css/category.css" />
<script src='public/js/ajaxObjPrototype.js'></script>
</head>

<body>
<div class='header'>
	<h1>(php分类管理系统)php进度跟踪管理系统v1.0</h1>
	<pre>
	<a href='devLog.txt' target='_blank'>开发日志</a> | <a href='http://tieba.baidu.com/f?kw=php&fr=wwwt' target='_blank'>php吧</a>
	分类的增删改查。
	左边分类，右边是条目。默认不分页。
	</pre>
</div>

<div class=main>
	<!-- 左侧开始 -->
	<div class=left>
		<div class=btn>
			<input type='button' value='新建条目'>
			<p><a href='javascript:void(0);'>管理分类</a> | 
			<a href='javascript:void(0);'>管理条目</a></p>
		</div>
		<span>分类</span>
		<ul>
			<!--li class=current><a href='index.php?cate_id=0'>所有分类(100)</a></li>
			<li><a href='index.php?cate_id=1'>分类1(10)</a></li-->
		</ul>
	</div>

	<!-- 右侧开始 -->
	<div class=right>
		<span class='catalog'>所有类别</span>
		
		<!--div class='item'>
			<a class='title' href='detail.php?p_id=1' target="_blank">this is the title of item1</a>
			<p>
				2015-11-29 11:08
				<span><a href='action.php?a=del&p_id=1' target="_blank">删除</a></span>
				<span><a href='edit.php?p_id=1' target="_blank">修改</a></span>
			</p>
			<div class='status'>
				<div class='bar c1'></div>
			</div>
		</div-->
	</div>
</div>



<script>
<?php 
$cur=Dawn::get('cate_id','0');
echo 'var cate_id=',$cur,";\n";
?>
window.onload=function(){
	var uid=<?php echo (new Dawn())->get('uid',-1);?>;
	//请求目录
	var url='cateAction.php?a=category&uid='+uid;
	var ajax=new Ajax();
	ajax.get(url,function(s){
		var objs=eval("("+s+")");
		showCate(objs);
	});
	
	//请求文章
	var url2='cateAction.php?a=article&uid='+uid+'&cate_id='+cate_id;
	var ajax2=new Ajax();
	ajax2.get(url2,function(s){
		var objs=eval("("+s+")");
		showArticle(objs);
	});
	
	//根据jsons插入文章
	function showArticle(objs){
		//1.对objs循环
		for(var i=0;i<objs.length;i++){
			var obj=objs[i];
			insertArticleDom(obj);
		}
	}
	//根据obj插入文章dom
	function insertArticleDom(obj){
		//2.创建目录dom
		var oA=document.createElement('a');
		oA.setAttribute('class','title');
		oA.setAttribute('href','detail.php?a_id='+obj['id']);
		oA.setAttribute('target','_blank');
		oA.innerHTML=obj['title'];
		
		oSpan1=document.createElement('span');
		oA1=document.createElement('a');
		oA1.setAttribute('href','cateAction.php?a=del&a_id='+obj['id']);
		oA1.setAttribute('target','_blank');
		oA1.innerHTML='删除';
		oSpan1.appendChild(oA1);
		
		oSpan2=document.createElement('span');
		oA2=document.createElement('a');
		oA2.setAttribute('href','edit.php?a_id='+obj['id']);
		oA2.setAttribute('target','_blank');
		oA2.innerHTML='修改';
		oSpan2.appendChild(oA2);
		
		oP=document.createElement('p');
		oP.innerHTML=obj['add_time'];
		oP.appendChild(oSpan1);
		oP.appendChild(oSpan2);
		
		oDivBar=document.createElement('div');
		oDivBar.setAttribute('class','bar c1');
		
		oDivStatus=document.createElement('div');
		oDivStatus.setAttribute('class','status');
		oDivStatus.appendChild(oDivBar);
		
		oDiv=document.createElement('div');
		oDiv.setAttribute('class','item');
		oDiv.appendChild(oA);
		oDiv.appendChild(oP);
		oDiv.appendChild(oDivStatus);
		
		//3.插入文档结构中
		var oRight=document.getElementsByClassName('right')[0];
		oRight.appendChild(oDiv);
	
	}
	
	
	//根据jsons插入目录
	function showCate(objs){
		//所有分类
		var count=0;
		for(var i=0;i<objs.length;i++){
			count += parseInt( objs[i]['count'] );
		}
		var all={id: "0", name: "所有分类", u_id: "2", u_rank: "0",'count':count};
		insertCateDom(all,cate_id<=0?true:false);
		//1.对objs循环
		for(var i=0;i<objs.length;i++){
			var obj=objs[i];
			//Object {id: "1", name: "html", u_id: "2", u_rank: "1"}
			if(cate_id==obj['id']){
				insertCateDom(obj,true);
			}else{
				insertCateDom(obj);
			}
		}
	}
	
	//根据obj创建dom并插入到ul中
	function insertCateDom(obj,isCurrent){
		var isCurrent=isCurrent||false;
		//2.创建目录dom
		var oA=document.createElement('a');
		oA.setAttribute('href','index.php?cate_id='+obj['id']);
		oA.innerHTML=obj['name']+'('+obj['count']+')';
		var oLi=document.createElement('li');
		if(isCurrent){
			oLi.setAttribute('class','current');
		}
		oLi.appendChild(oA);
		//3.插入文档结构中
		var oLeft=document.getElementsByClassName('left')[0];
		var oUl=oLeft.getElementsByTagName('ul')[0];
		oUl.appendChild(oLi);
	}
}
</script>

<div class=footer>
	&copy;2015 All rights reserved;
</div>
</body>
</html>