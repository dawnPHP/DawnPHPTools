<?php

//记录日志的函数
function mylog($str){
	echo $str;
	file_put_contents('log.txt',$str,true);
}


//排错函数
function debug($s,$isDetal=false,$isDie=false){
	echo '<hr><pre>';
	$isDetal?var_dump($s):print_r($s);
	echo '</pre><hr>';
	if($isDie){
		die();
	}
}


