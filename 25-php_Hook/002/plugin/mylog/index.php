<?php
Hook::add('mylog',function($str=""){
    echo '记录日志的内容<br />'.$str;
});