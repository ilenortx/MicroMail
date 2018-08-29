<?php

class WxCode extends ControllerBase{
	public function getCode($params){
		require_once WECHAT."/lib/WxPay.Api.php";
		
		//参数 indate有效期 最小为1(1分钟)
		$datas = array(
				'body'=>'', 'attach'=>'', 'order_no'=>'', 'total_fee'=>'', 
				'indate'=>1, 'goods_tag'=>'', 'product_id'=>'123456789'
		);
		if (is_array($params)){
			$datas['body'] = isset($params['body']) ? $params['body'] : '';
			$datas['attach'] = isset($params['attach']) ? $params['attach'] : '';
			$datas['order_no'] = isset($params['order_no']) ? $params['order_no'] : '';
			$datas['total_fee'] = isset($params['total_fee']) ? floatval($params['total_fee']) : '';
			$datas['indate'] = isset($params['indate']) ? floatval($params['indate']) : '';
			$datas['goods_tag'] = isset($params['goods_tag']) ? $params['goods_tag'] : '';
			$datas['product_id'] = isset($params['product_id']) ? $params['product_id'] : '';
			
			if (!$datas['body'] || !$datas['order_no'] || !$datas['total_fee']
					|| $datas['indate']<=0) return 'ParamErr';
		}else return 'ParamNotArray';
		
		$input = new WxPayUnifiedOrder();
		$input->SetBody($datas['body']);
		$input->SetAttach($datas['attach']);
		$input->SetOut_trade_no($datas['order_no']);
		$input->SetTotal_fee($datas['total_fee']);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + $datas['indate']*60));
		$input->SetGoods_tag($datas['goods_tag']);
		$input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
		$input->SetTrade_type("NATIVE");
		$input->SetProduct_id($datas['product_id']);
		
		$result = $this->GetPayUrl($input);
		
		$codeUrl = $result["code_url"];
		
		return $codeUrl;
	}
	
	/**
	 *
	 * 生成扫描支付URL,模式一
	 * @param BizPayUrlInput $bizUrlInfo
	 */
	public function GetPrePayUrl($productId){
		$biz = new WxPayBizPayUrl();
		$biz->SetProduct_id($productId);
		$values = WxpayApi::bizpayurl($biz);
		$url = "weixin://wxpay/bizpayurl?" . $this->ToUrlParams($values);
		return $url;
	}
	
	/**
	 *
	 * 参数数组转换为url参数
	 * @param array $urlObj
	 */
	private function ToUrlParams($urlObj){
		$buff = "";
		foreach ($urlObj as $k => $v){
			$buff .= $k . "=" . $v . "&";
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}
	
	/**
	 *
	 * 生成直接支付url，支付url有效期为2小时,模式二
	 * @param UnifiedOrderInput $input
	 */
	public function GetPayUrl($input){
		if($input->GetTrade_type() == "NATIVE"){
			$result = WxPayApi::unifiedOrder($input);
			return $result;
		}
	}
}
?>
