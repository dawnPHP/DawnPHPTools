<?php
//1.定义字符集
header("Content-type: text/html; charset=utf-8");
//2.设置时区
date_default_timezone_set('PRC');
//3.引入文件
include('class/MyCurl2.class.php');
//================================================

//设置地址
$url='http://www.west.cn/web/domaintrade/historyoftrade?have=&foreclose=&againforeclose=&type=&min_length=&max_length=&dom_ext=&p_type=&p_topmoney_low=&p_topmoney_top=&overtime_low=2015-12-01&overtime_top=2015-12-10&_csrf=V1R2WUEwYUhlMlsMMkIqGx4ZBTANAgctbyISOwxSUT1jNR0.cEoEPg%3D%3D&page=1&pagesize=50';

//发起请求
$ch=new MyCurl2();
$data= $ch->_request($url,false);

//输出数据
echo $data;

//保存记录
$timeStamp=date('YmdHis',time());
$file_name='data/price'. $timeStamp .'.txt';
file_put_contents($file_name, $data); 