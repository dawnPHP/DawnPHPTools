/* ajax对象（原型模式）
v1.1: 增加json到post的字符格式
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
     'post': function (url,param,successFn,failFn) {
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
         this.xhr.send( json2Paras(param) );
     },
	 
	//json到post的字符格式
	json2Paras:function (obj){
		//如果不是json直接返回
		if(typeof obj!='object')
			return obj;
		//如果是json，拼接后返回
		var str='';
		for(var k in obj){
			str += '&'+k+'='+obj[k];
		}
		return str;
	}
      
}/*end of the ajax prototype*/
