<html>
<head>
<link rel="stylesheet" href="public/css/category.css" />
<link rel="stylesheet" href="public/css/edit.css" />
<script src='public/js/ajaxObjPrototype.js'></script>
<script src='public/js/dom.js'></script>
</head>

<body>
<div class='header'>
	<div class=wrapper>
	<span class=title>进程管理系统v1.0</span>
	<span class=menu>
	<a href='devLog.txt' target='_blank' title='整个项目的详细记录'>开发日志</a> | 
	<a href='http://tieba.baidu.com/f?kw=php&fr=wwwt' target='_blank' title='问题咨询'>php吧</a> | 
	<a href='http://www.itbull.cn/' target='_blank' title='参考itBull'>美工</a> |
<?php if($user){ 
	echo '您好，[<a href="ucenter.php">' . $_SESSION['user']['username'] . '</a> ('. $user_group[$_SESSION['user']['usergroup']] .')]';
?>
	| <a href='cateAction.php?a=logout' title='点击退出系统'>退出</a>
<?php }else{?>
	<a href='index.php'>登陆</a>
<?php }?>
	</span>
	</div>

</div>