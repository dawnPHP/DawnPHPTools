<?php

//»ñÈ¡ACC_TOKEN

include '../MyDebug.class.php';
include 'Secret.class.php';
include 'ACC_TOKEN.class.php';

$ACC_TOKEN=ACC_TOKEN::get();
print_r( $ACC_TOKEN );
