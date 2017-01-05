<?php 

include "Cache.class2.php";

$cache=new Cache();
$cache->page_init();//开始执行缓存


echo "10s缓存时间<hr>";
echo date("Y-m-d H:i:s",time());

$cache->page_cache(10);//检测是否使用缓存