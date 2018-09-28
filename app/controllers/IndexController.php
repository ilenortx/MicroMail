<?php

//require_once PAYMENT."/wechat/lib/WxPay.Config.php";
class IndexController extends ControllerBase
{

	public function tttAction(){
		$this->view->disable();
		$this->assets
			 ->addJs("lib/jquery/1.9.1/jquery.min.js")
			 ->addJs("lib/print/print.js");
		
		/* $this->view->ip = $this->get_ip();
		$this->view->pick("index/index"); */
			 echo $this->get_ip();
	}
	
	/**
	 * 判断是否为内网IP
	 * @param ip IP
	 * @return 是否内网IP
	 */
	function is_private_ip($ip) {
		return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
	}
	
	/**
	 * 获取客户端IP(非用户服务器IP)
	 * @return 客户端IP
	 */
	//不同环境下获取真实的IP
	function get_ip(){
		//判断服务器是否允许$_SERVER
		if(isset($_SERVER)){
			if(isset($_SERVER[HTTP_X_FORWARDED_FOR])){
				$realip = $_SERVER[HTTP_X_FORWARDED_FOR];
			}elseif(isset($_SERVER[HTTP_CLIENT_IP])) {
				$realip = $_SERVER[HTTP_CLIENT_IP];
			}else{
				$realip = $_SERVER[REMOTE_ADDR];
			}
		}else{
			//不允许就使用getenv获取
			if(getenv("HTTP_X_FORWARDED_FOR")){
				$realip = getenv( "HTTP_X_FORWARDED_FOR");
			}elseif(getenv("HTTP_CLIENT_IP")) {
				$realip = getenv("HTTP_CLIENT_IP");
			}else{
				$realip = getenv("REMOTE_ADDR");
			}
		}
		
		return $realip;
	}
	
	
	
	
    public function indexAction(){
    	$this->view->disable();
		
    	$sampleData = array(
    			'zzyh-xcx' => array(
    					'appid'		=> 'wxdf13b6ed712b9248',
    					'mchid' 	=> '1494649292',
    					'key' 		=> 'sdfhnjk9w23ufkaSJF23jfksjadfklja',
    					'secret'	=> '1c2cf72abd7d6c3f1058925dc21e6ff1',
    					
    					'sslcertPath' => 'E:\webroot\MicroMail\app\library\payment\wechat\cert/apiclient_cert.pem',
    					'sslkeyPath' => 'E:\webroot\MicroMail\app\library\payment\wechat\cert/apiclient_key.pem',
    					
    					'curlProxyHost' => '0.0.0.0',
    					'curlProxyPort' => '0',
    					'reportLevenl' => 1,
    			),
    			'zzyh-gzh' => array(
    					'appid'		=> 'wxaa31ca9ad5395e09',
    					'mchid' 	=> '1494649292',
    					'key' 		=> 'sdfhnjk9w23ufkaSJF23jfksjadfklja',
    					'secret'	=> 'f50db5476d83b1b78813815cab32aead',
    					
    					'sslcertPath' => 'E:\webroot\MicroMail\app\library\payment\wechat\cert/apiclient_cert.pem',
    					'sslkeyPath' => 'E:\webroot\MicroMail\app\library\payment\wechat\cert/apiclient_key.pem',
    					
    					'curlProxyHost' => '0.0.0.0',
    					'curlProxyPort' => '0',
    					'reportLevenl' => 1,
    			));  
    	//$x = IniFileOpe::writeIniFile($sampleData, PAYMENT.'/wechat/config.ini', true);
    	
    	//$data = IniFileOpe::getIniFile(PAYMENT.'/wechat/config.ini','zzyh-gzh');
    	//$data['second-5'] = '55';
    	//IniFileOpe::reinitFile('./test.ini', $data,'second');
    	//var_dump($data);
    	
    }
    
    public function testAction(){
    	$datas = array(
    			'body'=>'ggfdfghg', 'attach'=>'', 'order_no'=>date("YmdHis"), 'total_fee'=>1,
    			'indate'=>1, 'goods_tag'=>'', 'product_id'=>'123456789'
    	);
    	//WxPayConfig::$appid = "wxdf13b6ed712b9248";
    	//WxPayConfig::initPayInfo('zzyh-gzh');
    	echo $datas['order_no'];
    	$wn = new WxCode();
    	$code = $wn->getCode($datas);
    	echo $code;
    	
    	echo "<img alt='模式二扫码支付' src='http://paysdk.weixin.qq.com/example/qrcode.php?data={$code}' style='width:150px;height:150px;'/>";
    	
    }
    
    public function refundAction(){
    	$this->view->disable();
    	$this->view->enable();
    	$wr = new WxRefund();
    	$xx = '0.01';
    	$wr->refund(array('totalFee'=>$xx*100, 'refundFee'=>$xx*100), '2018083051101995381');
    	
    }
    
    public function test1Action(){
    	$tools = new WxJsApi();
    	
    	$order = $tools->GetOpenid();
    	
    	echo "sdfasd";
    	
    }
    
    public function test2Action(){
    	
    	$this->view->setVar("title", "专致优货");
    	$this->view->setVar("isBasePage", false);
    	$this->view->setTemplateAfter('wapApp');
    	$this->assets
    	->addCss("css/mui/mui.css")
    	->addCss("css/mui/icon.css")
    	->addCss("css/wapApp/index/index.css")
    	->addCss("css/wapApp/swiper.min.css")
    	->addJs("lib/jquery/1.9.1/jquery.min.js")
    	->addJs("js/mui/mui.js");
    	$this->view->pick('wapApp/test');
    	
    }
    
}

