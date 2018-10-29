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
			self::backOrder(); // 过期订单
			
			$this->reLetime(time());
		}
	}
	
	//----------
	// 自动收货
	//----------
	private function autoReceiving(){
		$ar = Order::autoReceiving(15);
	}
	
	/**
	 * 清除过期订单
	 */
	private function backOrder(){
		$orders = Order::backOrder();
		
		if (ModelBase::isObject($orders)){
			foreach ($orders as $k=>$v){
				$v->status = 0; $v->save();
			}
		}
	}
	
}