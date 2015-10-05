<?php
//本案例重在模拟ajax，并没有访问数据库

//获取访问类型
$action=$_GET['a'];


//处理访问请求
switch ($action){
	case 'c_del'://echo '删除';
		
		//删除数据
		//(此处省略几十行)
		$total_deleted=1;

		//设定返回值
		if($total_deleted>0){
			$msg[0]=1;//成功
			$msg[1]= '成功删除了'.$total_deleted.'条评论.';
		}else{
			$msg[0]=0;//失败
			$msg[1]= '成功删除了0条评论.';
		}
		$msg[]=$_GET['cid'];
		if(in_array(43,$msg)){
			$msg[]=44;
		}
		//返回json
		echo json_encode($msg);
		
		break;
	case 'c_add'://	echo '添加';
		//添加数据
		//(此处省略几十行) 一次添加一条

		//设定返回值
		$msg[]=1;//成功
		$msg[]='添加成功';//添加成功
		$msg[]=$_POST['pid'];//返回添加条目父id:pid
		$msg[]=1+$_POST['pid'];//返回添加条目的id //SELECT LAST_INSERT_ID()
		$msg[]=date('Y-m-d h:i:s', time());//返回添加时间
		
		//$msg['post']=$_POST;//返回全部数据，供参考
		//返回json
		echo json_encode($msg);
	
		break;
	default:
		echo 'something Error: 20151004';
}