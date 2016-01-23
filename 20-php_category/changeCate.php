<?php
session_start();
if(!isset($_SESSION['user']['uid'])){
	die('Invalid visit.');
}
$user=$_SESSION['user'];
$uid=$_SESSION['user']['uid'];

include('dawnPHP/mylib.php');


include 'View/header.php';
include 'View/edit/changeCate.html';
include('View/footer.php');
?>