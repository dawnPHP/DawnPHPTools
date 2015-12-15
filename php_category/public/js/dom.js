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





//==============================	
//dom操作，文档内部专用
//==============================	
	//根据jsons插入文章
	function showArticle(objs){
		if(objs.length==0){
			var oDiv=document.createElement('div');
			oDiv.setAttribute('class','notice');
			oDiv.innerHTML='该分类下条目数为0！';
			
			//3.插入文档结构中
			var oRight=document.getElementsByClassName('right')[0];
			oRight.appendChild(oDiv);

			return;
		}
		//1.对objs循环
		for(var i=0;i<objs.length;i++){
			var obj=objs[i];
			insertArticleDom(obj);
		}
	}

	//根据obj插入文章dom
	function insertArticleDom(obj){
		//2.创建目录dom
		var oA=document.createElement('a');
		oA.setAttribute('class','title');
		oA.setAttribute('href','detail.php?a_id='+obj['id']);
		oA.setAttribute('target','_blank');
		oA.innerHTML=obj['title'];
		
		oSpan1=document.createElement('span');
		oA1=document.createElement('a');
		oA1.setAttribute('href','cateAction.php?a=del&a_id='+obj['id']);
		oA1.setAttribute('target','_blank');
		oA1.innerHTML='删除';
		oSpan1.appendChild(oA1);
		
		oSpan2=document.createElement('span');
		oA2=document.createElement('a');
		oA2.setAttribute('href','edit.php?a_id='+obj['id']);
		oA2.setAttribute('target','_blank');
		oA2.innerHTML='修改';
		oSpan2.appendChild(oA2);
		
		oP=document.createElement('p');
		oP.innerHTML=obj['add_time'];
		oP.appendChild(oSpan1);
		oP.appendChild(oSpan2);
		
		oDivBar=document.createElement('div');
		oDivBar.setAttribute('class','bar c1');
		
		oDivStatus=document.createElement('div');
		oDivStatus.setAttribute('class','status');
		oDivStatus.appendChild(oDivBar);
		
		oDiv=document.createElement('div');
		oDiv.setAttribute('class','item');
		oDiv.appendChild(oA);
		oDiv.appendChild(oP);
		oDiv.appendChild(oDivStatus);
		
		//3.插入文档结构中
		var oRight=document.getElementsByClassName('right')[0];
		oRight.appendChild(oDiv);
	}

	
	//根据jsons插入目录
	function showCate(objs){
		//所有分类
		var count=0;
		for(var i=0;i<objs.length;i++){
			count += parseInt( objs[i]['count'] );
		}
		
		var all={id: "-1", name: "所有分类", u_id: u_id, u_rank: "0",'count':count};
		insertCateDom(all,cate_id==-1?true:false);

		//1.对objs循环
		for(var i=0;i<objs.length;i++){
			var obj=objs[i];
			//Object {id: "1", name: "html", u_id: "2", u_rank: "1"}
			if(cate_id==obj['id']){
				insertCateDom(obj,true);
			}else{
				insertCateDom(obj);
			}
		}
	}
	
	//根据obj创建dom并插入到ul中
	function insertCateDom(obj,isCurrent){

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
			oLi.setAttribute('class','default');
		}
		oLi.appendChild(oA);
		//3.插入文档结构中
		var oLeft=document.getElementsByClassName('left')[0];
		var oUl=oLeft.getElementsByTagName('ul')[0];
		oUl.appendChild(oLi);

	}
	
	
	//在添加条目和移动条目中列出所有分类（条目数）
	//初始化下拉框中的分类
	function initCateList(selection,newSelection){
		var newSelection=newSelection||'';//如果没有值，则为空
		//var selection=selection;
		var ajax=new Ajax();
		//var url='doChangeCate.php?a=catelist';
		var url='cateAction.php?a=category';
		ajax.get(url,function(s){
			selection.innerHTML='';
			var objs=eval("("+s+")");
			if(objs.length==0){return;}
			for(var i=0;i<objs.length;i++){
				refreshCateSelection(objs[i],selection);
				if(newSelection!=''){
					newSelection.innerHTML=selection.innerHTML;
				}
			}
		});
	}
	
	//在添加条目和移动条目中列出所有分类（条目数）
	//[在管理条目页面中 修改条目分类]：显示所有分类
	function refreshCateSelection(obj,selection){
		//1.造dom
		//Object {id: "22", name: "html", u_id: "2", u_rank: "1", count: 0}
		var oOption=document.createElement('option');
		oOption.setAttribute('value',obj['id']);
		oOption.innerHTML=obj['name']+'('+ obj['count'] +')';
		if(obj['u_rank']==-1){
			oOption.setAttribute('selected','selected');
		}
		//2.插入selection
		selection.appendChild(oOption);
	}
	