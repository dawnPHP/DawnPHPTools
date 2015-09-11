<?php
 include("function.php");
?>
<style>
body{margin:0; padding:0;font-family:"微软雅黑";}

  /* Default links */
a:link, a:visited {
	text-decoration : underline;
	color : #900b09;
	background : transparent; 
}

a:hover {
	text-decoration : underline;
	color: #ff0000;
	background : transparent; 
}

a:active {
	text-decoration : underline;
	color : #ff0000;
	background : transparent;  
}


ul{width:800px; list-style:none; margin:0px;padding:0; border:#ff5f3e 1px solid; }
ul li{  list-style:none;border-top: 1px solid #f8f8f8;margin:2px;   padding: 9px 0; text-align:right;}
ul li:hover{ background:#ff5f3e;color:#fff;}
ul li a{  color: #606566;  font-weight: 700;
  font-size: 13px; 
  text-decoration: none;
  padding: 6px 12px;
 }
h1{background:#529BEB;color:#fff; margin:0;width:300px;padding:20px; border-radius:15px;}
.red{color:red;}
.light{color:#ddd;}



.btn{
	padding: 6px 12px;
  margin-bottom: 0;
  font-size: 14px;
  font-weight: 400;
  line-height: 1.42857143;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  cursor: pointer;

  user-select: none;

  border: 1px solid transparent;
  border-radius: 4px;
  
  color: #333;
  background-color: #fff;
  border-color: #ccc;
}
</style>
<?php 
	header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
?>
<center>
<h1>WJLi BBS (v0.02)</h1>
<p class=light>Composer: fireCloudPHP AT 163 dot com</p>

<a class=btn href="index.php" target="_blank">浏览帖子</a> | 
<a class=btn href="add.php" target="_blank">发表帖子</a>
<hr>
</center>