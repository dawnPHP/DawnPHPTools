<?php 

$post_info = print_r($_POST,true);
include('myLog.class.php');
$log=new myLog();

$log->log($post_info);
