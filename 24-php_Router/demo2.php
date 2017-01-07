<?php
//demo2.基本功能，1.地址分发，2.url生成U('User/index',array('id'=>12))

include "classes/Router.class.php";

echo 'url演示： ';
Router::make("User/index/id/5");//当有2个make时，会互相影响。主要是因为Router是一个静态方法。

Router::init();
?>


<hr>
<a href="<?=Router::make("Article/index/id/10086",array('name'=>'albb'))?>">articleDemo</a>
<a href="<?=Router::make("Article/show/id/10086")?>">showDemo</a>
<a href="<?=Router::make("Article")?>">会因为Get不到id而报错</a>


