<?php

/**
 * 搜索接口
 * @author xiao
 *
 */
class ApisearchController extends ApiBase{

    public function indexAction(){
		if ($this->request->isPost()){
			$code = isset($_POST['code']) ? $_POST['code'] : '';
			$shopId = isset($_POST['shop_id']) ? intval($_POST['shop_id']) : '';
			
			if (!$code){
				echo json_encode(array('status'=>0, 'err'=>'数据异常'));
				exit();
			}
			
			if (empty($shopId)) $pros = Product::find("del=0 and is_down=0 and name like '%$code%'");
			else $pros = Product::find("del=0 and is_down=0 and shop_id=$shopId and name like '%$code%'");
			$proArr = array();
			
			if ($pros) $proArr = $pros->toArray();
			echo json_encode(array('status'=>1, 'pros'=>$proArr));
		}else {
			echo json_encode(array('status'=>0, 'err'=>'请求方式错误'));
			exit();
		}
    }

}

