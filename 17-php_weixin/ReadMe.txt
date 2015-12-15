微信开发日志

|-main
	|-menu
		|- Menu.class.php //菜单操作类
		|- menu_data.php //菜单结构信息
		|- Secret.class.php //密码信息（原型如下，自己补齐）
		|- ACC_TOKEN.class.php //获取ACC_TOKEN，不完善，请求太频繁。
				可以考虑放到数据库中，时间过了再请求更新。
		|- menu.php
			在menu.php中产生目录。由于没有300元认证，不能使用菜单功能。
	|-history
		|- index01.php 第一代，验证用。
		|- index-backup2.php 第二代备份，3个自定义回复功能。
		
//第二版：基本结构齐全。



//----------------------------------------------
Secret.class.php //密码信息（原型如下，自己补齐）
class Secret{
	static $APPID="xx";
	static $APPSECRET="xxxx";
}