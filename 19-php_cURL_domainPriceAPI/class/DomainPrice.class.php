<?php

class DomainPrice{
	private $refreshTime=1800;//单位为秒

	function __construct($refreshTime=''){
		if($refreshTime!=''){
			$this->refreshTime=$refreshTime;
		}
	}
	
	function get(){
		//设置地址
		$url='http://www.west.cn/web/domaintrade/historyoftrade?have=&foreclose=&againforeclose=&type=&min_length=&max_length=&dom_ext=&p_type=&p_topmoney_low=&p_topmoney_top=&overtime_low=2015-12-01&overtime_top=2015-12-10&_csrf=V1R2WUEwYUhlMlsMMkIqGx4ZBTANAgctbyISOwxSUT1jNR0.cEoEPg%3D%3D&page=1&pagesize=50';

		//获取数据
		$file='./CurrentPriceData.txt';
		//文件存在，且不超过30min=1800s
		if(file_exists($file) && (time() - filemtime($file))<$this->refreshTime ){
			$data=file_get_contents($file);
		}else{
			//发起请求
			$ch=new MyCurl2();
			$data= $ch->_request($url,false);
			
			
			//获取失败，则还是使用旧数据
			if(0==strlen($data)){
				if(file_exists($file)){
					$data=file_get_contents($file);
				}else{
					$data='';//todo 如果没有获取，怎么办？
				}
			}else{			
				//保存记录
				file_put_contents($file, $data); 
				
				//备份: 按照时间保存一份
				$timeStamp=date('YmdHis',time());
				$file_name='data/price'. $timeStamp .'.txt';
				file_put_contents($file_name, $data);
			}
		}

		//输出数据
		return $data;
	}
}