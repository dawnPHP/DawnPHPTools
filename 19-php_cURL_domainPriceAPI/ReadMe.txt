------------------------
Log format for each tools:
------------------------
title: 19-php_cURL_domainPriceAPI(基于cURL采集数据)
Description:基于cURL采集数据

keywords: cURL
pros&cons: 
	pros:使用了cURL。很好的欺骗服务器的工具。
		实现了本地缓存json文件。
	cons:

version: v1.0.1
mod_time:[09:06 2015-12-28]
add_time:[08:11 2015-12-28]
auther: Dawn
Email: jimmymall@live.com

Files&Functions:
==================================================
修补完善后后文件结构：

|-iframe.html	原始网页文件，同时也是示例，请打开控制台观看
|-ajax.js	自定义的ajax函数第二版：兼容post json数据。
|-getData.php	ajax请求该文件，该文件请求类文件。
|-class文件夹
	|-MyCurl2.class.php curl的封装。
	|-DomainPrice.class.php 获取域名数据的类，可以设定缓存时间。
		该文件比对当前缓存时间，不超时就直接返回，
		超时就重新获得第三方数据，同时缓存到本地。备份数据到data文件夹
|-data	数据文件。
|-CurrentPriceData.txt 当前数据，每隔一段时间更新一次。

==================================================
Databases: no.