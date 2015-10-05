
------------------------
dir: domMethods
------------------------
title: js操作dom的一些常用方法
Description: 添加和删除dom元素
keywords: dom操作
pros&cons:
http://miostudio.blog.163.com/blog/static/22076512920159482715633/
精要碎碎念：
0. 注意兼容性。firstChild和firstElementChild等。
1.插入元素需要2步
	先创建，再插入旧dom中；
	创建dom只有1个方法createElement(tagname)。
	插入有2个方法appendChild和insertBefore。

2.特殊情况：
	2.1如果有其他属性，则需要使用setAttribute(attr,value)添加。
	2.2如果新dom中还要插入东西，可以插入，之后再插入旧dom中；
		插入方法同上1中所述，或者使用innerHTML也行；

	2.3如果有事件，则创建好新dom可以直接绑定事件，再插入旧dom中；

3.注意同一个标签元素组成的数组是动态数组，和你定义的位置无关。
	插入新标签后，数组会扩容。反之自动减少。


元素、节点、标签都是一个意思。
	
version: V1.0.0
time:[20:58 2015-10-04]
auther: Dawn
Email: jimmymall@live.com









------------------------
dir: ajax_object
------------------------
title:用fn/oop/prototype各封装一个ajax
Description: 都可以实现get和post提交数据
keywords:ajax object prototype
pros&cons:
优点与经验：
	- 注意prototype中内嵌套的this和外部的this不一样，如果
		要在内部使用外部this，需要在外部var _that=this;在内部用_that;
	- 嵌套请求(第一个ajax请求成功，再请求第二个，适合于文章评论系统)：demoObjPrototypePost2nd.html
缺点：
	- 还没有处理返回数据的方式，json、xml、string等。
	
version: V1.0.2
time:[11:26 2015-10-04]
auther: Dawn
Email: jimmymall@live.com





------------------------
dir: ajax_add_dom
------------------------
title:ajax添加后添加dom
Description: 优化了删除dom功能。实现了添加dom功能。
keywords:ajax  dom
pros&cons:
	1. dom定位搞定。比如新dom放到哪个的前面或某个的后面等。
	2. [推荐]封装了一个dom操作库：./ajax_add_dom/nodeFn.js, 可以应用到其他地方。
version: V1.0
time:[10:50 2015-10-04]
auther: Dawn
Email: jimmymall@live.com




------------------------
dir: ajax_delete_dom
------------------------
title:ajax返回后删除dom
Description: 可以循环删除多个dom（只看web页面像级联删除。）
keywords:ajax  dom
pros&cons:

version: V1.0
time:[22:50 2015-10-03]
auther: Dawn
Email: jimmymall@live.com




------------------------
Log format for each tools:
------------------------
title:php版简易ajax--Suggestions
Description:
keywords:ajax
pros&cons:

version: V1.0
time:[13:55 2015-09-07]
auther: Dawn
Email: jimmymall@live.com

Files:
这个例子包括三张页面：
	一个简单的 HTML 表单
	一段 JavaScript
	一张 PHP 页面
Databases: no
	
