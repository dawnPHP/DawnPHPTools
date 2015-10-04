/**
封装成ajax 函数
1.封装成函数： http://www.oschina.net/code/snippet_574274_11877 评论部分

2.封装成对象： http://www.oschina.net/code/snippet_574274_11877 正文部分

*/




/* ajax对象（工厂模式）
缺点是占内存，所幸不需要批量创建，所以也没啥
或者用原型链重写一个。
*/
function Ajax() {

	//创建ajax对象
    var xhr =null;
     if(window.XMLHttpRequest) {
         xhr = new XMLHttpRequest();
     } else {
          
         xhr = new ActiveXObject("Microsoft.XMLHttp");
     }
	 
	 //get请求
     this.get=function(url,successFn,failFn){ 
         xhr.open("GET", url,true);
         xhr.onreadystatechange=function(){
            if(xhr.readyState==4) {
                //alert(xhr.status);
                if(xhr.status==200) {
                    var txt = xhr.responseText;
					successFn(txt);
					/*
                     txt = eval("("+txt+")");
                     var ch = txt.charAt(0);
                        if(ch=="<") { //xml类型
                            var xml = xhr.responseXML;
                            successFn(eval("("+xml+")"));
                        } else if(ch=="["||ch=="{") {//json类型
                             txt = eval("("+txt+")");
                             successFn(txt);
                        } else {//不知道直接返回
                             
                            successFn(txt);
                        }
					*/
						
                } else {
                     if(failFn) {
                         failFn(xhr.status);
                     }
                }
            } 
              
         };
         xhr.send(null);
     };
      
     //post请求
     this.post = function (url,param,successFn,failFn) {
         xhr.open("POST", url,true);
         xhr.onreadystatechange=function(){
            if(xhr.readyState==4) {
                //alert(xhr.status);
                if(xhr.status==200) {
                    var txt = xhr.responseText;
					successFn(txt);
					/*
                    var ch = txt.charAt(0);
                    if(ch=="<") { //xml类型
                        var xml = xhr.responseXML;
                        successFn(eval("("+xml+")"));
                    } else if(ch=="["||ch=="{") {//json类型
                         txt = eval("("+txt+")");
                         successFn(txt);
                    } else {//不知道直接返回
                         
                        successFn(txt);
                    }
					*/
                     
                } else {
                     if(failFn) {
                         failFn(xhr.status);
                     }
                }
            } 
              
         };
         xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
         xhr.send(param);
     };
      
}/*end of the ajax object*/