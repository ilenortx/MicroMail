<?php

/**
 * 秒杀接口
 * @author xiao
 *
 */
class ApiPromotionController extends ApiBase{

	/**
	 * 获取秒杀列表
	 */
	public function skListAction(){
		if ($this->request->isPost()){
			$shopId = isset($_POST['shop_id']) ? intval($_POST['shop_id']) : 'all';
			$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
			
			$ab = new ActivityBase();
			$skArr = $ab->allPromotion($shopId, 10, $offset);
			
			echo json_encode(array('status'=>1, 'sklist'=>$skArr));
		}
	}
	
}

