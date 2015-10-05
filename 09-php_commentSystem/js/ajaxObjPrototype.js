/**
封装成ajax 函数
1.封装成函数： http://www.oschina.net/code/snippet_574274_11877 评论部分

2.封装成对象： http://www.oschina.net/code/snippet_574274_11877 正文部分

from: tool 01/ajax_object/ajaxObjPrototype.js
time: 2015.10.05
version: v1.0.1
*/




/* ajax对象（工厂模式）
缺点是占内存，所幸不需要批量创建，所以也没啥
或者用原型链重写一个。
*/
function Ajax(){
	//创建ajax对象
    this.xhr =null;
     if(window.XMLHttpRequest) {
         this.xhr = new XMLHttpRequest();
     } else {
         this.xhr = new ActiveXObject("Microsoft.XMLHttp");
     }	 
}

//在原型上添加东西
Ajax.prototype={
	 //get请求
     'get':function(url,successFn,failFn){
         this.xhr.open("GET", url,true);
		 var _that=this;//注意！内部的this和外部不一样，要从外部传递
         this.xhr.onreadystatechange=function(){
            if(_that.xhr.readyState==4) {
                //alert(_that.xhr.status);
                if(_that.xhr.status==200) {
					successFn(_that.xhr.responseText);						
                } else {
                     if(failFn) {
                         failFn(_that.xhr.status);
                     }
                }
            } 
              
         };
         this.xhr.send(null);
     },
      
     //post请求
     'post': function (url,params,successFn,failFn) {
         this.xhr.open("POST", url,true);
		 var _that=this;
         this.xhr.onreadystatechange=function(){
            if(_that.xhr.readyState==4) {
                //alert(this.xhr.status);
                if(_that.xhr.status==200) {
                    var txt = _that.xhr.responseText;
					successFn(txt);
					/*
                    var ch = txt.charAt(0);
                    if(ch=="<") { //xml类型
                        var xml = this.xhr.responseXML;
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
                         failFn(_that.xhr.status);
                     }
                }
            }
              
         };
         this.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
         this.xhr.send(params);
     },
      
}/*end of the ajax prototype*/