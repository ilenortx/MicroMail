<?php

/**
 * 购物车接口
 * @author xiao
 *
 */
class ApishoppingController extends ApiBase{

	/**
	 * 购物车首页数据
	 */
    public function indexAction(){
    	
    	if ($this->request->isPost()){
    		$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : '';
    		if (!$user_id){
    			echo json_encode(array('status'=>0,'err'=>'登录状态异常.'));
    			exit();
    		}
    		
    		//查询所有店铺
    		$shops = Shangchang::find(array(
    				'conditions'=> "status=?1",
    				'bind'		=> array(1=>1),
    				'columns'	=> 'id,name'
    		));
    		if ($shops){
    			$shops = $shops->toArray();
    			$shopArr = array();
    			foreach ($shops as $k=>$v){
    				$shopArr[$v['id']]['shop_id'] = $v['id'];
    				$shopArr[$v['id']]['shop_name'] = $v['name'];
    				$shopArr[$v['id']]['shop_pros'] = array();
    			}
    			
    			$cart = ShoppingChar::find(array(
    					'conditions'=> 'uid=?1',
    					'bind'		=> array(1=>$user_id),
    					'columns'	=> 'id,uid,pid,price,num,shop_id,skuid',
    					'order'		=> "addtime desc,pid desc"
    			));
    			
    			if ($cart){
    				$cart = $cart->toArray();
    				
    				foreach ($cart as $k => $v) {
    					if (isset($shopArr[$v['shop_id']])){
    						$pro_info = Product::findFirst(array(
    								'conditions'=> 'id=?1',
    								'bind'		=> array(1=>intval($v['pid']))
    						));
    						if ($pro_info){
    							$pro_info = $pro_info->toArray();
    							
    							$attrstr = '';
    							if (trim($v['skuid'], ',')){
    								$sb = new SkuBase();
    								$sta = $sb->skuToAttrs(trim($v['skuid'], ','));
    								foreach ($sta as $k1=>$v1){
    									$attrstr.= $v1['pname'].': '.$v1['name'].'   ';
    								}
    							}
    							
    							$cart[$k]['pro_name'] = $pro_info['name'];
    							$cart[$k]['photo_x'] = $pro_info['photo_x'];
    							$cart[$k]['hd_type'] = $pro_info['hd_type'];
    							$cart[$k]['hd_id'] = $pro_info['hd_id'];
    							$cart[$k]['attrs'] = $attrstr;
    							if ($pro_info['hd_type']=='1' && intval($pro_info['hd_id'])){
    								$ab = new ActivityBase();
    								$pi = $ab->promotion(intval($pro_info['hd_id']));
    								if (count($pi)){
    									$cart[$k]['price'] = $pi['pprice'];
    								}
    							}
    							
    							array_push($shopArr[$v['shop_id']]['shop_pros'], $cart[$k]);
    						}
    					}
    				}
    				
    				foreach ($shopArr as $k=>$v){
    					if (count($v['shop_pros']) == 0) unset($shopArr[$k]);
    				}
    				echo json_encode(array('status'=>1, 'cart'=>$shopArr));
    				exit();
    			}else {
    				echo json_encode(array('status'=>0, 'err'=>'购物车为空'));
    				exit();
    			}
    		}else {
    			echo json_encode(array('status'=>0, 'err'=>'数据错误'));
    			exit();
    		}
    	}else {
    		echo json_encode(array('status'=>0, 'err'=>'请求方式错误'));
    		exit();
    	}
    }
    
    /**
     * 加入购物车
     */
    public function addAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['uid']) ? $_POST['uid'] : '';
    		$pid = isset($_POST['pid']) ? $_POST['pid'] : '';
    		$num = isset($_POST['num']) ? $_POST['num'] : '';
    		$skuid = isset($_POST['skuid']) ? trim($_POST['skuid'], ',') : '';
    		
    		if (!$uid){
    			echo json_encode(array('status'=>0,'err'=>'登录状态异常.'));
    			exit();
    		}
    		if (!$pid || !$num){
    			echo json_encode(array('status'=>0,'err'=>'参数错误.'));
    			exit();
    		}
    		
    		//加入购物车
    		$check = $this->checkCartAction(intval($pid), $skuid);
    		if ($check['status']==0) {
    			echo json_encode(array('status'=>0,'err'=>$check['err']));
    			exit;
    		}
    		$check_info = $check['pro'];
    		
    		$stock = intval($check_info['num']);
    		$sku = self::getSku($skuid, intval($pid));
    		//判断库存
    		if ($sku){
    			$stock = intval($sku['stock']);
    			$check_info['price_yh'] = $sku['price'];
    		}
    		if ($stock < $num) {
    			echo json_encode(array('status'=>0,'err'=>'库存不足！'));
    			exit;
    		}
    		
    		//判断购物车内是否已经存在该商品
    		$data = array();
    		$condition = array(
    				'conditions'=> 'pid=?1 and uid=?2',
    				'bind'		=>	array(1=>$pid, 2=>$uid)
    		);
    		if ($sku){//获取sku属性
    			$condition['conditions'] .= " and skuid=?3";
    			$condition['bind'][3] = $skuid;
    		}
    		$cart_info = ShoppingChar::findFirst($condition);
    		if ($cart_info) {
    			$cartInfo = $cart_info->toArray();
    			$data['num'] = intval($cartInfo['num'])+intval($num);
    			//判断库存
    			if ($stock<=$data['num']) {
    				echo json_encode(array('status'=>0,'err'=>'库存不足！'));
    				exit;
    			}
//     			$addshpp = ShoppingChar::findFirst(array(
//     					'conditions'=> 'id=?1',
//     					'bind'		=>	array(1=>$cart_info['id'])
//     			));
    			$addshpp = $cart_info;
    			$addshpp->num = $data['num'];
    			$addshpp->save();
    			$res = $addshpp->id;
    		}else{
    			$ptype = 1;
    			if (intval($check_info['pro_type'])) {
    				$ptype = intval($check_info['pro_type']);
    			}
    			
    			$addshpp = new ShoppingChar();
    			$addshpp->pid 		= intval($pid);
    			$addshpp->num 		= intval($num);
    			$addshpp->addtime	= time();
    			$addshpp->uid 		= intval($uid);
    			$addshpp->skuid		= $skuid;
    			$addshpp->shop_id	= intval($check_info['shop_id']);
    			$addshpp->type		= $ptype;
    			$addshpp->price		= $check_info['price_yh'];
    			
    			$xx = $addshpp->save();
    			$res = $addshpp->id;
    		}
    		
    		if($res){
    			echo json_encode(array('status'=>1,'cart_id'=>$res)); //该商品已成功加入您的购物车
    			exit;
    		}else{
    			echo json_encode(array('status'=>0,'err'=>'加入失败.'));
    			exit;
    		}
    	}else {
    		echo json_encode(array('status'=>0,'err'=>'请求方式错误.'));
    		exit;
    	}
    }

    //***************************
    //  会员修改购物车数量接口
    //***************************
    public function upCartAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['user_id']) ? intval($_POST['user_id']) : '';
    		$cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : '';
    		$num = isset($_POST['num']) ? intval($_POST['num']) : '';
    		$skuid = isset($_POST['skuid']) ? trim($_POST['skuid'], ',') : '';
    		
    		if (!$uid || !$cart_id || !$num) {
    			echo json_encode(array('status'=>0,'err'=>'网络异常.'.__LINE__));
    			exit();
    		}
    		
    		$check = ShoppingChar::findFirstById($cart_id);
    		if (!$check) {
    			echo json_encode(array('status'=>0,'err'=>'购物车信息错误！'));
    			exit();
    		}
    		$check = $check->toArray();
    		
    		//检测库存
    		$pro_num = Product::findFirstById(intval($check['pid']));
    		$pro_num = $pro_num->toArray();
    		$stock = intval($pro_num['num']);
    		$sku = self::getSku($skuid, intval($check['pid']));
    		if ($skuid){
    			$stock = intval($sku['stock']);
    		}
    		if ($stock < $num) {
    			echo json_encode(array('status'=>0,'err'=>'库存不足！'));
    			exit;
    		}
    		
    		$check = ShoppingChar::findFirstById($cart_id);
    		$check->num = $num;
    		$res = $check->save();
    		
    		//$res = $shopping->where('id ='.intval($cart_id).' AND uid='.intval($uid))->save($data);
    		if ($res) {
    			echo json_encode(array('status'=>1,'succ'=>'操作成功!'));
    			exit();
    		}else{
    			echo json_encode(array('status'=>0,'err'=>'操作失败.'));
    			exit();
    		}
    	}else{
    		echo json_encode(array('status'=>0,'err'=>'请求方式错误.'));
    		exit();
    	}
    }
    
    //购物车商品删除
    public function deleteAction(){
    	if ($this->request->isPost()){
    		$card_id = isset($_POST['cart_id']) ? explode(',', trim($_POST['cart_id'], ',')) : array();
    		if (!count($card_id)){
    			echo json_encode(array('status'=>0,'err'=>'参数错误.'));
    			exit();
    		}
    		
    		for ($i=0; $i<count($card_id); ++$i){
    			$check_id = ShoppingChar::findFirstById($card_id[$i]);
    			if (!$check_id || !$check_id->delete()) {
    				echo json_encode(array('status'=>0));
    				exit();
    			}
    		}
    		echo json_encode(array('status'=>1));
    	}else{
    		echo json_encode(array('status'=>0,'err'=>'请求方式错误.'));
    		exit();
    	}
    }
    
    //购物车添加。删除检测公共方法
    public function checkCartAction($pid, $skuid=''){
    	//检查产品是否存在或删除
    	$check_info = Product::find(array(
    			'conditions'=> 'id=?1 and del=?2 and is_down=?3',
    			'bind'		=> array(1=>$pid, 2=>0, 3=>0)
    	));
    	if (!$check_info || !count($check_info->toArray())>0) {
    		return array('status'=>0, 'err'=>'商品不存在或已下架.');
    	}
    	
    	return array('status'=>1, 'pro'=>$check_info->toArray()[0]);
    }
    /**
     * 获取sku
     */
    private function getSku($skuid, $pid){
    	if ($skuid){
    		$sku = ProductSku::find(array(
    				'conditions'=> "skuid=?1 and pid=?2",
    				'bind'		=> array(1=>$skuid, 2=>intval($pid))
    		));
    		if ($sku && count($sku)){
    			$sku = $sku->toArray()[0];
    			return $sku;
    		}
    	}
    	return false;
    }
    
    /**
     * 从购物车中删除商品
     */
    public function delPorCartAction($cid){
    	$check_info = ShoppingChar::findFirstById($cid);
    	if ($check_info) {
    		if ($check_info->delete()) return true;
    		else return false;
    	}
    	return true;
    }
    
    /**
     * 购物车结算验证
     */
    public function isSingleShopAction(){
    	if ($this->request->isPost()){
    		$cids = isset($_POST['cids']) ? trim($_POST['cids'], ',') : '';
    		
    		if (!strlen($cids)){
    			echo json_encode(array('status'=>0,'err'=>'数据错误')); exit();
    		}
    		
    		$cb = new CartBase();
    		$cb->cartList($type='cids', array('cids'=>$cids));
    		$iss = $cb->isSingleShop();//获取是否是单个店铺
    		$csv = $cb->clStockVerify();//判断库存
    		
    		if (!is_array($csv)) {echo json_encode(array('status'=>0, 'err'=>'数据异常'));exit();}
    		
    		echo json_encode(array('status'=>1, 'isSingleShop'=>$iss, 'cartStock'=>$csv));
    	}
    }
}

