<?php
/**
	第三方聊天机器人 JimmyTalk v1.0
	需要post方式调用，传入关键词keyword即可。
	输出json格式字符串: "{'answer':'something'}"
	需要在php中解码。
*/

//1.获取关键词
$keyword=$_POST['keyword'];

//2.生成答案
$answer='';
switch($keyword){
	case '1':
		$answer='功能1 地图';
		break;
	case '2':
		$answer='功能2 酒店';
		break;
	case '3':
		$answer='功能3 天气';
		break;
	case '4':
		$answer='功能4 联系我们';
		break;
	case '5':
		$answer='<b>功能5</b> 建议与意见\n回复中不支持html标记。';
		break;
	default:
		$answer="[该指令不能识别或还在开发中]\n请直接回复指令:\n1 查看地图; 2 查询酒店; \n3 查看天气; 4 联系我们; ";
		break;
}


//3.组装答案
$arr=array('answer'=>'Jimmy: ' . $answer);
//4.反馈答案
echo json_encode( $arr );