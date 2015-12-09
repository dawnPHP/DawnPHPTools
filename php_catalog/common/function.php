<?php
include 'common/conn.php';
	
//排错函数
function debug($arr,$isDie=true){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
	
	if($isDie)die();
}