<?php
//获取函数递归调用的返回值
function fn($num,$total=0){
	$total += $num;

	if($total<100){
		return fn( ++$num, $total);//重点！！
		echo '本次：num = '.$num.', total = '.$total.'<hr>';//这一行不再执行
	}else{
		echo "run this line.{$total}<br>";//这一行执行了
		return $total; //为什么返回不出去呢？ 第7行加入return后就可以返回了。
	}
}
echo '<pre>';
$r=fn(10);
echo '最后返回total:<hr>';
var_dump($r);

//第7行加入return后就可以返回递归值了。