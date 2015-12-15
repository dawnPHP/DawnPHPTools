<?php
include '../MyDebug.class.php';
include 'Secret.class.php';
include 'ACC_TOKEN.class.php';

$acc=ACC_TOKEN::get();
print_r( $acc );
