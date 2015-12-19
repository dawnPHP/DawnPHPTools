<?php
/**
 * 微信红包的类 
 * @Author snmoney#gmail.com 
 * @blog http://snmoney.blog.163.com
 * @copyright 2015 
 * @version 1.0
 * 
 * 本类可任意授权使用，务必保留作者信息以便侦错改进；
 * 对因修改源码产生直接或间接经济损失，作者不承担任何责任。
 * 
 * *微信红包还有部分可选的参数，如分享预设值等将在后续版本补充上相关功能。
 */


CLASS WXHongBao {
    
    private $mch_id = "1200000001";//商户ID写死
    private $wxappid = "wxc9e767a123456789";//微信公众号，写死
    private $client_ip = "123.45.67.89"; //调用红包接口的主机的IP,服务端IP,写死，即脚本文件所在的IP
    private $apikey = "76340869e6a1d98cf16cd216ea449e14";//写死，pay的秘钥值
    private $total_num = 1;//发放人数。固定值1，不可修改
    
    private $nick_name = "XX公众号"; //红包商户名称
    private $send_name = "XX公司";//红包派发者名称
    private $wishing = "祝福语"; //    
    private $act_name = "红包活动"; //活动名称
    private $remark = "活动备注";
    private $nonce_str = "";
    private $mch_billno = "";
    private $re_openid = "";//接收方的openID    
    private $total_amount = 1 ;//红包金额，单位 分
    private $min_value = 1;//最小金额
    private $max_value = 1; //根据接口要求，上述3值必须一致             
    private $sign = ""; //签名在send时生成
    
    //证书，在构造函数中定义，注意！
    private $apiclient_cert; //= getcwd()."/apiclient_cert.pem";
    private $apiclient_key;// = getcwd()."/apiclient_key.pem";
    
    private $wxhb_inited; //初始值默认为false,判定红包是否已newhb()方式初始化
    
    private $error = "ok"; //init
    


    /**
     * WXHongBao::__construct()
     * 步骤
     * new(openid,amount)
     * setnickname
     * setsend_name
     * setwishing
     * setact_name
     * setremark
     * send()
     * @return void
     */
    function __construct(){
        //好像没有什么需要构造函数做的
        $this->wxhb_inited = false; 
        $this->apiclient_cert = getcwd()."/apiclient_cert.pem";
        $this->apiclient_key = getcwd()."/apiclient_key.pem";
    }
    
    public function err(){
        return $this->error;
    }
	
    /**
     * WXHongBao::newhb()
     * 构造新红包 
     * @param mixed $toOpenId
     * @param mixed $amount 金额分
     * @return void
     */
    public function newhb($toOpenId,$amount){
        if(!is_numeric($amount)){
            $this->error = "金额参数错误";
            return;
        }elseif($amount<100){
            $this->error = "金额太小";
            return;
        }elseif($amount>20000){
            $this->error = "金额太大";
            return;
        }
        
        $this->gen_nonce_str();//构造随机字串
        $this->gen_mch_billno();//构造订单号
        $this->setOpenId($toOpenId);
        $this->setAmount($amount);
        $this->wxhb_inited = true; //标记微信红包已经初始化完毕可以发送
    }
    
    /**
     * WXHongBao::send()
     * 发出红包
     * 构造签名
     * @return boolean $success
     */
    public function send(){
        if(!$this->wxhb_inited){
            $this->error .= "(红包未准备好)";
            return false; //未初始化完成
        }
        $this->gen_Sign(); //生成签名
        
        //构造提交的数据
        $xml = $this->genXMLParam();        
        
        //提交xml,curl
        $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";
        $ch = curl_init();    	
    	curl_setopt($ch,CURLOPT_TIMEOUT,10);
    	curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);    	
    	curl_setopt($ch,CURLOPT_URL,$url);
    	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
    	
    	curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
    	curl_setopt($ch,CURLOPT_SSLCERT,$this->apiclient_cert);    	
    	curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
    	curl_setopt($ch,CURLOPT_SSLKEY,$this->apiclient_key);
    	
        /* 
    	if( count($aHeader) >= 1 ){
    		curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
    	}
        */        
    	curl_setopt($ch,CURLOPT_POST, 1);
    	curl_setopt($ch,CURLOPT_POSTFIELDS,$xml);
    	$data = curl_exec($ch);
    	if($data){
    	    curl_close($ch);	
    		$rsxml = simplexml_load_string($data);
            if($rsxml->return_code == 'SUCCESS' ){
                return true;
            }else{
                $this->error = $rsxml->return_msg;
                return false;    
            }
            
    	}else{ 
    		$this->error = curl_errno($ch);
    		 
    		curl_close($ch);
    		return false;
    	}

	}
    
    public function setNickName($nick){
        $this->nick_name = $nick;
    }
    
    public function setSendName($name){
        $this->send_name = $name;
    }
    
    public function setWishing($wishing){
        $this->wishing = $wishing;
    }
    
    /**
     * WXHongBao::setActName()
     * 活动名称 
     * @param mixed $act
     * @return void
     */
    public function setActName($act){
        $this->act_name = $act;
    }
    
    public function setRemark($remark){
        $this->remark = $remark;
    }
    
    public function setOpenId($openid){
        $this->re_openid = $openid;
    }
    
    /**
     * WXHongBao::setAmount()
     * 设置红包金额
     * 文档有两处冲突描述 
     * 一处指金额 >=1 (分钱)
     * 另一处指金额 >=100 < 20000 [1-200元]
     * 有待测试验证！
     * @param mixed $price 单位 分
     * @return void
     */
    public function setAmount($price){
        $this->total_amount = $price;
        $this->min_value = $price;
        $this->max_value = $price;
    }
    
    private function gen_nonce_str(){
        $this->nonce_str = strtoupper(md5(mt_rand().time())); //确保不重复而已
    }
    
    private function gen_Sign(){
        unset($param); 
        //其实应该用key重排一次 right?
        $param["act_name"]=$this->act_name;
        $param["client_ip"]=$this->client_ip;
        $param["max_value"]=$this->max_value;
        $param["mch_billno"] = $this->mch_billno;        
        $param["mch_id"]=$this->mch_id;
        $param["min_value"]=$this->min_value;
        $param["nick_name"]=$this->nick_name;
        $param["nonce_str"]=$this->nonce_str;        
        $param["re_openid"]=$this->re_openid;
        $param["remark"]=$this->remark;        
        $param["send_name"]=$this->send_name;
        $param["total_amount"]=$this->total_amount;
        $param["total_num"]=$this->total_num;        
        $param["wishing"]=$this->wishing;
        $param["wxappid"]=$this->wxappid;
        
        ksort($param); //按照键名排序...艹，上面排了我好久
        
        //$sign_raw = http_build_query($param)."&key=".$this->apikey;
        $sign_raw = "";
        foreach($param as $k => $v){
            $sign_raw .= $k."=".$v."&";
        }
        $sign_raw .= "key=".$this->apikey;
        
        $this->sign = strtoupper(md5($sign_raw));
    }
    
    /**
     * WXHongBao::genXMLParam()
     * 生成post的参数xml数据包
     * 注意生成之前各项值要生成，尤其是Sign
     * @return $xml
     */
    public function genXMLParam(){
        $xml = "<xml>
            <sign>".$this->sign."</sign> 
            <mch_billno>".$this->mch_billno."</mch_billno> 
            <mch_id>".$this->mch_id."</mch_id> 
            <wxappid>".$this->wxappid."</wxappid> 
            <nick_name><![CDATA[".$this->nick_name."]]></nick_name> 
            <send_name><![CDATA[".$this->send_name."]]></send_name> 
            <re_openid>".$this->re_openid."</re_openid> 
            <total_amount>".$this->total_amount."</total_amount> 
            <min_value>".$this->min_value."</min_value> 
            <max_value>".$this->max_value."</max_value> 
            <total_num>".$this->total_num."</total_num> 
            <wishing><![CDATA[".$this->wishing."]]></wishing> 
            <client_ip><![CDATA[".$this->client_ip."]]></client_ip> 
            <act_name><![CDATA[".$this->act_name."]]></act_name> 
            <remark><![CDATA[".$this->remark."]]></remark>             
            <nonce_str>".$this->nonce_str."</nonce_str> 
</xml>";
        
        return $xml;
    }
    
    /**
     * WXHongBao::gen_mch_billno()
     *  商户订单号（每个订单号必须唯一） 
        组成： mch_id+yyyymmdd+10位一天内不能重复的数字。 
        接口根据商户订单号支持重入， 如出现超时可再调用。 
     * @return void
     */
    private function gen_mch_billno(){
        //生成一个长度10，的阿拉伯数字随机字符串
        $rnd_num = array('0','1','2','3','4','5','6','7','8','9');
        $rndstr = "";
        while(strlen($rndstr)<10){
            $rndstr .= $rnd_num[array_rand($rnd_num)];    
        }
        
        $this->mch_billno = $this->mch_id.date("Ymd").$rndstr;
    }
}

?>