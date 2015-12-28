<?php
/**=============================================
 * MyCurl Class
 *
 * 封装好的curll2类。===专用抓取数据用的
 * 类名时驼峰法，方法名是下划线法。
 * 请求接口用。支持http和https,支持get和post。
 *
 * @version		v1.0.4
 * @revise		2015.12.27
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
		
		
		$cookieText='param_history=a"%"3A17"%"3A"%"7Bs"%"3A1"%"3A"%"22r"%"22"%"3Bs"%"3A26"%"3A"%"22domaintrade"%"2Fhistoryoftrade"%"22"%"3Bs"%"3A12"%"3A"%"22overtime_low"%"22"%"3Bs"%"3A10"%"3A"%"222015-12-01"%"22"%"3Bs"%"3A12"%"3A"%"22overtime_top"%"22"%"3Bs"%"3A10"%"3A"%"222015-12-10"%"22"%"3Bs"%"3A4"%"3A"%"22have"%"22"%"3Bs"%"3A0"%"3A"%"22"%"22"%"3Bs"%"3A9"%"3A"%"22foreclose"%"22"%"3Bs"%"3A0"%"3A"%"22"%"22"%"3Bs"%"3A14"%"3A"%"22againforeclose"%"22"%"3Bs"%"3A0"%"3A"%"22"%"22"%"3Bs"%"3A4"%"3A"%"22type"%"22"%"3Bs"%"3A0"%"3A"%"22"%"22"%"3Bs"%"3A10"%"3A"%"22min_length"%"22"%"3Bs"%"3A0"%"3A"%"22"%"22"%"3Bs"%"3A10"%"3A"%"22max_length"%"22"%"3Bs"%"3A0"%"3A"%"22"%"22"%"3Bs"%"3A7"%"3A"%"22dom_ext"%"22"%"3Bs"%"3A0"%"3A"%"22"%"22"%"3Bs"%"3A6"%"3A"%"22p_type"%"22"%"3Bs"%"3A0"%"3A"%"22"%"22"%"3Bs"%"3A14"%"3A"%"22p_topmoney_low"%"22"%"3Bs"%"3A0"%"3A"%"22"%"22"%"3Bs"%"3A14"%"3A"%"22p_topmoney_top"%"22"%"3Bs"%"3A0"%"3A"%"22"%"22"%"3Bs"%"3A5"%"3A"%"22_csrf"%"22"%"3Bs"%"3A56"%"3A"%"22Z3F6c0FUTkNVF1cmMiYFEC48CRoNZigmXwceEQw2fjZTEBEUcC4rNQ"%"3D"%"3D"%"22"%"3Bs"%"3A3"%"3A"%"22hit"%"22"%"3Bs"%"3A1"%"3A"%"221"%"22"%"3Bs"%"3A4"%"3A"%"22page"%"22"%"3Bs"%"3A1"%"3A"%"221"%"22"%"3Bs"%"3A8"%"3A"%"22pagesize"%"22"%"3Bs"%"3A2"%"3A"%"2250"%"22"%"3B"%"7D; _csrf=8b8d4c1f5ce1410b20c5e1d2f02fa26e3326642fb7f8a17866a92f7b0fada6c4a"%"3A2"%"3A"%"7Bi"%"3A0"%"3Bs"%"3A5"%"3A"%"22_csrf"%"22"%"3Bi"%"3A1"%"3Bs"%"3A32"%"3A"%"222f-UsrKSIMsiL2fe8vdbMb0u4akg1zev"%"22"%"3B"%"7D; ASPSESSIONIDSCSBTSAS=IIHGKCDDOECGPENCNDDIGEMD; ads_n_tongji_ftime=2015-12-26"%"2020"%"3A56"%"3A55; ASPSESSIONIDSAQCRQBS=JLOIDBKDOBOBMAJDAKOJMGBC; menu_index=1; 53kf_953501_keyword=; kf_953501_keyword_ok=1; onliner_zdfq953501=0; _jzqa=1.3390163297430368000.1451185531.1451185531.1451185531.1; _jzqc=1; _jzqckmp=1; kfmenunewbox_state=open; _qzja=1.215947914.1451185531121.1451185531121.1451185531122.1451185531121.1451185531122.0.0.0.1.1; _qzjc=1; _qzjto=1.1.0; invite_53kf_totalnum_1=1; www_west_cn_=1; ads_n_tongji_ads_pre=; Hm_lvt_d0e33fc3fbfc66c95d9fdcc4c93a8288=1451139941,1451140090,1451140547,1451185164; Hm_lpvt_d0e33fc3fbfc66c95d9fdcc4c93a8288=1451189980; PHPSESSID=8egbcragfklplc0kata541vkl5';
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieText);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieText);
		
				
		//$this->user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)'; 
		//curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36");
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
		
		curl_setopt($ch, CURLOPT_REFERER, "http://www.west.cn/web/domaintrade/historyoftrade");

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

*/
