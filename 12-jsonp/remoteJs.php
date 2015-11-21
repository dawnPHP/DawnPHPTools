<?php
//接受请求
$callback=$_GET['callback'];
$code=$_GET['code'];

//查询并获取数据(可以通过数据库查询，这里简化)
switch($code){
	case 'CA1998':
		$price=1200;
		$tickets=20;
		break;
	case 'CA1999':
		$price=4500;
		$tickets=2;
		break;
}

//拼接数据
$data="{
	'code':'" . $code . "',
	'price':$price,
	'tickets':$tickets
}";
		
//返回结果
echo $callback . '('. $data .')';
?>