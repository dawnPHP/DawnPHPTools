<?php 
//钩子函数库(要求：0或1个参数，参数只能是数组)
//可以没有参数
function fn1(){
	echo '<hr>我是钩子1：记录用户的IP<hr>';
}

//也可以有参数，但是只能是数组
function fn2($arr=array()){
	echo '<hr>我是钩子2：可以传入参数';
	echo "<b style='color:red'>		".$arr[0]."</b><hr>";
}

//如果有参数但是不传入，则需要设置默认值
function fn3($arr=array()){
	echo '<hr>我是钩子3：可以传入参数，如果不传入呢';
	if(count($arr)>0){
		echo "<b style='color:red'>		".$arr[0]."</b><hr>";		
	}else{
		echo "..没有传入参数"."<hr>";
	}
}

//信息写入文件
function mylog($s){
	file_put_contents("mylog.txt",$s,FILE_APPEND );
}