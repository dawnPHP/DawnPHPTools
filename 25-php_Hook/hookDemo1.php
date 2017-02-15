<?php 
// 引入Hook类
include('lib/Hook.class.php');
include('lib/function.php');


//1.（提前准备好钉子）注册函数
Hook::register('app_init',"fn1");//可以注册一个
Hook::register('app_init',"fn2");//可以再注册一个
Hook::register('app_init',array("mylog","fn2"));//可以一起注册
Hook::register('app_over',array("fn1","fn3"));//可以一起注册
//是否设置为每个函数只允许注册一次呢？



//2. （等待汽车过来）监听一个钩子，传入参数（可选）
//Hook::listen('app_init');
Hook::listen('app_init',array('some title'));


echo "<hr>我的逻辑代码<hr>";


Hook::listen('app_end');//没有注册事件，这个钩子就不会执行
Hook::listen("app_over");

