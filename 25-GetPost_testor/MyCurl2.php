<?php
/**=============================================
 * MyCurl Class
 *
 * 封装好的curll2类。===专用抓取数据用的
 * 类名时驼峰法，方法名是下划线法。
 * 请求接口用。支持http和https,支持get和post。
 *
 * @version		v1.0.5
 * @revise		2016.12.26
 * @date		2015.10.08
 * @author		Dawn
 * @email		JimmyMall@live.com
 * @link		https://github.com/DawnEve/DawnPHPTools
 =============================================*/
class MyCurl2{
	private $headers=array();
	public function _request($curl,$https=true,$method='get',$data='null'){
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $curl);
		
		curl_setopt($ch, CURLOPT_HEADER, false);//是否需要头部 
		//CURLOPT_HEADER与CURLOPT_HTTPHEADER的区别？
		/*
			http://pcwanli.blog.163.com/blog/static/45315611201363121659760
		*/
		
		
		$this->headers[] = 'Accept: */*'; 
		//$this->headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg'; //如果请求图片的话
		$this->headers[] = "X-Requested-With: XMLHttpRequest"; 
		$this->headers[] = "Accept-Language: zh-CN,zh;q=0.8,en;q=0.6"; 
			//  "Accept-Language: en-us,en;q=0.5";  //英文状态
		//$this->headers[] = "Accept-Encoding: gzip, deflate, sdch" ; //如果不支持压缩却承认会压缩，会乱码
		$this->headers[] = 'Connection: Keep-Alive'; 
		$this->headers[] = 'Content-type: application/x-www-form-urlencoded;CHARSET=utf8'; 
			//"Content-type: application/json" //请求json格式数据
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//是否转发到变量，否则输出
		
		//curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieText);
		//curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieText);
		
				
		//$this->user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)'; 
		//curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36");
		//curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36");
		
		curl_setopt($ch, CURLOPT_REFERER, "http://shop.xingyuan58.com");
		if($https){
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			//curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,true);
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);
			//CURLOPT_SSL_VERIFYHOST no longer accepts the value 1, value 2 will be used instead
		}
		
		if($method=='POST'){
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);//传输的值
		}
		$content=curl_exec($ch);
		curl_close($ch);
		return $content;
	}
}
/*
$curl=new MyCurl();
//访问百度首页
echo $curl->_request('https://www.baidu.com',true);


$post_data = array ("username" => "bob","key" => "12345");

*/