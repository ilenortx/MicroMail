<?php

class JSSDK {
	private $appId;
	private $appSecret;

	public function __construct($appId, $appSecret) {
		$this->appId = $appId;
		$this->appSecret = $appSecret;
	}

	public function getSignPackage() {
		$jsapiTicket = $this->getJsApiTicket();
		$url = $_POST['url'];
		$timestamp = time();
		$nonceStr = $this->createNonceStr();

		// 这里参数的顺序要按照 key 值 ASCII 码升序排序

		$string = "jsapi_ticket={$jsapiTicket}&noncestr={$nonceStr}&timestamp={$timestamp}&url={$url}";

		$signature = sha1($string);

		$signPackage = array(
				"appId"     => $this->appId,
				"nonceStr"  => $nonceStr,
				"timestamp" => $timestamp,
				"url"       => $url,
				"signature" => $signature,
				"rawString" => $string
		);
		return $signPackage;
	}

	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}

	private function getJsApiTicket() {
		// jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
		if (file_exists('./temp/jsapi_ticket.json')){
			$data = json_decode(file_get_contents("./temp/jsapi_ticket.json"));
			if ($data->expire_time < time()) {
				$ticket = $this->gjat();
			} else {
				$ticket = $data->jsapi_ticket;
			}
		}else $ticket = $this->gjat();

		return $ticket;
	}
	private function gjat(){
		$accessToken = $this->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
		$res = json_decode($this->httpGet($url));
		$ticket = $res->ticket;
		if ($ticket) {
			$data['expire_time'] = time() + 7000;
			$data['jsapi_ticket'] = $ticket;
			$fp = fopen("./temp/jsapi_ticket.json", "w");
			fwrite($fp, json_encode($data));
			fclose($fp);
		}
		return $ticket;
	}

	private function getAccessToken() {
		// access_token 应该全局存储与更新，以下代码以写入到文件中做示例
		if(file_exists('./temp/access_token.json')){
			$data = json_decode(file_get_contents("./temp/access_token.json"));
			if ($data->expire_time < time()) {
				$access_token = $this->gat();
			} else {
				$access_token = $data->access_token;
			}
		}else $access_token = $this->gat();

		return $access_token;
	}
	private function gat(){
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
		$res = json_decode($this->httpGet($url));
		$access_token = $res->access_token;
		if ($access_token) {
			$data['expire_time'] = time() + 7000;
			$data['access_token'] = $access_token;
			$fp = fopen("./temp/access_token.json", "w");
			fwrite($fp, json_encode($data));
			fclose($fp);
		}
		return $access_token;
	}

	private function httpGet($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 15000);

		$res = curl_exec($curl);
		curl_close($curl);

		return $res;
	}
}