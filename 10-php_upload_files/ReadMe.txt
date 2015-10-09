------------------------
Log format for each tools:
------------------------
title: php文件上传系统
Description:适用于文件上传
基本包括3种思路：formdata、iframe和swf。

重要思路：
	1.通过指向iframe的form进行无刷新想后台传值，之后2种思路显示图像；
		- 返回给iframe一些img元素，监测iframe值的变化，替换其中的<实体后插入显示到新div；
		- 通过返回给iframe一个script元素，包含：parent.someFunction(index,imgUrl)显示图片；
	2.上传文件后是utf-8编码，需要在upload的目的地使用iconv转换。
	3.上传按钮一般全透明，隐藏在a标签前（zindex设置大一些），看到的都是a标签。
	4.移动input而不是复制进行临时请求，便于展示“缩略图”。之后归为input到原始位置。
	
缺点：
	1.不支持多文件上传。希望能智能识别是单文件或多文件（04版本已经实现）

keywords:上传
pros&cons: 能写不执行，执行不能写！否则会有安全隐患！

version: v1.0.0
time:[20:57 2015-10-06]
auther: Dawn
Email: jimmymall@live.com

Files&Functions:
==================================================
---共2个方案：
 |- 01	函数方案：上传限制（pptx、pdf）
 |- 02	是封装了类库	{MyDebug: v1.0.0, UploadFiles: v1.0.0}
 |- 03	是jq版无刷新文件上传 （中文文件名乱码） 
 |- 04	03的增强版，是jq版无刷新多文件上传，立刻显示。{MyDebug: v1.0.1, UploadFiles: v1.0.0}
 |- demo/05	
	- index01
		1.一次上传1个文件；基于iframe；即刻上传。
		2.支持chrome, IE8, ff。

	- index02
		1.一次上传1个文件；基于dataform；即刻上传。
		2.支持chrome,ff， 不支持 IE8 。

 |- demo/06 使用了formdata，支持多文件上传，但是不支持IE8-
 |- 07实例 使用了iframe，jQ的实时上传文件，相当于上传了2次，第二次可以移动。
				需要继续优化。

==================================================
Databases: 
--Current database: gqh
CREATE TABLE `zuopin` (
  `tid` int(10) NOT NULL AUTO_INCREMENT COMMENT '记录主ID，主键，自增型',
  `biaoti` varchar(300) NOT NULL COMMENT '作品名称',
  `info` text NOT NULL COMMENT '作品说明',
  `writer` varchar(300) NOT NULL COMMENT '作者',
  `ptime` varchar(300) NOT NULL COMMENT '拍摄时间',
  `saishi_id` int(10) NOT NULL COMMENT '所属赛事ID，对应表saishi中的tid',
  `group_id` int(10) NOT NULL COMMENT '所属组的ID，对应表group中的tid',
  `ip` varchar(30) NOT NULL COMMENT '添加记录时的IP',
  `dtime` datetime NOT NULL COMMENT '添加记录时的时间',
  `mid` int(10) NOT NULL COMMENT '上传作品的会员的ID，对应表member中的tid',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '作品的状态，1表示审核中，2表示
已送展，3表示未获奖,4表示送展中.5表示已获奖',
  `filename1` varchar(100) NOT NULL COMMENT '存放图片文件名，就是作品图片文件名'
,
  `amount` decimal(14,2) NOT NULL COMMENT '订单金额',
  `payment_status` tinyint(1) NOT NULL COMMENT '订单支付状态，1表示支付成功，0表
示未支付',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;