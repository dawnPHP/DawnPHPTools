<?php
Hook::add('plugin2',function($str=""){
    echo '发送邮件的内容<br />'.$str;
});