//==============================
// tools	
//==============================	
//删除空格
function trim(str){ //删除左右两端的空格 
	return str.replace(/(^\s*)|(\s*$)/g, ""); 
}

function ltrim(str){ //删除左边的空格 
	return str.replace(/(^\s*)/g,""); 
}

function rtrim(str){ //删除右边的空格 
	return str.replace(/(\s*$)/g,""); 
}
//选取
function $(s){return document.getElementById(s);}

//输出
function n(s){ console.log(s);}

//time秒后跳转到url中
function jump(url,time){
	document.write('添加成功，正在跳转...');
	setTimeout(function(){
		window.location=url;
	},time);
}

//检查是否为空
function isEmpty(obj,desc){
	if(obj.value==''){
		alert(desc+'不能为空！');
		obj.focus();
		return true;
	}
	return false;
}

/**
	根据json信息建立dom元素
	@para string 要建立的标签
	@para json object 属性键值对
	@para string or dom 元素内部innerHTML
	return dom元素
*/
function createElement(tag,json,innerHTML){
	var innerHTML=innerHTML||'';
	//新建对象
	var dom=document.createElement(tag);
	//添加属性
	for(var key in json){
		dom.setAttribute(key,json[key]);
	}
	//塞入内容
	if(innerHTML!=''){
		dom.innerHTML=innerHTML;
	}
	//返回
	return dom;
}
//测试 getElement('div',{'class':'red', 'id':'test2', },'123');




//==============================	
//dom操作，文档内部专用
//==============================

//初始化文章
function initArticle(u_id,cate_id){
	var cate_id=cate_id!=undefined?cate_id:-1;	//默认参数

	var url='cateAction.php?a=artilist&u_id='+u_id+'&cate_id='+cate_id;
	var ajax=new Ajax();
	ajax.get(url,function(s){
		var objs=eval("("+s+")");
		showArticle(objs);
	});
}


//初始化目录
function initCate(u_id){
	var url='cateAction.php?a=category&u_id='+u_id;
	var ajax=new Ajax();
	ajax.get(url,function(s){
		var objs=eval("("+s+")");
		if(objs.length==0){return;}
		showCate(objs);
	});
}

//根据jsons插入目录
function showCate(objs){
	var oLi;
	//1.获取父元素，清空
	var oLeft=document.getElementsByClassName('left')[0];
	var oUl=oLeft.getElementsByTagName('ul')[0];
	oUl.innerHTML='';
	
	//1.1 所有分类
	var count=0;
	for(var i=0;i<objs.length;i++){
		count += parseInt( objs[i]['count'] );
	}
	
	var all={id: "-1", name: "所有分类", u_id: u_id, u_rank: "0",'count':count};
	oLi=getCateDom(all,cate_id==-1?true:false);
	oUl.appendChild(oLi);
	
	//2.对objs循环
	for(var i=0;i<objs.length;i++){
		var obj=objs[i];
		//Object {id: "1", name: "html", u_id: "2", u_rank: "1"}
		//3.获取dom
		if(cate_id==obj['id']){
			oLi=getCateDom(obj,true);
		}else{
			oLi=getCateDom(obj);
		}
		//4.插入父元素中
		oUl.appendChild(oLi);
	}
}

//根据obj创建dom并返回
function getCateDom(obj,isCurrent){
	var isCurrent=isCurrent||false;
	//2.创建目录dom
	var oA=document.createElement('a');
	oA.setAttribute('href','index.php?cate_id='+obj['id']+'&u_id='+obj['u_id']);
	oA.innerHTML=obj['name']+'('+obj['count']+')';
	var oLi=document.createElement('li');
	if(isCurrent){
		oLi.setAttribute('class','current');
	}
	if(obj['u_rank']==-1){
		oLi.setAttribute('id','default');
	}
	oLi.appendChild(oA);
	return oLi;
}

//获取提示dom元素
function getNoticeDom(){
	var oDiv=document.createElement('div');
	oDiv.setAttribute('class','notice');
	oDiv.innerHTML='该分类下条目数为0！';
	return oDiv;
}

//根据jsons插入文章
function showArticle(objs){
	//1.获取右侧父元素，并初始化
	var oRight=document.getElementsByClassName('right')[0];
	oRight.innerHTML="<span class='catalog'> 条目列表:</span>";
	//2.如果没有条目
	if(objs.length==0){
		//2.1.没有条目时，造一个提示
		var oDiv=getNoticeDom();
		//2.2.插入文档结构中
		oRight.appendChild(oDiv);
		//2.3.直接返回
		return;
	}
	//3.如果有元素
	//3.1.对objs循环
	for(var i=0;i<objs.length;i++){
		//3.2创建dom对象
		var oDiv=getArticleDom(objs[i]);
		//3.3插入父文档流
		oRight.appendChild(oDiv);
	}
}

//根据obj插入文章dom
function getArticleDom(obj){
	//2.创建文章dom
	var oA=document.createElement('a');
	oA.setAttribute('class','title');
	oA.setAttribute('href','detail.php?a_id='+obj['id']);
	oA.setAttribute('target','_blank');
	oA.innerHTML=obj['title'];
		
	var oSpan1=document.createElement('span');
	var oA1=document.createElement('a');
	//oA1.setAttribute('href','cateAction.php?a=del&a_id='+obj['id']);
	oA1.setAttribute('href',"javascript:void(0);");
	oA1.setAttribute('onclick',"delItem("+obj['id']+");");
	//oA1.setAttribute('title',obj['id']);
	oA1.setAttribute('target','_blank');
	oA1.innerHTML='删除';
	oSpan1.appendChild(oA1);
	
	var oSpan2=document.createElement('span');
	oA2=document.createElement('a');
	oA2.setAttribute('href','edit.php?a_id='+obj['id']);
	oA2.setAttribute('target','_blank');
	oA2.innerHTML='编辑';
	oSpan2.appendChild(oA2);
	
	var oP=document.createElement('p');
	oP.innerHTML=obj['add_time'];
	oP.appendChild(oSpan1);
	oP.appendChild(oSpan2);
	
	var oDivBar=document.createElement('div');
	oDivBar.setAttribute('class','bar c1');
	
	var oDivStatus=document.createElement('div');
	oDivStatus.setAttribute('class','status');
	oDivStatus.appendChild(oDivBar);
	
	var oDiv=document.createElement('div');
	oDiv.setAttribute('class','item');
	oDiv.setAttribute('id','item'+obj['id']);
	oDiv.appendChild(oA);
	oDiv.appendChild(oP);
	oDiv.appendChild(oDivStatus);
	
	return oDiv;
}

	
	
	
	
//在添加条目和移动条目中列出所有分类（条目数）
//初始化下拉框中的分类.
//最后一个id为可选，表示当前项
function initCateList(selection,newSelection,id){
	var newSelection=newSelection||'';//如果没有值，则为空
	var id=id||null;
	//var selection=selection;
	var ajax=new Ajax();
	//var url='doChangeCate.php?a=catelist';
	var url='cateAction.php?a=category';
	ajax.get(url,function(s){
		selection.innerHTML='';
		var objs=eval("("+s+")");
		if(objs.length==0){return;}
		for(var i=0;i<objs.length;i++){
			refreshCateSelection(objs[i],selection,id);
			if(newSelection!=''){
				newSelection.innerHTML=selection.innerHTML;
			}
		}
	});
}

//在添加条目和移动条目中列出所有分类（条目数）
//[在管理条目页面中 修改条目分类]：显示所有分类
function refreshCateSelection(obj,selection,id){
	//1.造dom
	//Object {id: "22", name: "html", u_id: "2", u_rank: "1", count: 0}
	var oOption=document.createElement('option');
	oOption.setAttribute('value',obj['id']);
	oOption.innerHTML=obj['name']+'('+ obj['count'] +')';
	
	//设置分类
	var id=id||null;
	if(id!=null){
		if(id==obj['id']){
			oOption.setAttribute('selected','selected');
		}
	}else{
		if(obj['u_rank']==-1){
			oOption.setAttribute('selected','selected');
		}
	}
	//2.插入selection
	selection.appendChild(oOption);
}


//删除条目：通过a_id
function delItem(a_id,delItemOnly){
	var delItemOnly=delItemOnly||false;//是否仅仅删除条目

	//再次征求用户意见
	if(!confirm('警告：确实要删除该记录吗？['+a_id+']')){return;}
	
	//1.ajax删除
	var ajax=new Ajax();
	var url="cateAction.php?a=del&a_id="+a_id;
	
	ajax.get(url,function(isDelete){
		if(isDelete){
			//在detail页面中删除后跳转到主页
			if(delItemOnly){
				location='index.php';
				return;
			}
			
			//1.获取元素
			var oRight=document.getElementsByClassName('right')[0];
			var nItemLength=oRight.getElementsByClassName('item').length;
			//1.1.如果是最后一个元素，直接初始化空数组
			if(nItemLength==1){
				showArticle([]);
			}else{
				//否则仅仅去掉当前元素
				//1.2.回调函数中删除dom
				var dom=$('item'+a_id);
				dom.parentElement.removeChild(dom);
			}
			
			//1.3.重新初始化分类
			initCate(u_id);//u_id调用全局变量todo
		}else{
			alert('删除失败！请和管理员联系。');
		}
	});
}


//
//创建上下文菜单：detail页面
function getContextDom(uDom,dDom){
	//1.left 
	if(uDom['id']==undefined){
		uDom= {id: "", title: "已经是第一篇",'status':'start'};
	}
	oA2=document.createElement('a');
	if(uDom['status']==undefined){
		oA2.setAttribute('href','detail.php?a_id='+uDom['id']);
	}
	oA2.innerHTML=uDom['title'];


	oP2=document.createElement('p');
	oP2.setAttribute('class','flow_left');

	if(uDom['status']==undefined){
		oT2=document.createTextNode('<');
		oP2.appendChild(oT2);
	}

	oP2.appendChild(oA2);
	
	//2.right
	if(dDom['id']==undefined){
		dDom= {id: "", title: "已经是最后一篇",status:'end'};
	}
	
	oA=document.createElement('a');
	if(dDom['status']==undefined){
		oA.setAttribute('href','detail.php?a_id='+dDom['id']);
	}
	oA.innerHTML=dDom['title'];

	oP=document.createElement('p');
	oP.setAttribute('class','flow_right');
	oP.appendChild(oA);

	if(dDom['status']==undefined){
		oT=document.createTextNode('>');
		oP.appendChild(oT);
	}

	//3.0 返回
	return [oP,oP2];
}
	
	
