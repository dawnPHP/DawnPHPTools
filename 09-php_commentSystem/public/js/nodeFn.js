/**
title: nodeFn.js
description: DOM Function Lib
time: 2015.10.05
auther: Dawn
version: v1.0.0
license: MIT

from:tool 01/ajax_add_dom/nodeFn.js
*/
//根据id获取obj
function $(s){
	if(typeof s=='object') return s;
	return document.getElementById(s);
}

//----------------------------------
//		删除 v1.1
//----------------------------------
//删除obj对应的dom元素
function removeDom(obj){
	if(typeof obj!='object'){
		obj=$(obj);
	}
	return obj.parentElement.removeChild(obj)
}

//----------------------------------
//		创建
//----------------------------------
//创建并返回dom
function createNode(tag,attriObj,inner){
	var attriObj=attriObj||{};
	var inner=inner||'';
	//创建元素
	var newNode=document.createElement(tag);
	//添加属性
	for(var i in attriObj){
		newNode.setAttribute(i, attriObj[i]);
	}
	//内部元素
	if(inner!=''){
		newNode.innerHTML=inner;
	}
	//返回dom元素
	return newNode
}


//a1=createNode('div',{'class':'comment sub', 'id':100},'this is a dom')


//----------------------------------
//		插入
//----------------------------------
//向指定结点前插入新结点函数  
function appBefore(newNode, refNode){  
	var refNode = $(refNode);   
	//如果存在双亲结点
	if(refNode.parentNode){
		//父节点.insertBefore(newchild,refchild)
		//说明：newchild(插入的新结点) refchild(将新结点插入到此结点前)  
		refNode.parentNode.insertBefore(newNode, refNode);  
	}else{
		//如果不存在双亲结点，怎么办？
	}
}

//向指定结点后插入新结点函数(最有用的函数)
function appAfter(newNode, refNode){  
	var refNode = $(refNode);
	//如果存在上一级结点  
	if(refNode.parentNode){
		//如果存在下一子结点  
		if(refNode.nextSibling){
			// 在下一子结点前插入子结点  
			refNode.parentNode.insertBefore(newNode, refNode.nextSibling);  
		}else{
			// 如果没有下一子结点向后追加子结点  
			refNode.parentNode.appendChild(newNode);  
		}
	}
}


//向指定结点内插入新结点函数(最没用的函数，直接原生appendChild更好)  
function insertWithin(newNode, refNode){
	//指定结点 id
	var refNode = $(refNode);
	//追加一个新的结点
	refNode.appendChild(newNode);
}
