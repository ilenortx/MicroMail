<?php
class WxCloseOrder extends ControllerBase{
	
	public function close($OutTradeNo=''){
		require_once WECHAT."/lib/WxPay.Api.php";
		
		if(isset($OutTradeNo) && !empty($OutTradeNo)){
			$input = new WxPayCloseOrder();
			$input->SetOut_trade_no($OutTradeNo);
			
			$result = WxPayApi::closeOrder($input);
			return $result;
		}else return 'NullOutTradeNo';
	}
	
}