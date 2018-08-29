<?php
class WxJsApi extends ControllerBase{
	
	public function jsApi($params){
		require_once WECHAT."/lib/WxPay.Api.php";
		
		//参数 indate有效期
		$datas = array(
				'body'=>'', 'attach'=>'', 'order_no'=>'', 'total_fee'=>'',
				'indate'=>1, 'goods_tag'=>'', 'open_id'=>''
		);
		if (is_array($params)){
			$datas['body'] = isset($params['body']) ? $params['body'] : '';
			$datas['attach'] = isset($params['attach']) ? $params['attach'] : '';
			$datas['order_no'] = isset($params['order_no']) ? $params['order_no'] : '';
			$datas['total_fee'] = isset($params['total_fee']) ? floatval($params['total_fee']) : '';
			$datas['indate'] = isset($params['indate']) ? floatval($params['indate']) : '';
			$datas['goods_tag'] = isset($params['goods_tag']) ? $params['goods_tag'] : '';
			$datas['open_id'] = isset($params['open_id']) ? $params['open_id'] : '';
			
			if (!$datas['body'] || !$datas['order_no'] || !$datas['total_fee']) return 'ParamErr';
		}else return 'ParamNotArray';
		
		$openId = $datas['open_id']?$datas['open_id']:$this->GetOpenid();
		
		$input = new WxPayUnifiedOrder();
		$input->SetBody($datas['body']);
		$input->SetAttach($datas['attach']);
		$input->SetOut_trade_no($datas['order_no']);
		$input->SetTotal_fee($datas['total_fee']);
		$input->SetTime_start(date("YmdHis"));
		//$input->SetTime_expire(date("YmdHis", time() + $datas['indate']*60));
		$input->SetGoods_tag($datas['goods_tag']);
		$input->SetNotify_url("https://wx.yingyuncn.com/ApiPayment/notify");
		//$input->SetNotify_url("http://x.viphk.ngrok.org/MicroMail/ApiPayment/notify");
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($openId);
		$order = WxPayApi::unifiedOrder($input);
		
		//$jsApiParameters = $this->GetJsApiParameters($order);
		
		//获取共享收货地址js函数参数
		//$editAddress = $this->GetEditAddressParameters();
		
		return $order;
	}
	
	/**
	 *
	 * 网页授权接口微信服务器返回的数据，返回样例如下
	 * {
	 *  "access_token":"ACCESS_TOKEN",
	 *  "expires_in":7200,
	 *  "refresh_token":"REFRESH_TOKEN",
	 *  "openid":"OPENID",
	 *  "scope":"SCOPE",
	 *  "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
	 * }
	 * 其中access_token可用于获取共享收货地址
	 * openid是微信支付jsapi支付接口必须的参数
	 * @var array
	 */
	public $data = null;
	
	/**
	 *
	 * 通过跳转获取用户的openid，跳转流程如下：
	 * 1、设置自己需要调回的url及其其他参数，跳转到微信服务器https://open.weixin.qq.com/connect/oauth2/authorize
	 * 2、微信服务处理完成之后会跳转回用户redirect_uri地址，此时会带上一些参数，如：code
	 *
	 * @return 用户的openid
	 */
	public function GetOpenid()
	{
		WxPayConfig::initPayInfo('zzyh-gzh');
		//通过code获得openid
		if (!isset($_GET['code'])){
			//触发微信返回code码
			$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
			$baseUrl = urlencode($http_type.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING']);
			$url = $this->__CreateOauthUrlForCode($baseUrl);
			header("Location: $url");
			//$this->response->redirect($url);
			exit();
		} else {
			//获取code码，以获取openid
			$code = $_GET['code'];
			$openid = $this->getOpenidFromMp($code);
			return $openid;
		}
	}
	
	/**
	 *
	 * 获取jsapi支付的参数
	 * @param array $UnifiedOrderResult 统一支付接口返回的数据
	 * @throws WxPayException
	 *
	 * @return json数据，可直接填入js函数作为参数
	 */
	public function GetJsApiParameters($UnifiedOrderResult)
	{
		if(!array_key_exists("appid", $UnifiedOrderResult)
				|| !array_key_exists("prepay_id", $UnifiedOrderResult)
				|| $UnifiedOrderResult['prepay_id'] == "")
		{
			throw new WxPayException("参数错误");
		}
		$jsapi = new WxPayJsApiPay();
		$jsapi->SetAppid($UnifiedOrderResult["appid"]);
		$timeStamp = time();
		$jsapi->SetTimeStamp("$timeStamp");
		$jsapi->SetNonceStr(WxPayApi::getNonceStr());
		$jsapi->SetPackage("prepay_id=" . $UnifiedOrderResult['prepay_id']);
		$jsapi->SetSignType("MD5");
		$jsapi->SetPaySign($jsapi->MakeSign());
		$parameters = json_encode($jsapi->GetValues());
		return $parameters;
	}
	
	/**
	 *
	 * 通过code从工作平台获取openid机器access_token
	 * @param string $code 微信跳转回来带上的code
	 *
	 * @return openid
	 */
	public function GetOpenidFromMp($code)
	{
		$url = $this->__CreateOauthUrlForOpenid($code);
		//初始化curl
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, 7200);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		if(WxPayConfig::$curlProxyHost != "0.0.0.0"
				&& WxPayConfig::$curlProxyPort != 0){
					curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::$curlProxyHost);
					curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::$curlProxyPort);
		}
		//运行curl，结果以jason形式返回
		$res = curl_exec($ch);
		curl_close($ch);
		//取出openid
		$data = json_decode($res,true);
		$this->data = $data;
		$openid = $data['openid'];
		return $openid;
	}
	
	/**
	 *
	 * 拼接签名字符串
	 * @param array $urlObj
	 *
	 * @return 返回已经拼接好的字符串
	 */
	private function ToUrlParams($urlObj)
	{
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			if($k != "sign"){
				$buff .= $k . "=" . $v . "&";
			}
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}
	
	/**
	 *
	 * 获取地址js参数
	 *
	 * @return 获取共享收货地址js函数需要的参数，json格式可以直接做参数使用
	 */
	public function GetEditAddressParameters()
	{
		$getData = $this->data;
		$data = array();
		$data["appid"] = WxPayConfig::$appid;
		$data["url"] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$time = time();
		$data["timestamp"] = "$time";
		$data["noncestr"] = "1234568";
		$data["accesstoken"] = $getData["access_token"];
		ksort($data);
		$params = $this->ToUrlParams($data);
		$addrSign = sha1($params);
		
		$afterData = array(
				"addrSign" => $addrSign,
				"signType" => "sha1",
				"scope" => "jsapi_address",
				"appId" => WxPayConfig::$appid,
				"timeStamp" => $data["timestamp"],
				"nonceStr" => $data["noncestr"]
		);
		$parameters = json_encode($afterData);
		return $parameters;
	}
	
	/**
	 *
	 * 构造获取code的url连接
	 * @param string $redirectUrl 微信服务器回跳的url，需要url编码
	 *
	 * @return 返回构造好的url
	 */
	private function __CreateOauthUrlForCode($redirectUrl)
	{
		$urlObj["appid"] = WxPayConfig::$appid;
		$urlObj["redirect_uri"] = "$redirectUrl";
		$urlObj["response_type"] = "code";
		//$urlObj["scope"] = "snsapi_base";
		$urlObj["scope"] = "snsapi_userinfo";
		$urlObj["state"] = "STATE"."#wechat_redirect";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
	}
	
	/**
	 *
	 * 构造获取open和access_toke的url地址
	 * @param string $code，微信跳转带回的code
	 *
	 * @return 请求的url
	 */
	private function __CreateOauthUrlForOpenid($code)
	{
		$urlObj["appid"] = WxPayConfig::$appid;
		$urlObj["secret"] = WxPayConfig::$secret;
		$urlObj["code"] = $code;
		$urlObj["grant_type"] = "authorization_code";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
	}
}