------------------------
Log format for each tools:
------------------------
title: 17-php_weixin（可以用临时号测试所有接口）
Description:我的微信开发框架

keywords:微信、开发、php
pros&cons: 
	pros:
	cons:

version: v1.0.0
time:[20:15 2015-12-15]
auther: Dawn
Email: jimmymall@live.com

Files&Functions:
==================================================
|-DawnPHP //我的微信开发框架
	|- mylib.php //入口文件
	|- class //类文件
		|- Secret.class.php //密码信息（原型如下，自己补齐）
		|- ACC_TOKEN.class.php //获取ACC_TOKEN，不完善，请求太频繁。
			已经放到文件缓存中，时间过了再请求更新。大大减少了延时。
		|- MyConfig.class.php //操作缓存文件中的配置项
		|- Menu.class.php //菜单操作类
		|- MyDebug.class.php //排错与记录类
|-menu  //微信菜单的操作
	|- config.php //最新的ACC_TOKEN缓存
	|- menu_data.php //菜单结构信息
	|- menu.php
		在menu.php中产生目录。由于没有300元认证，不能使用菜单功能。
	|- test.php
|-history
	|- index01.php 第一代，验证用。
	|- index-backup2.php 第二代备份，3个自定义回复功能。

//----------------------------------------------
Secret.class.php //密码信息（原型如下，自己补齐）
class Secret{
	static $APPID="xx";
	static $APPSECRET="xxxx";
}
==================================================
Databases: no.


//----------------------------------------------
//----------------------------------------------
//第3版：基本结构齐全。
已经做过的功能：
1.可以通过扫一扫即刻申请官方测试号，可以测试所有接口；
	微信接口测试，临时号：
	http://mp.weixin.qq.com/debug/cgi-bin/sandbox?t=sandbox/login

	测试号信息
	appID:wx527dd89a15670d7e
	appsecret:d4624c36b6795d1d99dcf0547af5443d


	请填写接口配置信息，此信息需要你有自己的服务器资源，填写的URL需要正确响应微信发送的Token验证，请阅读消息接口使用指南。
	URL:http://202.196.120.202/weixin/demo/index.php
	Token:201412161997
	
	获取ACC_TOKEN;
	获取二维码。
	
2.基本信息的回复（【事件】、文字、图片、图文、音乐等）
	- xml格式
	

3.菜单的添加功能
	|-menu 详情见menu文件夹
	- 菜单删减
	- 菜单点击的功能制作
	-
	
4.- 用户登录与管理
	