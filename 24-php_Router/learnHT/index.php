<?php 
include "../function.php";
echo 'this is index.php<hr>';

	echo '你的Action是：' . $_GET['action'].'<br/>';
	//echo '你的Action是：' . $_GET['m'].'<br/>';
	echo '你的ID是：' . $_GET['id'];
debug($_GET);
debug($_SERVER['PHP_SELF']);
	
debug($_SERVER);
/**
测试：
http://localhost/DawnPHPTools/24-php_Router/learnHT/item-4.html 
你的Action是：item
你的ID是：4



*/