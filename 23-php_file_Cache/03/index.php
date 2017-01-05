<?php 

include "Cache3.class.php";

$cache=new Cache();
$cache->page_init();//开始执行缓存


echo "本文件有更新，才更新缓存0102<hr>";
echo date("Y-m-d H:i:s",time());

$cache->page_cache(10);//检测是否使用缓存