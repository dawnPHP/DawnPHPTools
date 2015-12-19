====================================================
//我们有三个订阅号会在一个粉丝很多的微信号上推广，然后这个推广需要做三个超链接，链接到我的三个订阅号，然后关注领一个红包

//服务号是可以直接设置关注领红包
//文章里面放三个图标，图标里放超链接
//就是在那个粉丝多的微信号上发一个文章


//订阅号可能就需要再做一个关注自动回复链接到服务号在领红包


//然后要求
//1、可以统计通过链接关注的数量；
//2、领红包限制地区（仅限某地区内可以领）；
//3、禁止通过第三方软件等恶意刷关注领红包；
//4、已经关注过了不能再领红包，不能重复领

//微信开发？微信支付  1321044350
//还有你试试，能不能增减订阅号，因为我们到时候可能会考虑加订阅号或者减订阅号
//目前是订阅号 编辑模式。
//红包我自己申请服务号
====================================================

红包开发记录

v0.008 开发红包功能。
	[1] 获取 jsapi_ticket
	http://mp.weixin.qq.com/wiki/11/74ad127cc054f6b80759c40f77ec03db.html
	[2]no---获得jsapi_ticket之后，就可以生成JS-SDK权限验证的签名了。
		不知道干啥用的。没有实现。
	
	[3]no-- 商户平台，红包接口：
		这是客服里的介绍：微信红包需要开微信支付http://kf.qq.com/faq/140225MveaUz150424uUBFRn.html
	
	网页版accessToken：http://mp.weixin.qq.com/wiki/4/9ac2e7b1f1d22e9e57260f6553822520.html
	
		1）接口发放
	商户根据文档"【商户平台】现金红包API文档V2”进行开发，一次调用可以给一个指定用户发送一个指定金额的红包，满足多元化的运营需求；


	
	
		官方：https://pay.weixin.qq.com/wiki/doc/api/cash_coupon.php?chapter=13_5
		解说：http://www.tiandiyoyo.com/2015/03/wechat_hongbao_by_php/
微信商户平台：https://pay.weixin.qq.com/wiki/doc/api/cash_coupon.php?chapter=10_4
红包接口：https://pay.weixin.qq.com/wiki/doc/api/cash_coupon.php?chapter=13_5
		
	[4]-- 跳转  "scope参数错误或没有scope权限"
		网页样板：http://bbs.csdn.net/topics/391051153
	
	

	
	
	
	
微信支付类：http://www.jb51.net/article/63299.htm
		http://www.oschina.net/code/snippet_2276613_46605
微信红包API接口（PHP） http://www.jyboke.com/web/55.html

微信红包发放类：http://www.tiandiyoyo.com/2015/03/wechat_hongbao_api_for_php/


微信红包随机生成算法（PHP版）{预先生成所有的红包}http://justcoding.iteye.com/blog/2210361
红包算法（一次一算，太累）：http://justcoding.iteye.com/blog/2210359

微信js-sdk说明：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html#.E6.AD.A5.E9.AA.A4.E4.B8.80.EF.BC.9A.E7.BB.91.E5.AE.9A.E5.9F.9F.E5.90.8D



具体而言，网页授权流程分为四步：
http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html


微信支付途径：https://pay.weixin.qq.com/wiki/doc/api/index.html
微信支付：https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=3_1




---------------------------
一年多少钱？
阿里云 29元/月 最低的配置哦 不过对于学习够用了
https://help.aliyun.com/document_detail/ecs/shopping-guide/buy-instance/price.html

百度云 32元/月 
http://bce.baidu.com/doc/BCH/Pricing.html#.E5.8C.85.E5.B9.B4.E5.8C.85.E6.9C.88.E8.AE.A1.E8.B4.B9

腾讯云 10元/月？？？没硬盘？
http://www.qcloud.com/product/cvm.html#price


猪八戒的红包功能悬赏100元：
http://task.zhubajie.com/5523429/



---------------------------
微信支付
http://mp.weixin.qq.com/wiki/11/74ad127cc054f6b80759c40f77ec03db.html

请注意该接口只能在你配置的支付目录下调用，同时需确保支付目录在JS接口安全域名下。
微信支付开发文档：https://pay.weixin.qq.com/wiki/doc/api/index.html






---------------------------
微信订阅号如何做关注领红包
http://zhidao.baidu.com/link?url=uR_7p65LOerw7CiNIO5sgOfBq01uvXefeT3fGHP_AB090xaYsLgde9f9wP9RlX5hYcT4gilj92vOYPvBuJXDoWSzX1CfDJn9sS91rEBZ6ae
1 做红包页面开发
2 新建关注后自动回复，设置自动回复为红包领取链接
3 关注之后收到链接推送
4 点击链接地址，进入到已经开发好的红包领取页面

---------------------------
关注微信公众号领红包如何实现？？？
http://zhidao.baidu.com/link?url=j87U1O6-mFXjjdJRfWp5iS7DXAmmMV7zscGUm08Aj-69CQTH0b39B5cPxxcHTHQ4fb6sWGN-N8F8h8czKNrqWqZR0m_0Nx7PVV8T-ZcXKSe
首先要开通微信支付，登录微信商户，充钱进去，建立红包。
然后，进入公众号开发者中心，接入你的服务器。
调用接口，支付接口，获取用户open id ,调用关注时回复，发送红包。

我会PHP语言，关注时回复，已成功！可是回复发送红包，这个步骤没有做过！不知道如何来做！

如果你会语言，http://mp.weixin.qq.com/wiki/home/index.html这里有官方开发文档，然后根据他的请求格式就可以了
查看下微信支付开发者接口。跟开发者中心的接口不一样的。


oauth2/

https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxd38431e9c296e9c7&redirect_uri=http%3A%2F%2F520.focusmedia.cn%2Fwxapi%2Fke-fei%2Findex%3Fkey%3D&response_type=code&scope=snsapi_base&state=123&connect_redirect=1#wechat_redirect

---------------------------
支付工具
https://pay.weixin.qq.com/wiki/doc/api/index.html





---------------------------
---------------------------
---------------------------
---------------------------
---------------------------
---------------------------
---------------------------
---------------------------
---------------------------














