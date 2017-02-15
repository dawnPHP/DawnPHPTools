锋利的PHP工具箱
	————抽象成函数或类，放到工具箱中备用。


标签ok，分类ok，标签ok，回收站，字体设置，分享，添加好友等。
MySQLHelper ok, Router ok, Cache ok.
Hook ok,

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
[MySQL][PHP]22-MySQL_data_transfer(MySQL监视表)
[excel2mysql] 04-php_excel2MySQL
[pdf]	06-PHP_Lib_FPDF
[jsonp]	12-jsonp
[user info]	13-php_getUserInfo
[tags]	14-php_short_tags

[autoload]	15-php_autoload_class(可以带namespace)
[ORM]	16-php_user_model_dawnPHP（我的OOP框架、ORM模型）
[wechat][微信]	17-php_weixin（微信开发）
[config]	18-php_config_class（基于数组）
[cURL]	19-php_cURL_domainPriceAPI(基于cURL采集数据)
[目录]	20-php_category(基于目录的分类)
[markdown]	21-MarkDown
[Cache] 23-php_file_Cache(文件缓存实例)
[Router] 24-php_Router(路由系统)
[Hook] 25-php_Hook (钩子)

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
[2015-11-24]	14-php_short_tags
[2015-12-08]	15-php_autoload_class(可以带namespace)
[2015-12-09]	16-php_user_model_dawnPHP（我的OOP框架、ORM模型）
[2015-12-15]	17-php_weixin（微信开发）
[2015-12-15]	18-php_config_class（基于数组）
[2015-12-28]	19-php_cURL_domainPriceAPI(基于cURL采集数据)
[2015-12-28]	20-php_category(基于目录的分类)
[2016-10-01]	21-MarkDown(markdown读取类)
[2017-01-01]	22-MySQL_data_transfer(MySQL类)
[2017-01-05]	23-php_file_Cache(文件缓存实例)
[2017-01-07]	24-php_Router(路由系统)
[2017-02-15]	25-php_Hook(钩子)


-----------------------------------
===================================




===================================
-----------------------------------
按类名索引：
10-php_upload_files	{MyDebug: v1.0.0, UploadFiles: v1.0.0}
11-php_zoom_image	{MyDebug: v1.0.1, Dir: v1.0.0, ZoomImage:v1.0.0}
13-php_getUserInfo	{myAgentInfo: v1.0.0}
15-php_autoload_class(可以带namespace)
16-php_user_model_dawnPHP（我的OOP框架、ORM模型）dawnPHP v0.1.0
17-php_weixin（微信开发） {MyDebug: v1.0.2, cURL:比较初级}
18-php_config_class（基于数组） {Config: v1.0.0}
19-php_cURL_domainPriceAPI(基于cURL采集数据) {cURL:比较初级}
比较推荐 20-php_category(基于目录的分类) 中类的结构，初步实现自动加载。
21-MarkDown	{}
25-php_Hook {钩子 Hook:v1.0.0}
 
还未加入class文件
 22-MySQL_data_transfer(MySQL监视表) (MysqlHelper: 操作MySQL的类)
 23-php_file_Cache(文件缓存实例){Cache:文件缓存}
 24-php_Router(路由系统){Router:路由系统}
 25-php_Hook(钩子)
 
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
     * 检测上传根目录(米欧云上传时支持自动创建目录，直接返回)
     * @param string $rootpath   根目录
     * @return boolean true-检测通过，false-检测失败
     */
	 functon xx($rootpath){
		return false;
	 }
}

