/**
封装成ajax 函数
1.封装成函数： http://www.oschina.net/code/snippet_574274_11877 评论部分

2.封装成对象： http://www.oschina.net/code/snippet_574274_11877 正文部分

*/




/* 单独的ajax函数
* file:文件名
* fnSucc：读取文件成功时的回调函数函数，响应值为其传入参数；
* fnFaild：读取文件失败时的回调函数函数，错误代码为其传入参数；
* paras：传入的参数列表（需要提前组装好）；
*/
function ajax(method, url, fnSucc, fnFaild, paras){
//function ajax(method, url, paras, type){ //需要修改结果处理部分
//var result = ajax("GET","test.jsp?uname=ddd&password=bbb",null,"json");  
//var result = ajax("POST","test.jsp","uname=ddd&password=bbb","xml");  

		paras=paras || null;
		
		//1.创建ajax对象
		if(window.XMLHttpRequest){//加window是为了兼容IE6
			var oAjax=new XMLHttpRequest();//非IE6
		}else{
			var oAjax=new ActiveXObject('Microsoft.XMLHTTP');	//for IE6
		}
		
		//2.链接服务器
		//open(方法, 文件名, 同步或异步);
        //优化方法：访问方式：如果dataPata不为空，自动设置为POST；如果为空设置为GET。
		oAjax.open(method,url,true);
		
		//如果请求方法是post,下面这名必须加
		if(method.toUpperCase()=='POST')
			oAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		
		//3.准备接收返回，和解析的方法；
		oAjax.onreadystatechange=function(){
			//oAjax.readyState 浏览器和服务器通信到哪一步了
			if(4==oAjax.readyState){//4就是读取完成；但可能文件不存在
				if(200==oAjax.status){  //成功
					//由函数处理（我喜欢）
					fnSucc(oAjax.responseText);//server端的文件内容传入；
					
					//或 直接做处理并返回
					//var result;
					//if("json" == type){result = eval("("+request.responseText+")");
					//}else if("xml" == type){result = request.responseXML;
					//}else{result = request.responseText;}
				}else{
					//alert("failed to get the file on the server.." + oAjax.status);
					if(fnFaild){//如果定义了错误函数，则进行处理；
						fnFaild(oAjax.status);//传入参数为错误代码；
					}
				}
			}
		}
		
		//4.发送请求
		oAjax.send(paras);
		// return result;
}/*end of function ajax*/