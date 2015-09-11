<?php

//常数库
define("DEMOFILE","tiezi.txt");// 定义帖子文件名




//函数库
/**
*参数：文件路径
*返回：获得文件行数：
*/
function getLines($fileName){
	//打开文件
	$fh=fopen($fileName,"r");
	$line=0;
	if(!$fh){
		die("文件句柄错误");
	}
	//统计行数
	while(fgetcsv($fh)){
		$line++;
	}
	//关闭文件
	fclose($fh);
	//返回文件行数
	return $line;
}


/**{该函数不具有通用性}
获取最后一行的id:就是最后一行第一个数字
*/
function getLastLineId($fileName){
	$fp=file($fileName);
	$record=$fp[count($fp)-1];//显示最后一行
	return explode(",",$record)[0]+0;
}

/**{该函数不具有通用性}
获取最大id:就是每一行第一个数字中最大的值
*/
function getMaxTid($fileName){
	$lines=file($fileName);//把整个文件读入数组
	$maxTid=0;
	foreach ($lines as $line_num => $line) {
		$tid=explode(",",$line)[0]+0;//是用行号隔开的
		if($tid>$maxTid) $maxTid=$tid;
	}
	return $maxTid;
}

/**{该函数不具有通用性}
按照帖子id删除该帖子
*/
function deleteByTid($fileName,$tid){
	$lines=file($fileName);//把整个文件读入数组
	$newFile="";//新的文件
	foreach ($lines as $line_num => $line) {
		$id=explode(",",$line)[0]+0;//是用行号隔开的
		if($tid==$id) continue;
		$newFile .= $line;
	}
	//用新文件覆盖旧文件
	$fh=fopen($fileName,"w");
	fwrite($fh,$newFile);
	fclose($fh);
}

/**{该函数不具有通用性}
获得某tid对应的行，并返回上半部分、下半部分
*/
function getArrayByTid($fileName,$tid){
	$lines=file($fileName);//把整个文件读入数组
	$isUp=true;//是否是上半部分内容
	$halfUp="";//修改行上半部分
	$theArray="";//待修改行
	$halfDown="";//修改行下半部分
	foreach ($lines as $line_num => $line) {
		$id=explode(",",$line)[0]+0;//是用逗号隔开的
		if($tid==$id){
			$isUp=false;
			$theArray=explode(",",$line);
			continue;
		}
		if($isUp){
			$halfUp .= $line;
		}else{
			$halfDown .= $line;
		}
	}

	return array("up"=>$halfUp, "one"=>$theArray, "down"=>$halfDown);
}

/**TODO:
定位文件指针到某一行
*/
function setPointer($fh,$rowNum){
	//
}

?>