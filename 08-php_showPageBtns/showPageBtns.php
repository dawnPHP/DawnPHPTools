<?php
//测试实例
$current_url=$_SERVER['PHP_SELF'];
$current_page  = isset( $_GET['p'] )?$_GET['p']:1;
$total_pages=20;
echo showPageBtn($current_url,$current_page, $total_pages,3);
//实例结束



/**
name:显示翻页按键的函数 
	仿照网易博客效果 http://jimmymall.blog.163.com/blog/#m=0
version:1.0
	参数：
	当前url
	当前页码
	总页码
	每页前后显示按钮个数(加上首尾和当前页，共9个按钮)
*/
function showPageBtn($current_url,$current_page, $total_pages, $totalBtnNum=3){
	$str='';
	if($current_page>1){
		//上一页
		$str='<a href="'.$current_url.'?p='.($current_page-1).'">上一页</a>  | ';
		//第一页
		$str .='<a href="'.$current_url.'?p=1">1</a> | ';
		if($current_page>=6) $str.=' ... | ';
	}elseif($current_page==1){
		$str.='1 | ';
	}else{
		return false;//不能小于最小页码1
	}
	
	
	//当前页之[前]的页码按钮
	$before_current=$current_page;
	$before_current=$before_current>$totalBtnNum?$totalBtnNum:$before_current;
	for($i=$before_current;$i>0; $i--){
		if($current_page-$i>1){
			$str .='<a href="'.$current_url.'?p='.($current_page-$i).'">'.($current_page-$i).'</a> | ';
		}
	}
	

	//当前页的页码按钮
	if($current_page!=1 and $current_page!=$total_pages){
		$str .= $current_page.' | ';
	}

	
	//当前页之[后]的页码按钮
	$after_current=$total_pages - $current_page;
	$after_current=$after_current>$totalBtnNum?$totalBtnNum:$after_current;
	for($i=1;$i<=$after_current; $i++){
		if($current_page+$i<$total_pages){
			$str .='<a href="'.$current_url.'?p='.($current_page+$i).'">'.($current_page+$i).'</a> | ';
		}
	}
			
		
	if($current_page<$total_pages){
		if($total_pages-$current_page>4) $str.=' ... | ';
		//最后一页
		$str.='<a href="'.$current_url.'?p='.$total_pages.'">'.$total_pages.'</a> | ';
		
		//下一页
		$str.='<a href="'.$current_url.'?p='.($current_page+1).'">下一页</a>';
		
	}elseif($current_page==$total_pages){
		$str.= $total_pages;
	}else{
		return false;//不能是超过最大页码
	}
	
	
	//返回页码字符
	return $str;
}