<?php
// Fill up array with names
$a[]="Anna";
$a[]="Brittany";
$a[]="Cinderella";
$a[]="Diana";
$a[]="Eva";
$a[]="Fiona";
$a[]="Gunda";
$a[]="Hege";
$a[]="Inga";
$a[]="Johanna";
$a[]="Kitty";
$a[]="Linda";
$a[]="Nina";
$a[]="Ophelia";
$a[]="Petunia";
$a[]="Amanda";
$a[]="Raquel";
$a[]="Cindy";
$a[]="Doris";
$a[]="Eve";
$a[]="Evita";
$a[]="Sunniva";
$a[]="Tove";
$a[]="Unni";
$a[]="Violet";
$a[]="Liza";
$a[]="Elizabeth";
$a[]="Ellen";
$a[]="Wenche";
$a[]="Queen";
$a[]="Vicky";

//get the q parameter from URL
$q=$_GET["q"];

//lookup all hints from array if length of q>0
if (strlen($q) > 0){
	$hint="";
	for($i=0; $i<count($a); $i++){
		if(strtolower($q)==strtolower(substr($a[$i],0,strlen($q)))){
			if ($hint==""){
				$hint=$a[$i];
			}else{
				$hint=$hint." , ".$a[$i];
			}
		}
	}
}

//Set output to "no suggestion" if no hint were found
//or to the correct values
if ($hint == ""){
	$response="no suggestion";
}else{
	$response=$hint;
}

//output the response
echo $response;


/**
如果存在从 JavaScript 送来的文本 (strlen($q) > 0)，则：
找到与 JavaScript 所传送的字符相匹配的名字
如果找到多个名字，把所有名字包含在 response 字符串中
如果没有找到匹配的名字，把 response 设置为 "no suggestion"
如果找到一个或多个名字，把 response 设置为这些名字
把 response 发送到 "txtHint" 占位符
*/
?>