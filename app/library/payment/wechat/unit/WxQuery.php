<?php
class WxQuery extends ControllerBase{
	
	public function query($OutTradeNo='', $TransactionId=''){
		require_once WECHAT."/lib/WxPay.Api.php";
		
		//微信内部订单查询
		if(isset($TransactionId) && !empty($TransactionId)){
			$input = new WxPayOrderQuery();
			$input->SetTransaction_id($TransactionId);
			
			
			$result = WxPayApi::orderQuery($input);
			return $result;
		}
		
		if(isset($OutTradeNo) && !empty($OutTradeNo)){
			$input = new WxPayOrderQuery();
			$input->SetOut_trade_no($OutTradeNo);
			
			$result = WxPayApi::orderQuery($input);
			return $result;
		}
		
	}
	
}