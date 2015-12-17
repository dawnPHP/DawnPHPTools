<?php
/**
  * wechat php test
  */

//define your token

include('../MyDebug.class.php');


define("TOKEN", "201412161997");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
           		$msgType = "text";
				if(!empty( $keyword ))
                {
					//============================
					switch($keyword){
						case '帮助':
							$contentStr = "1 查看地图; 2 查询试剂; \n3 查看冰箱; 4 实验方法; \n5 查看天气; 6 查询联系方式; ";
							break;
						case '1':
							$contentStr = "郑州地图在开发中";
							break;
						case '2':
							$contentStr = "21 查看进口试剂； \n22 查看国产试剂";
							break;
						case '3':
							$contentStr = "31 查看4度冰箱；\n32 查看-20度冰箱；\n33 查看-80冰箱";
							break;
							
						case '4':
							$contentStr = "41 分子实验手册；\n42 细胞实验手册；\n43 动物实验手册；\n44 生物信息实验";
							break;
						case '41':
							$contentStr = "41 分子实验手册：<a href='http://202.196.120.202/weixin/files/载体构建操作手册(简略版).pdf'>点击下载pdf</a>";
							break;	
						case '42':
							$contentStr = "42 细胞实验手册：正在整理中。";
							break;		
						case '43':
							$contentStr = "43 动物实验手册：正在整理中。";
							break;		
						case '44':
							$contentStr = "44 生物信息实验：正在整理中。";
							break;
						case '5':
							$contentStr = "51 NCBI；\n52 blast；\n53 PDB；";
							break;
						case '6':
							$contentStr = "60 国资处网站; \n61 试剂电话; \n62 耗材电话;";
							break;
						default:
							$contentStr = "[该指令不能识别或还在开发中]\n请直接回复数字指令.\n回复 帮助 查询指令信息。";
							break;
					}
                }else{
                	$contentStr="Input something...";
                }
				
				//============================
				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
				echo $resultStr;

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>