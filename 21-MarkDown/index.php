<meta charset=utf8>
<link rel="stylesheet" type="text/css" href="MarkDown.css">


<?php
/*
说明：

使用开源parser
https://github.com/SegmentFault/HyperDown

访问本页面
http://wjl.com/MarkDown/index.php?id=1
http://wjl.com/MarkDown/index.php?id=2

学习markdown
1.就一张图即可。
真把以简单的东西搞复杂了，就wikipedia上看张图，对比一下就明白了 https://en.wikipedia.org/wiki/...
2.另一个学习资源：https://github.com/younghz/Markdown

样式表：
github和segmentFault上的样式表挺好的！
一共提供了2张css样式表：一个html格式的，一个是把markdown转化为markdown（也就是保持格式不变。。。挺无聊和有趣的）


待处理的markdown: http://blog.dawneve.cc/index.php?k=css&id=1_3
预备整合到txtBlog系统中去。

*/

// 引入类库
include 'MDParser.class.php';

// 读取文件
//$file_name1='gulp.md';
$file_name1='me.md';
$text = file_get_contents($file_name1);

//根据id判断是否导入另一个文件
if(isset($_GET['id']) && $_GET['id'] == 1){
	$file_name2='me.md';
	$text = file_get_contents($file_name2);
}

//导出
$parser = new HyperDown\MDParser;
$html = $parser->makeHtml($text);

echo '<div class=markdown>',$html,'</div>';
