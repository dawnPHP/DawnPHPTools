------------------------
Log format for each tools:
------------------------
title: 验证码和验证码类
Description:几个验证码和验证码类，按时间排序。一个类一个调用实例，实例文件中有详细说明。
keywords:验证码、AuthCode
pros&cons: test1.php等中的js不错：单击更新验证码图片

version: v1.0.0
time:press F5 in notepad[10:28 2015-09-12]
auther: Dawn modified from the web.
Email: jimmymall@live.com

Files$Functions:
==================================================
实例01：最普通的html + 计算题验证码类.
php中：验证码类和实例化。

服务器字段：$_SESSION['AuthCode']
-------------------------------------------------

实例02：最普通的html+面向过程的验证码。
php中：很普通难看的验证码。适合学习原理。

服务器字段：$_SESSION['randcode']
-------------------------------------------------
实例03：最普通的html+OOP【中文】验证码类。
php中：支持中英文验证码，厉害

服务器字段：
$sessionName='captchaCode';
$_SESSION[$sessionName]['time']=microtime(); 
$_SESSION[$sessionName]['type']=$type;
$_SESSION[$sessionName]['AuthCode3']=$code;
$_SESSION["captchaCode"]['AuthCode3']=$code;//直接用这个

-------------------------------------------------
实例04：最普通的html+面向过程验证码。
php中：自定义实现，很简单。

服务器字段：$_SESSION["validationcode"]

-------------------------------------------------




==================================================
Databases:NO.