<?php
/*
PHP版微信公众平台红包API

作者：youkuiyuan 字体：[增加 减小] 类型：转载 时间：2015-04-02 我要评论

这篇文章主要介绍了PHP版微信公众平台微信API类，目前主要实现了微信红包接口，陆续会继续进行更新，非常的实用，这里推荐给小伙伴们，有需要的朋友可以参考下。
重写了一下PHP下面的微信API接口，
微信红包支持，JSAPI的动态参数接口支持
http://git.oschina.net/youkuiyuan/yky_test/blob/master/class/wxapi.class.php
微信API类 - 增加红包支持
*/




  /********************************************************
   *   @author Kyler You <QQ:2444756311>
   *   @link http://mp.weixin.qq.com/wiki/home/index.html
   *   @version 2.0.1
   *   @uses $wxApi = new WxApi();
   *   @package 微信API接口 陆续会继续进行更新
   ********************************************************/
 
class WxApi {
    const appId     = "";
    const appSecret   = "";
	
    const mchid     = ""; //商户号
    const privatekey  = ""; //私钥
	
    public $parameters = array();
 
    public function __construct(){
 
    }
 
    /****************************************************
     * 微信提交API方法，返回微信指定JSON
     ****************************************************/
 
    public function wxHttpsRequest($url,$data = null){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
 
    /****************************************************
     * 微信带证书提交数据 - 微信红包使用
     ****************************************************/
 
    public function wxHttpsRequestPem($url, $vars, $second=30,$aHeader=array()){
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
 
        //以下两种方式需选择一种
 
        //第一种方法，cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/apiclient_cert.pem');
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY,getcwd().'/apiclient_key.pem');
 
        curl_setopt($ch,CURLOPT_CAINFO,'PEM');
        curl_setopt($ch,CURLOPT_CAINFO,getcwd().'/rootca.pem');
 
        //第二种方式，两个文件合成一个.pem文件
        //curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');
 
        if( count($aHeader) >= 1 ){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }
 
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
        $data = curl_exec($ch);
        if($data){
            curl_close($ch);
            return $data;
        }
        else { 
            $error = curl_errno($ch);
            echo "call faild, errorCode:$error\n"; 
            curl_close($ch);
            return false;
        }
    }
 
    /****************************************************
     * 微信获取AccessToken 返回指定微信公众号的at信息
     ****************************************************/
 
    public function wxAccessToken($appId = NULL , $appSecret = NULL){
        $appId     = is_null($appId) ? self::appId : $appId;
        $appSecret   = is_null($appSecret) ? self::appSecret : $appSecret;
        //echo $appId,$appSecret;
        $url      = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appId."&secret=".$appSecret;
        $result     = $this->wxHttpsRequest($url);
        //print_r($result);
        $jsoninfo    = json_decode($result, true);
        $access_token  = $jsoninfo["access_token"];
        return $access_token;
    }
 
    /****************************************************
     * 微信通过OPENID获取用户信息，返回数组
     ****************************************************/
 
    public function wxGetUser($openId){
        $wxAccessToken = $this->wxAccessToken();
        $url      = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$wxAccessToken."&openid=".$openId."&lang=zh_CN";
        $result     = $this->wxHttpsRequest($url);
        $jsoninfo    = json_decode($result, true);
        return $jsoninfo;
    }
 
    /****************************************************
     * 微信通过指定模板信息发送给指定用户，发送完成后返回指定JSON数据
     ****************************************************/
 
    public function wxSendTemplate($jsonData){
        $wxAccessToken = $this->wxAccessToken();
        $url      = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$wxAccessToken;
        $result     = $this->wxHttpsRequest($url,$jsonData);
        return $result;
    }
 
    /****************************************************
     *   发送自定义的模板消息
     ****************************************************/
 
    public function wxSetSend($touser, $template_id, $url, $data, $topcolor = '#7B68EE'){
        $template = array(
            'touser' => $touser,
            'template_id' => $template_id,
            'url' => $url,
            'topcolor' => $topcolor,
            'data' => $data
        );
        $jsonData = json_encode($template);
        $result = $this->wxSendTemplate($jsonData);
        return $result;
    }
 
    /****************************************************
     * 微信设置OAUTH跳转URL，返回字符串信息 - SCOPE = snsapi_base //验证时不返回确认页面，只能获取OPENID
     ****************************************************/
 
    public function wxOauthBase($redirectUrl,$state = "",$appId = NULL){
        $appId     = is_null($appId) ? self::appId : $appId;
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appId."&redirect_uri=".$redirectUrl."&response_type=code&scope=snsapi_base&state=".$state."#wechat_redirect";
        return $url;
    }
 
    /****************************************************
     * 微信设置OAUTH跳转URL，返回字符串信息 - SCOPE = snsapi_userinfo //获取用户完整信息
     ****************************************************/
 
    public function wxOauthUserinfo($redirectUrl,$state = "",$appId = NULL){
        $appId     = is_null($appId) ? self::appId : $appId;
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appId."&redirect_uri=".$redirectUrl."&response_type=code&scope=snsapi_userinfo&state=".$state."#wechat_redirect";
        return $url;
    }
 
    /****************************************************
     * 微信OAUTH跳转指定URL
     ****************************************************/
 
    public function wxHeader($url){
        header("location:".$url);
    }
 
    /****************************************************
     * 微信通过OAUTH返回页面中获取AT信息
     ****************************************************/
 
    public function wxOauthAccessToken($code,$appId = NULL , $appSecret = NULL){
        $appId     = is_null($appId) ? self::appId : $appId;
        $appSecret   = is_null($appSecret) ? self::appSecret : $appSecret;
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appId."&secret=".$appSecret."&code=".$code."&grant_type=authorization_code";
        $result     = $this->wxHttpsRequest($url);
        //print_r($result);
        $jsoninfo    = json_decode($result, true);
        //$access_token   = $jsoninfo["access_token"];
        return $jsoninfo;      
    }
 
    /****************************************************
     * 微信通过OAUTH的Access_Token的信息获取当前用户信息 // 只执行在snsapi_userinfo模式运行
     ****************************************************/
 
    public function wxOauthUser($OauthAT,$openId){
        $url      = "https://api.weixin.qq.com/sns/userinfo?access_token=".$OauthAT."&openid=".$openId."&lang=zh_CN";
        $result     = $this->wxHttpsRequest($url);
        $jsoninfo    = json_decode($result, true);
        return $jsoninfo;      
    }
     
    /*****************************************************
     *   生成随机字符串 - 最长为32位字符串
     *****************************************************/
    public function wxNonceStr($length = 16, $type = FALSE) {
      $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      $str = "";
      for ($i = 0; $i < $length; $i++) {
       $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
      }
      if($type == TRUE){
        return strtoupper(md5(time() . $str));
      }
      else {
        return $str;
      }
    }
     
    /*******************************************************
     *   微信商户订单号 - 最长28位字符串
     *******************************************************/
     
    public function wxMchBillno($mchid = NULL) {
      if(is_null($mchid)){
        if(self::mchid == "" || is_null(self::mchid)){
          $mchid = time();
        }
        else{
          $mchid = self::mchid;
        }
      }
      else{
        $mchid = substr(addslashes($mchid),0,10);
      }
      return date("Ymd",time()).time().$mchid;
    }
     
    /*******************************************************
     *   微信格式化数组变成参数格式 - 支持url加密
     *******************************************************/   
     
    public function wxSetParam($parameters){
      if(is_array($parameters) && !empty($parameters)){
        $this->parameters = $parameters;
        return $this->parameters;
      }
      else{
        return array();
      }
    }
     
    /*******************************************************
     *   微信格式化数组变成参数格式 - 支持url加密
     *******************************************************/
     
  public function wxFormatArray($parameters = NULL, $urlencode = FALSE){
      if(is_null($parameters)){
        $parameters = $this->parameters;
      }
      $restr = "";//初始化空
      ksort($parameters);//排序参数
      foreach ($parameters as $k => $v){//循环定制参数
        if (null != $v && "null" != $v && "sign" != $k) {
          if($urlencode){//如果参数需要增加URL加密就增加，不需要则不需要
            $v = urlencode($v);
          }
          $restr .= $k . "=" . $v . "&";//返回完整字符串
        }
      }
      if (strlen($restr) > 0) {//如果存在数据则将最后“&”删除
        $restr = substr($restr, 0, strlen($restr)-1);
      }
      return $restr;//返回字符串
  }
     
    /*******************************************************
     *   微信MD5签名生成器 - 需要将参数数组转化成为字符串[wxFormatArray方法]
     *******************************************************/
    public function wxMd5Sign($content, $privatekey){
    try {
        if (is_null($key)) {
          throw new Exception("财付通签名key不能为空！");
        }
        if (is_null($content)) {
          throw new Exception("财付通签名内容不能为空");
        }
        $signStr = $content . "&key=" . $key;
        return strtoupper(md5($signStr));
      }
      catch (Exception $e)
      {
        die($e->getMessage());
      }
    }
     
    /*******************************************************
     *   微信Sha1签名生成器 - 需要将参数数组转化成为字符串[wxFormatArray方法]
     *******************************************************/
    public function wxSha1Sign($content, $privatekey){
    try {
        if (is_null($key)) {
          throw new Exception("财付通签名key不能为空！");
        }
        if (is_null($content)) {
          throw new Exception("财付通签名内容不能为空");
        }
        $signStr = $content . "&key=" . $key;
        return strtoupper(sha1($signStr));
      }
      catch (Exception $e)
      {
        die($e->getMessage());
      }
    }
 
    /*******************************************************
     *   将数组解析XML - 微信红包接口
     *******************************************************/
     
  public function wxArrayToXml($parameters = NULL){
      if(is_null($parameters)){
        $parameters = $this->parameters;
      }
       
      if(!is_array($parameters) || empty($parameters)){
        die("参数不为数组无法解析");
      }
       
      $xml = "<xml>";
      foreach ($arr as $key=>$val)
      {
        if (is_numeric($val))
        {
          $xml.="<".$key.">".$val."</".$key.">"; 
        }
        else
          $xml.="<".$key."><![CDATA[".$val."]]></".$key.">"; 
      }
      $xml.="</xml>";
      return $xml; 
    }
     
  }
/*后期还是会增加在一起的把这个CLASS做起来，网上资源很多，但是都是有一定基础的人去看看改改可以，对于没有接触刚刚接触的新手还是需要给予支持的。帮助用户屡屡思路。
以上所述就是本文的全部内容了，希望大家能够喜欢。
*/