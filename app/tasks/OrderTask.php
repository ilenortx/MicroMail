<?php

/**
 * 订单任务
 * @author xiao
 *
 */
class OrderTask extends TaskBase{
	
	public function mainAction() {
		$this->sections = 'order';
		
		if ($this->taskVerify()){
			self::autoReceiving();//自动收货
			
			$this->reLetime(time());
		}
	}
	
	//----------
	// 自动收货
	//----------
	private function autoReceiving(){
		$ar = Order::autoReceiving(15);
	}
	
}