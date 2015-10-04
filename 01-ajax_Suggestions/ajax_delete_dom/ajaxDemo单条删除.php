<?php
//删除数据
//(此处省略几十行)
$total_deleted=1;

//设定返回值
if($total_deleted>0){
	$msg[0]=1;//成功
	$msg[1]= '成功删除了'.$total_deleted.'条评论.';
}else{
	$msg=array(0, '删除了0条数据');
}
$msg[2]=$_GET['cid'];
//返回json
echo json_encode($msg);