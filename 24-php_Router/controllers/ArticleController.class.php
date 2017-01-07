<?php
class ArticleController{
	function __construct(){
		$base_url="http://localhost/DawnPHPTools/24-php_Router/Article";
		echo '<div style="background:#efeeef; border:1px dashed green;padding:10px;">init....<br>';
		echo "<a href='$base_url/index/cat/good/id/12?name=wxm'>index方法</a> | ";
		echo "<a href='$base_url/show/id/2017'>show方法</a> | <hr>";
	}


	public function index($cat='bad',$id=0,$name='wjl默认参数'){
		echo "<h1>index</h1>";
		echo '<pre>Article-index: test.<br>';
		echo 'id='.$_GET['id'].'<br>';//如果省略方法名，必须是?id=90 传递
		echo 'cat='.$cat.'<br>';
		echo 'name='.$name;
	}
	
	function show($id=0){
		echo "<h2 style='color:#f00;'>show</h2>";
		echo '<pre>Article-show: test.<br>';
		echo '展示 id='.$id.' 的文章。';
	}
	
	function __destruct(){
		echo '<p>the end......................</p>';
		echo "</pre></div>";
	}
}