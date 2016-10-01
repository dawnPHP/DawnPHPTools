<?php
include 'header.php';
include 'common/function.php';
?>

<?php 
echo '<h2>New Mode:</h2>';
?>
<div id=edit class="tagBox">
	<form action='action.php?a=tag' method='post'>
	<input type="text" style='display:block;width:500px;' name="tags" value="">
	<span>标签：</span>
	<div class="new">
		<ul class="clearfix">
		</ul>
		<div class="tag-input">
			<input type="text" name='input' value='' maxlength="20">
		</div>
	</div>
   
	<div class="taghint">
		<a onclick="return false;" hidefocus="true" href="#">
			<span>[Tip]</span>
			<span class="noshow">标签是由用户定义的、概括所发布内容的关键词，比目录分类更准确、更具体。经常并合理使用标签，可以让读者更加方便地找到感兴趣的条目。</span>
		</a>
		<span class="fc06">请使用空格或回车分隔不同标签</span>
	</div>
	
	<div class="old">      
		<div class="fc06">使用过的标签：</div>
		<div class="ztag">
			<?php 
			//获取旧标签
			$oldTags=getTagByUid($u_id);
			//遍历输出
			for($i=0;$i<count($oldTags);$i++){
				echo '<span>'.$oldTags[$i].'</span>'."\n";
			}
			?> 
		</div>
	  
		<div class="fc06">
			<p>请使用空格或回车分隔不同标签, 最多可输入5个</p>
		</div>
	</div>
	条目编号<input type='text' name='a_id' value='1'>
	<input type='hidden' name='u_id' value='<?php echo $a_id;?>'>
	<input type='submit' name='send' value='submit'>
	</form>
</div>
<script>
//tools
function $2(s){return document.getElementById(s);}
//除去空格
function trim(str){ //删除左右两端的空格
	return str.replace(/(^\s*)|(\s*$)/g, "");
}
function ltrim(str){ //删除左边的空格
	return str.replace(/(^\s*)/g,"");
}
function rtrim(str){ //删除右边的空格
	return str.replace(/(\s*$)/g,"");
}
//获取样式
/********************************
*获取非行间样式 ok
********************************
*用js的style方法(obj.style.attr)可以获得html标签的样式,但是不能获取非行间样式。
*那么怎么用js获取css的非行间样式呢?
*在IE下可以用currentStyle,而在火狐下面我们需要用到getComputed
*http://miostudio.blog.163.com/blog/static/22076512920142772540838/
*/
function getStyle(obj, attr){
	if(obj.currentStyle){
		return obj.currentStyle[attr];	//for IE only
	}else{
		return getComputedStyle(obj, false)[attr];//for ff/chrome only
	}
}



//===================
window.onload=function(){
	//获取待操作的dom元素
	var oTagBox=document.getElementById('edit');
	//新标签提交框（应该隐藏）
	var oTagInFrom=oTagBox.getElementsByTagName('input')[0];
	//新标签输入框 外div
	var oNewTag=oTagBox.getElementsByClassName('new')[0];
	//新标签输入框：内div
	var oNewTag_div=oNewTag.getElementsByTagName('div')[0];
	//新标签输入框：内ul
	var oUl=oNewTag.getElementsByTagName('ul')[0];
	//新标签输入框：内ul中的li数组
	var aLi=oUl.getElementsByTagName('li');
	//初始化时获取焦点
	var oNewTag_input=oNewTag.getElementsByTagName('input')[0];
	oNewTag_input.focus();
	
	//----------------------------
	//事件及其处理函数
	//----------------------------
	//鼠标悬停时显示提示
	var oSwitcher=(oTagBox.getElementsByClassName('taghint')[0]).getElementsByTagName('span')[0];//按钮
	var oHint=oTagBox.getElementsByClassName('noshow')[0];//提示文字
	oSwitcher.onmouseover=function(){
		oHint.style.visibility='visible';
		//鼠标移出时隐藏提示
		oSwitcher.onmouseout=function(){
			oHint.style.visibility='hidden';
		}
	}
	
	
	 
	//空格或回车 处理标签
	oNewTag_input.onkeydown=function(event){
		//获取事件
		var e = event || window.event || arguments.callee.caller.arguments[0];
		if((e && e.keyCode==13) || (e && e.keyCode==32)){ // enter键 或空格
			//获取输入
			var tagName=trim(this.value);
			//添加该标签
			addNewTag(tagName);
		}
	}
	
	//旧标签的单击事件
	var oldTag=oTagBox.getElementsByClassName('old')[0];
	var aOldTag=oldTag.getElementsByTagName('span');
	for(var i=0;i<aOldTag.length; i++){
		//获取该标签
		aOldTag[i].onclick=function(){
			var tagName=trim(this.innerHTML);
			//添加该标签
			addNewTag(tagName);
		}
	}
	

	//处理输入的新标签
	function addNewTag(tagName){
		//=======================合法性检测
		//去掉2端空格
		var tagName=trim(tagName);
		//如果有特殊字符，则过滤掉
		var reg=/[<>\/\\\.\[\]\{\}\=\+\-]/g;
		if( reg.test(tagName) ){
			alert('不能输入 <>/\.[]{}=+- 等特殊字符！');
			return;
		}
		//再过滤一遍特殊字符再使用
		tagName=tagName.replace(reg,'');
		
		//标签长度不能超过15个字符
		if(tagName.length==0){
			alert('标签不能为空！');
			//如果是空，则返回
			return;
		}
		if(tagName.length>=15){
			alert('标签不能超过15个字符！');
			//如果太长，则返回
			return;
		}
		
		//标签是否超过5个？
		var aTags=[];//bug(1.9),fixed.
		if(trim(oTagInFrom.value) !=''){
			aTags=oTagInFrom.value.split(',');
		}
		if(aTags.length>4){
			alert('最多可添加5个标签');
			oNewTag_input.value="";
			return;//如果超过5个，则返回
		}
		
		//标签是否和已有标签重复？
		if(aTags.indexOf(tagName)!=-1){
			oNewTag_input.value="";
			return;//如果已经有了，则返回
		}
		
		//=======================添加标签
		//1.显示到隐藏input中
		aTags.push(tagName);
		oTagInFrom.value=aTags.join(',');

		
		//2.当前input清空
		oNewTag_input.value="";
		//3.当前input缩短到很短
		oNewTag_div.style.width=10 +'px';
		//4.显示为灰背景标签//插入到ul的最后
		oUl.appendChild( getDom(tagName) );
		//5.再次调整input长度
		oNewTag_div.style.width=( parseInt(getStyle(oNewTag,'width')) -parseInt(getStyle(oUl,'width')) ) +'px';
		
		//设置光标焦点
		oNewTag_input.focus();
	}
	
	//处理单击删除事件
	for(var i=0;i<aLi.length;i++){
		 oLi=aLi[i];
		 aBtn=oLi.getElementsByTagName('span');
		
		aBtn[1].onclick=function(){
			doDeleteTag(this);
		}
	}
		
	//删除标签的事件处理函数
	function doDeleteTag(obj){
		//获取删除的文本
		var delTag='';
		if(obj.previousElementSibling){
			delTag= obj.previousElementSibling.innerHTML;
		}else{
			delTag= obj.previousSibling.innerHTML;
		}
		//从form->input中删除该tag
		var aTags=oTagInFrom.value.split(',');
		var arr=[];
		for(var i=0;i<aTags.length;i++){
			if(aTags[i]==delTag) continue;
			arr.push(aTags[i]);
		}
		oTagInFrom.value=arr.join(',');
		
		//删除该dom元素
		obj.parentElement.remove();
		//更新输入框的宽度
		oNewTag_div.style.width=( parseInt(getStyle(oNewTag,'width')) -parseInt(getStyle(oUl,'width')) ) +'px';
		//设置光标焦点
		oNewTag_input.focus();
	}
	
	
	//根据传入的tag名字创造dom并返回
	function getDom(tagName){
		//新建 span s1
		var s1=document.createElement('span');
		s1.setAttribute('class','tag-btn');
		s1.innerHTML=tagName;
		//新建 span s2
		var s2=document.createElement('span');
		s2.setAttribute('class','delete-tag-btn');
		s2.setAttribute('title','删除');
		s2.innerHTML='x';
		//添加单击事件
		s2.onclick=function(){
			doDeleteTag(this);
		}
		
		//新建 li
		var li=document.createElement('li');
		li.appendChild(s1);
		li.appendChild(s2);
		//return the new dom
		return li;
	}
	
}
</script>
</body>
</html>