------------------------
Log format for each tools:
------------------------
title: php文件上传系统
Description:适用于文件上传
	重要思路：
		1.上传文件后是utf-8编码，需要在upload

	缺点：
		1.不支持多文件上传。希望能智能识别是单文件或多文件

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
 |- 03	是jq版无刷新文件上传

==================================================
Databases: No.