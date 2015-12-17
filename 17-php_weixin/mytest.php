<?php
include('DawnPHP/class/MyDebug.class.php');

MyDebug::f($_POST,'POST.TXT');

$data = file_get_contents("php://input");

MyDebug::f($data,'post2.txt');
echo 'done' . time();