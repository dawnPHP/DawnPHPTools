var xmlHttp
/**通过id获取该对象*/
function $(s){
	if(typeof s =="object")return s;
	return document.getElementById(s);
}

/**
showHint() 函数
每当在输入域中输入一个字符，该函数就会被执行一次。
如果文本框中有内容 (str.length > 0)，该函数这样执行：
定义要发送到服务器的 URL（文件名）
把带有输入域内容的参数 (q) 添加到这个 URL
添加一个随机数，以防服务器使用缓存文件
调用 GetXmlHttpObject 函数来创建 XMLHTTP 对象，并在事件被触发时告知该对象执行名为 stateChanged 的函数
用给定的 URL 来打开打开这个 XMLHTTP 对象
向服务器发送 HTTP 请求
如果输入域为空，则函数简单地清空 txtHint 占位符的内容。
*/
function showHint(str){
	if (str.length==0){ 
	  $("txtHint").innerHTML=""
	  return
	}
	
	//获得ajax对象
	xmlHttp=getXmlHttpObject()
	if (xmlHttp==null){
	  alert ("Browser does not support HTTP Request")
	  return
	}
	
	// 提交的url及get传递的参数
	var url="gethint.php"
	url=url+"?q="+str
	url=url+"&sid="+Math.random()//防止缓存设置的后缀
	//如果建立连接，则执行状态函数
	xmlHttp.onreadystatechange=stateChanged
	//打开ajax
	xmlHttp.open("GET",url,true)
	//发送请求
	xmlHttp.send(null)
}

/**
stateChanged() 函数
每当 XMLHTTP 对象的状态发生改变，则执行该函数。
在状态变成 4 （或 "complete"）时，用响应文本填充 txtHint 占位符 txtHint 的内容。
*/
function stateChanged(){ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){ 
		$("txtHint").innerHTML=xmlHttp.responseText 
	} 
}

/**
getXmlHttpObject() 函数
AJAX 应用程序只能运行在完整支持 XML 的 web 浏览器中。
上面的代码调用了名为 getXmlHttpObject() 的函数。
该函数的作用是解决为不同浏览器创建不同 XMLHTTP 对象的问题。
*/
function getXmlHttpObject(){
	var xmlHttp=null;
	try{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}catch (e){
		// Internet Explorer
		try{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e){
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}