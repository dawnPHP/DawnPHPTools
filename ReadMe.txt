====================================
============总索引==================
按功能、加入时间分别索引。
====================================
===================================
-----------------------------------
按功能索引：
[ajax][dom add and delete] 01-php版简易ajax--Suggestions
[BBS][File] 02-php_BBS_FileBased
[blog][counter]	07-php_counter
[二维码][phpqrcode]	05-php_erWeiMa
[博客底部][页码]	08-php_showPageBtns
[评论][递归]	09-php_commentSystem
[upload][上传][上传预览]	10-php_upload_files
[zoom][picture]	11-php_zoom_image

[AuthCode][YanZhengMa][验证码] 03-php_yanZhengMa(AuthCode)
[MySQL][PHP][增删改查] 00-singlePageBlog
[excel2mysql] 04-php_excel2MySQL
[pdf]	06-PHP_Lib_FPDF
[jsonp]	12-jsonp
[user info]	13-php_getUserInfo

-----------------------------------
===================================



===================================
-----------------------------------
按时间索引：
[2015-09-07]	01-php版简易ajax--Suggestions	
[2015-09-11]	02-php_BBS_FileBased
[2015-09-12]	03-php_yanZhengMa(AuthCode)
[2015-09-22]	04-php_excel2MySQL
[2015-09-24]	00-singlePageBlog
[2015-09-24]	05-php_erWeiMa
[2015-09-25]	06-PHP_Lib_FPDF
[2015-09-29]	07-php_counter
[2015-09-30]	08-php_showPageBtns
[2015-10-01]	09-php_commentSystem
[2015-10-06]	10-php_upload_files 
[2015-10-08]	11-php_zoom_image
[2015-11-21]	12-jsonp
[2015-11-22]	13-php_getUserInfo

-----------------------------------
===================================




===================================
-----------------------------------
按类名索引：
10-php_upload_files	{MyDebug: v1.0.0, UploadFiles: v1.0.0}
11-php_zoom_image	{MyDebug: v1.0.1, Dir: v1.0.0, ZoomImage:v1.0.0}
13-php_getUserInfo	{myAgentInfo: v1.0.0}


-----------------------------------
===================================

13:36 2015-09-07
决定：把php日常小部件整理到github上，避免重复造轮子。
建立phpTools，为每个项目做记录，并维护一个总的readMe:
------------------------
加入dawnPHPTools的资格:
------------------------
1)功能相对独立、明确;
2)通过测序，要记录测试环境和相关软件版本号(如win7+php5.6+mysql5.5));
3)拥有完善的文档，及代码内部注释；
4)文件夹统一编号，并在总readme中分别进行按类索引、按时间索引。
------------------------
Log format for each tools:V0.1.0
------------------------
title:
Description:
keywords:
pros&cons:

version: using 3 digital numbers separated by dot. Change the 2nd number when Functioning well, change the 1st number when there is a greate advance.
time:press F5 in notepad[13:55 2015-09-07]
auther: Dawn
Email: jimmymall@live.com

Files&Functions:
Databases:


5)类文件和方法的注释规范，并单独进行索引
/**=============================================
 * Benchmark Class
 *
 * This class enables you to mark points and calculate the time difference
 * 类名时驼峰法，方法名是下划线法。
 *
 * @version		v1.0.0
 * @revise		2015.10.06
 * @date		2015.10.06
 * @author		Dawn
 * @email		JimmyMall@live.com
 * @link		https://github.com/DawnEve/DawnPHPTools
 =============================================*/
class Benchmark{
	 /**
     * 检测上传根目录(百度云上传时支持自动创建目录，直接返回)
     * @param string $rootpath   根目录
     * @return boolean true-检测通过，false-检测失败
     */
	 functon xx(){}
}

