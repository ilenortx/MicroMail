<?php
class WxRefund extends ControllerBase{
	
	/**
	 * 
	 * @param unknown $datas (totalFee, refundFee, refundDesc)
	 * @param string $OutTradeNo
	 * @param string $TransactionId
	 * @return 成功时返回，其他抛异常
	 */
	public function refund($datas, $OutTradeNo='', $TransactionId=''){
		require_once WECHAT."/lib/WxPay.Api.php";
		//微信内部订单退款
		if(isset($TransactionId) && !empty($TransactionId)){
			$input = new WxPayRefund();
			$input->SetTransaction_id($TransactionId);
			$input->SetOut_refund_no(WxPayConfig::$mchid.date("YmdHis"));
			$input->SetTotal_fee($datas['totalFee']);
			$input->SetRefund_fee($datas['refundFee']);
			$input->SetOp_user_id(WxPayConfig::$mchid);
			
			$result = WxPayApi::refund($input);
			return $result;
		}
		
		if(isset($OutTradeNo) && !empty($OutTradeNo)){
			$input = new WxPayRefund();
			$input->SetOut_trade_no($OutTradeNo);
			$input->SetOut_refund_no(WxPayConfig::$mchid.date("YmdHis"));
			$input->SetTotal_fee($datas['totalFee']);
			$input->SetRefund_fee($datas['refundFee']);
			$input->SetOp_user_id(WxPayConfig::$mchid);
			
			$result = WxPayApi::refund($input);
			return $result;
		}
	}
	
	/**
	 * 退款查询
	 */
	public function refundQuery($OutTradeNo='', $TransactionId=''){
		require_once WECHAT."/lib/WxPay.Api.php";
		
		//微信内部订单退款查询
		if(isset($TransactionId) && !empty($TransactionId)){
			$input = new WxPayRefundQuery();
			$input->SetTransaction_id($TransactionId);
			
			$result = WxPayApi::refundQuery($input);
			return $result;
		}
		
		if(isset($OutTradeNo) && !empty($OutTradeNo)){
			$input = new WxPayRefundQuery();
			$input->SetOut_trade_no($OutTradeNo);
			
			$result = WxPayApi::refundQuery($input);
			return $result;
		}
	}
	
}