<?php
Hook::add('plugin1',function($str=""){
    echo '发送短信的内容<br />'.$str;
});