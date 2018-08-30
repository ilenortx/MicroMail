<?php

class ApiPaymentController extends ApiBase{

    public function indexAction(){

    }
    
    //**********************************
    // 购物车结算
    //***********************************
    public function buyCartAction($cart_id, $uid, $payType){
    	if (!$uid) { echo json_encode(array('status'=>0,'err'=>'登录状态异常.')); exit(); }
    	$cids = explode(',', trim($cart_id, ','));
    	if (!$cart_id) { echo json_encode(array('status'=>0,'err'=>'网络异常.'.__LINE__)); exit(); }
    	
    	//生成订单号
    	$oproarr = array(); $orderArr = array();
    	$cartBase = new CartBase();
    	//根据$cart_id获取购物车列表
    	$carts = $cartBase->cartList($type='cids', array('cids'=>trim($cart_id, ',')));
    	//判断是否是单店铺
    	if (!$cartBase->isSingleShop()) {echo json_encode(array('status'=>0, 'err'=>'仅单店铺结算！'));exit();}
    	//判断库存
    	$csv = $cartBase->clStockVerify();
    	if (!is_array($csv)) {echo json_encode(array('status'=>0, 'err'=>'数据异常'));exit();}
    	else if (count($csv)) {echo json_encode(array('status'=>0, 'err'=>'库存不足'));exit();}
    	
    	foreach ($cartBase->cartList as $k=>$v){
    		//获取产品
    		$proinfo = array();
    		$pros = Product::findFirstById($v['pid']);
    		
    		if (!$pros){
    			echo json_encode(array('status'=>0,'err'=>'数据异常.')); exit();
    		}else $proinfo = $pros->toArray();
    		
    		//获取skuid价格
    		if (isset($cartBase->skuidArr[$v['pid'].'-'.trim($v['skuid'], ',')])){
    			$proinfo['price_yh'] = $cartBase->skuidArr[$v['pid'].'-'.trim($v['skuid'], ',')]['price'];
    		}
    		
    		if ($proinfo['hd_type']=='1'){
    			$ab = new ActivityBase();
    			$hs = $ab->verifyAIV($proinfo['hd_id'], 1);
    			if ($hs == 'S2'){
    				$pi = $ab->promotion($proinfo['hd_id']);
    				$proinfo['price_yh'] = $pi['pprice'];
    			}
    		}
    		
    		if (!isset($orderArr[$proinfo['shop_id']])){
    			$orderArr[$proinfo['shop_id']]['order_sn'] = $this->build_order_no();
    			$orderArr[$proinfo['shop_id']]['shop_id'] = $proinfo['shop_id'];
    			$orderArr[$proinfo['shop_id']]['price'] = $proinfo['price'] * $v['num'];
    			$orderArr[$proinfo['shop_id']]['amount'] = $proinfo['price_yh'] * $v['num'];
    			$orderArr[$proinfo['shop_id']]['product_num'] = $v['num'];
    		}else{
    			$orderArr[$proinfo['shop_id']]['price'] += $proinfo['price'] * $v['num'];
    			$orderArr[$proinfo['shop_id']]['amount'] += $proinfo['price_yh'] * $v['num'];
    			$orderArr[$proinfo['shop_id']]['product_num'] += $v['num'];
    		}
    		
    		array_push($oproarr, array(
    				'pid'		=> $v['pid'],
    				'name'		=> $proinfo['name'],
    				'price'		=> $proinfo['price_yh'] * $v['num'],
    				'photo_x'	=> $proinfo['photo_x'],
    				//'pro_buff'	=> $proinfo['pro_buff'],
    				'num'		=> $v['num'],
    				'shop_id'	=> $proinfo['shop_id'],
    				'addtime'	=> time(),
    				'skuid'		=> $v['skuid']
    		));
    	}
    	
    	/* for ($i=0; $i<count($cids); ++$i){
    		//获取购物车
    		$cartinfo = array();
    		$carts = ShoppingChar::findFirstById($cids[$i]);
    		if (!$carts){
    			echo json_encode(array('status'=>0,'err'=>'数据异常.'));
    			exit();
    		}else $cartinfo= $carts->toArray();
    		
    		//获取产品
    		$proinfo = array();
    		$pros = Product::findFirstById($cartinfo['pid']);
    		
    		if (!$pros){
    			echo json_encode(array('status'=>0,'err'=>'数据异常.'));
    			exit();
    		}else $proinfo = $pros->toArray();
    		
    		//判断库存是否大于等购买量
    		$stock = intval($proinfo['num']);
    		if (trim($cartinfo['skuid'], ',')){
    			$sku = self::getSku(trim($cartinfo['skuid'], ','), $cartinfo['pid']);
    			if ($sku) $stock = $sku['stock'];
    			$proinfo['price_yh'] = $sku['price'];
    		}
    		if ($stock<$cartinfo['num']){
    			echo json_encode(array('status'=>0, 'err'=>'库存不足.'));
    			exit();
    		}
    		
    		if ($proinfo['hd_type']=='1'){
    			$ab = new ActivityBase();
    			$hs = $ab->verifyAIV($proinfo['hd_id'], 1);
    			if ($hs == 'S2'){
    				$pi = $ab->promotion($proinfo['hd_id']);
    				$proinfo['price_yh'] = $pi['pprice'];
    			}
    		}
    		
    		if (!isset($orderArr[$proinfo['shop_id']])){
    			$orderArr[$proinfo['shop_id']]['order_sn'] = $this->build_order_no();
    			$orderArr[$proinfo['shop_id']]['shop_id'] = $proinfo['shop_id'];
    			$orderArr[$proinfo['shop_id']]['price'] = $proinfo['price'] * $cartinfo['num'];
    			$orderArr[$proinfo['shop_id']]['amount'] = $proinfo['price_yh'] * $cartinfo['num'];
    			$orderArr[$proinfo['shop_id']]['product_num'] = $cartinfo['num'];
    		}else{
    			$orderArr[$proinfo['shop_id']]['price'] += $proinfo['price'] * $cartinfo['num'];
    			$orderArr[$proinfo['shop_id']]['amount'] += $proinfo['price_yh'] * $cartinfo['num'];
    			$orderArr[$proinfo['shop_id']]['product_num'] += $cartinfo['num'];
    		}
    		
    		array_push($oproarr, array(
    				'pid'		=> $cartinfo['pid'],
    				'name'		=> $proinfo['name'],
    				'price'		=> $proinfo['price_yh'] * $cartinfo['num'],
    				'photo_x'	=> $proinfo['photo_x'],
    				//'pro_buff'	=> $proinfo['pro_buff'],
    				'num'		=> $cartinfo['num'],
    				'shop_id'	=> $proinfo['shop_id'],
    				'addtime'	=> time(),
    				'skuid'		=> $cartinfo['skuid']
    		));
    	} */
    	
    	$shop_oid = array(); $oidstr = '';
    	//添加订单信息
    	foreach ($orderArr as $k=>$v){
    		$order = new Order();
    		$order->order_sn	= $v['order_sn'];
    		//if ($payType=='cash') $order->order	= $v['order_sn'];
    		$order->shop_id 	= $v['shop_id'];
    		$order->uid			= $uid;
    		$order->price		= $v['price'];
    		$order->amount		= $v['amount'];
    		$order->price_h		= $v['amount'];
    		$order->del			= 0;
    		$order->type		= $payType;
    		$order->status		= $payType=='cash' ? 20 : 10;
    		$order->post_remark	= 0;
    		$order->addtime		= time();
    		$order->product_num	= $v['product_num'];
    		$result = $order->save();
    		
    		$shop_oid[$v['shop_id']] = $order->id;
    		$oidstr .= $order->id.',';
    	}
    	
    	
    	//订单产品详情
    	foreach ($oproarr as $k=>$v){
    		$opro = new OrderProduct();
    		$opro->pid		= $v['pid'];
    		$opro->shop_id	= $v['shop_id'];
    		$opro->order_id	= $shop_oid[$v['shop_id']];
    		$opro->name		= $v['name'];
    		$opro->price	= $v['price'];
    		$opro->photo_x	= $v['photo_x'];
    		//$opro->pro_buff	= $v['pro_buff'];
    		$opro->addtime	= $v['addtime'];
    		$opro->num		= $v['num'];
    		$opro->pro_guige= 0;
    		$opro->skuid = $v['skuid'];
    		$result = $opro->save();
    	}
    	
    	if ($result){
    		//删除购物车
    		$shopping = new ApiShoppingController();
    		for ($i=0; $i<count($cids); ++$i){
    			$shopping->delPorCartAction($cids[$i]);
    		}
    	}
    	
    	return trim($oidstr, ',');
    }

    //***************************
    //  立即购买下单接口
    //***************************
    public function buyNowAction($uid, $orderInfo, $payType, $type='buyNow', $hdId=0){
    	$pid = $orderInfo['pid']; $num = $orderInfo['num'];
    	$skuid = isset($orderInfo['skuid'])?trim($orderInfo['skuid'], ','):'';
    	if (!$uid || !$pid || !$num){
    		echo json_encode(array('status'=>0,'err'=>'数据异常.'));
    		exit();
    	}
    	
    	//获取产品
    	$proinfo = array();
    	$pros = Product::findFirstById($pid);
    	if (!$pros){
    		echo json_encode(array('status'=>0,'err'=>'数据异常.'));
    		exit();
    	}else $proinfo = $pros->toArray();
    	
    	
    	//判断库存是否大于等购买量
    	$stock = intval($proinfo['num']);
    	if (trim($skuid, ',')){
    		$sku = self::getSku(trim($skuid, ','), $proinfo['id']);
    		if ($sku) $stock = $sku['stock'];
    		$proinfo['price_yh'] = floatval($sku['price']);
    	}
    	if ($stock<$num){
    		echo json_encode(array('status'=>0, 'err'=>'库存不足.'));
    		exit();
    	}
    	
    	$isNewOrder = false; $otype = 1;
    	$order_no = $this->build_order_no();//生成订单号
    	if ($type == 'buyNow'){
    		//添加订单信息
    		$order = new Order();
    		$isNewOrder = true;
    		if ($proinfo['hd_type']=='1') {
    			$order->order_type = 1;
    			$order->hd_id = $proinfo['hd_id'];
    		}
    	}else if ($type == 'cutPrice'){
    		$order = Order::find("order_type=4 and hd_id=$hdId");
    		if (!$order || !count($order->toArray())){
    			$order = new Order();
    			$isNewOrder = true;
    			
    			$cutPrice = $this->getCutPrice($hdId);
    			if (!$cutPrice) {
    				echo json_encode(array('status'=>0,'err'=>'数据异常.'));
    				exit();
    			}
    			$cpnum = ($proinfo['price_yh']-$cutPrice[0]['low_price'])/$cutPrice[0]['friends']*$cutPrice[1]['cpnum'];
    			$proinfo['price_yh'] -= round($cpnum, 2);
    			$order->order_type = 4;
    			$order->hd_id = $hdId;
    		}else {
    			foreach ($order as $k=>$v){ $order = $v; break; }
    		}
    	}else if ($type == 'gb'){
    		$order = new Order();
    		$isNewOrder = true;
    		
    		$ab = new ActivityBase();
    		$gbv = $ab->verifyAIV($hdId, 2);
    		if ($gbv=='S0'){ echo json_encode(array('status'=>0,'msg'=>'拼团删除')); exit(); }
    		else if ($gbv=='S1'){ echo json_encode(array('status'=>0,'msg'=>'活动未开始')); exit(); }
    		else if ($gbv=='S3'){ echo json_encode(array('status'=>0,'msg'=>'活动结束')); exit(); }
    		$gbi = $ab->gbInfo($hdId);
    		
    		if (intval($orderInfo['gblid'])==0) {
    			$gbl = $ab->addGb($hdId, $uid, $pid);//新增砍价
    		}else {
    			$gbls = $ab->verifyGBL($orderInfo['gblid']);
    			if ($gbls == 'S0'){ echo json_encode(array('status'=>0,'msg'=>'拼团删除')); exit(); }
    			else if ($gbls == 'S1'){ echo json_encode(array('status'=>0,'msg'=>'暂未成团')); exit(); }
    			else if ($gbls == 'S3'){ echo json_encode(array('status'=>0,'msg'=>'活动结束')); exit(); }
    			else if ($gbls == 'S4'){ echo json_encode(array('status'=>0,'msg'=>'成团失败')); exit(); }
    			else if ($gbls == 'S5'){ echo json_encode(array('status'=>0,'msg'=>'成团成功')); exit(); }
    			$gbl = intval($orderInfo['gblid']);
    		}
    		
    		$order->order_type = 3;
    		$order->hd_id = $gbl;
    		$proinfo['price_yh'] = $gbi['gbprice'];
    	}else if ($type == 'promotion'){
    		$order = new Order();
    		$isNewOrder = true;
    		
    		$ab = new ActivityBase();
    		$gbv = $ab->verifyAIV($hdId, 1);
    		if ($gbv=='S0'){ echo json_encode(array('status'=>0,'msg'=>'活动不存在')); exit(); }
    		else if ($gbv=='S1'){ echo json_encode(array('status'=>0,'msg'=>'活动未开始')); exit(); }
    		else if ($gbv=='S3'){ echo json_encode(array('status'=>0,'msg'=>'活动结束')); exit(); }
    		$pi = $ab->promotion($hdId);
    	
    		$order->order_type = 3;
    		$order->hd_id = $pi['id'];
    		$proinfo['price_yh'] = $pi['pprice'];
    	}
    	
    	if ($isNewOrder){
    		$order->order_sn	= $order_no;
    		//if ($payType=='cash') $order->order	= $order_no;
    		$order->shop_id		= $proinfo['shop_id'];
    		$order->uid			= $uid;
    		$order->price		= $proinfo['price']*$num;
    		$order->amount		= $proinfo['price_yh']*$num;
    		$order->price_h		= $proinfo['price_yh']*$num;
    		$order->del			= 0;
    		$order->type		= $payType;
    		$order->status		= $payType=='cash' ? 20 : 10;
    		$order->addtime		= time();
    		$order->post_remark	= '';
    		$order->product_num	= $num;
    		$result = $order->save();
    		
    		if ($result){
    			//订单产品详情
    			$opro = new OrderProduct();
    			$opro->pid		= $pid;
    			$opro->shop_id	= $proinfo['shop_id'];
    			$opro->order_id	= $order->id;
    			$opro->name		= $proinfo['name'];
    			$opro->price	= $order->amount;
    			$opro->photo_x	= $proinfo['photo_x'];
    			//$opro->pro_buff	= $proinfo['pro_buff'];
    			$opro->addtime	= time();
    			$opro->num		= $num;
    			$opro->pro_guige= 0;
    			$opro->skuid = $skuid;
    			$opro->save();
    			
    			if (($order->order_type=='3'||$order->order_type=='4') && $payType=='cash'){
    				$ab = new ActivityBase();
    				$ab->hdOrderSuc($order->order_type, $order->hd_id, $order->uid);
    				if ($order->order_type==3) $ab->joinGb($order->id, $order->hd_id, $order->uid);
    			}
    		}
    	}
    	
    	return $order->id;
    }
    
    //***************************
    //  获取订单信息
    //***************************
    public function getOrderInfoAction(){
    	if ($this->request->isPost()){
    		$oids = isset($_POST['order_id']) ? trim($_POST['order_id'], ',') : '';
    		$addrId = (isset($_POST['addr_id'])&&intval($_POST['addr_id'])>0) ? $_POST['addr_id'] : false;
    		
    		if (!$oids){
    			echo json_encode(array('status'=>0, 'err'=>'数据异常.'));
    			exit();
    		}
    		
    		//查询店铺
    		$shops = Shangchang::find(array(
    				'conditions'=> "status=?1",
    				'bind'		=> array(1=>1)
    		));
    		
    		if ($shops){
    			$uid = -1;
    			$vouarr = array();
    			$yunfei = array('id'=>0, 'name'=>'快递', 'price'=>0);
    			
    			$shops = $shops->toArray();
    			$shopArr = array(); $vidarr = array(); $remarkarr = array();
    			foreach ($shops as $k=>$v){
    				$shopArr[$v['id']]['shop_id'] = $v['id'];
    				$shopArr[$v['id']]['shop_name'] = $v['name'];
    				$shopArr[$v['id']]['shop_pros'] = array();
    				$shopArr[$v['id']]['shop_vous'] = array();
    				$shopArr[$v['id']]['yunfei'] = $yunfei;
    				$vidarr[$v['id']] = '';	//优惠卷id
    				$remarkarr[$v['id']] = '';//备注
    			}
    			
    			//查询订单
    			$oinfo = Order::find("id in({$oids})");
    			if (!$oinfo){
    				echo json_encode(array('status'=>0, 'err'=>'订单不存在.'));
    				exit();
    			}
    			$oinfo = $oinfo->toArray(); $prices = 0;
    			foreach ($oinfo as $k1=>$v1){
    				if ($uid == -1) $uid = $v1['uid'];
    				$prices += $v1['amount'];
    				//查询订单产品
    				$opro = OrderProduct::find(array('conditions'=>"order_id=?1",'bind'=>array(1=>intval($v1['id']))));
    				if (!$opro){
    					echo json_encode(array('status'=>0, 'err'=>'订单数据错误.'));
    					exit();
    				}
    				$opro= $opro->toArray();
    				
    				foreach ($opro as $k2=>$v2){
    					$vous = $this->getVoucherAction($v1['uid'], $v1['shop_id'], $v2['pid'], $v1['amount']);
    					
    					$opro[$k2]['amount'] = $v2['price'];
    					
    					if (isset($shopArr[$v2['shop_id']])){
    						array_push($shopArr[$v2['shop_id']]['shop_pros'], $opro[$k2]);
    						//添加优惠券
    						foreach ($vous as $k3=>$v3){
    							if (!isset($shopArr[$v2['shop_id']]['shop_vous'][$v3['id']])){
    								$shopArr[$v2['shop_id']]['shop_vous'][$v3['id']] = $v3;
    							}
    						}
    					}
    					//$yunfei = $this->getyunfeiAction($opro['pid'], $oinfo['amount']);
    				}
    			}
    			
    			//收货地址
    			if (!$addrId) $add = $this->getAddAction($uid);
    			else {
    				$add = Address::findFirstById($addrId);
    				$add = $add->toArray();
    			}
    			
    			if (!$add && !count($add)) {
    				$addemt = 1;
    			}else{
    				$addemt = 0;
    			}
    			
    			foreach ($shopArr as $k=>$v){
    				if (count($v['shop_pros']) == 0) {
    					unset($shopArr[$k]); 
    					unset($vidarr[$k]);
    					unset($remarkarr[$k]);
    				}
    			}
    			
    			echo json_encode(array('status'=>1, 'orderInfo'=>$shopArr, 'price'=>$prices, 'adds'=>$add, 'addemt'=>$addemt, 'vidarr'=>$vidarr, 'remarkarr'=>$remarkarr));
    		}
    	}
    }
    
    public function orderInfoAction(){
    	if ($this->request->isPost()){
    		$oid = isset($_POST['oid']) ? $_POST['oid']: '';
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : 0;
    		
    		if (!$oid){
    			echo json_encode(array('status'=>0, 'err'=>'数据异常.'));
    			exit();
    		}
    		
    		$order = Order::findFirst("id=$oid and uid=$uid");
    		
    		if ($order){
    			echo json_encode(array('status'=>1, 'oinfo'=>$order->toArray()));
    		}else echo json_encode(array('status'=>0, 'err'=>'数据异常'));
    	}
    }

    //***************************
    //  获取产品信息
    //***************************
    public function getProInfoAction(){
    	if ($this->request->isPost()){
    		$oinfo = isset($_POST['order_info']) ? json_decode($_POST['order_info'], true): '';
    		$addrId = (isset($_POST['addr_id'])&&intval($_POST['addr_id'])>0) ? $_POST['addr_id'] : false;
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    		if (!$oinfo || !count($oinfo) || !$uid){
    			echo json_encode(array('status'=>0, 'err'=>'数据异常.'));
    			exit();
    		}
    		
    		$type = $oinfo['type'];
    		if (!$type){
    			echo json_encode(array('status'=>0, 'err'=>'数据异常.'));
    			exit();
    		}
    		
    		//查询店铺
    		$shops = Shangchang::find(array(
    				'conditions'=> "status=?1", 'bind'		=> array(1=>1)
    		));
    		
    		if ($shops){
    			$vouarr = array();
    			
    			$shops = $shops->toArray();
    			$shopArr = array(); $vidarr = array(); $remarkarr = array(); $yfarr = array();
    			foreach ($shops as $k=>$v){
    				$shopArr[$v['id']]['shop_id'] = $v['id'];
    				$shopArr[$v['id']]['shop_name'] = $v['name'];
    				$shopArr[$v['id']]['shop_pros'] = array();
    				$shopArr[$v['id']]['shop_vous'] = array();
    				$shopArr[$v['id']]['amount'] = 0;
    				$shopArr[$v['id']]['yunfei'] = array('0'=>array('id'=>'0', 'name'=>'快递 免邮', 'price'=>0));
    				$vidarr[$v['id']] = '';	//优惠卷id
    				$remarkarr[$v['id']] = '';//备注
    				$yfarr[$v['id']] = 0;//运费
    			}
    			
    			$prices = 0;
    			if ($type=='buyNow' || $type=='cutPrice' || $type=='gb' || $type=='promotion'){
    				//查询产品
    				$pinfo = Product::findFirstById($oinfo['pid']);
    				if (!$pinfo || !count($pinfo)) {
    					echo json_encode(array('status'=>0, 'err'=>'商品错误.'));
    					exit();
    				}
    				
    				$pinfo = $pinfo->toArray();
    				$stock = $pinfo['num'];
    				//判断库存是否大于等购买量
    				if (trim($oinfo['skuid'], ',')){
    					$sku = self::getSku(trim($oinfo['skuid'], ','), $oinfo['pid']);
    					if ($sku) $stock = $sku['stock'];
    					$pinfo['price_yh'] = $sku['price'];
    				}
    				if ($stock<$oinfo['num']){
    					echo json_encode(array('status'=>0, 'err'=>'库存不足.'));
    					exit();
    				}
    				
    				if ($type=='cutPrice'){//砍价
    					$cpId = isset($oinfo['cpId']) ? intval($oinfo['cpId']) : '';
    					if (!$cpId){
    						echo json_encode(array('status'=>0, 'err'=>'数据错误.')); exit();
    					}
    					$cutPrice = $this->getCutPrice($cpId);
    					if (!$cutPrice){
    						echo json_encode(array('status'=>0, 'err'=>'数据异常.')); exit();
    					}
    					$cpnum = ($pinfo['price_yh']-$cutPrice[0]['low_price'])/$cutPrice[0]['friends']*$cutPrice[1]['cpnum'];
    					$pinfo['price_yh'] -= round($cpnum, 2);
    				}else if ($type=='gb') {//团购
    					$ab = new ActivityBase();
    					$gbiArr = $ab->gbInfo(intval($oinfo['hdId']));
    					if (count($gbiArr)){
    						$pinfo['price_yh'] = $gbiArr['gbprice'];
    					}
    				}else if ($type=='promotion') {//秒杀
    					$ab = new ActivityBase();
    					$piArr = $ab->promotion(intval($oinfo['hdId']));
    					if (count($piArr)){
    						$pinfo['price_yh'] = $piArr['pprice'];
    					}
    				}
    				
    				$pinfo['amount'] = $pinfo['price_yh'] * $oinfo['num'];
    				$prices += $pinfo['price_yh'] * $oinfo['num'];
    				$pinfo['num'] = $oinfo['num'];
    				
    				if (isset($shopArr[$pinfo['shop_id']])){
    					$shopArr[$pinfo['shop_id']]['amount'] += $pinfo['amount'];
    					array_push($shopArr[$pinfo['shop_id']]['shop_pros'], $pinfo);
    				}
    			}else if ($type == 'buyCart'){
    				$cids = explode(',', trim($oinfo['cart_id'], ','));
    				for ($i=0; $i<count($cids); ++$i){
    					//获取购物车
    					$carts = ShoppingChar::findFirstById($cids[$i]);
    					if (!$carts){
    						echo json_encode(array('status'=>0,'err'=>'数据异常.'));
    						exit();
    					}else $carts= $carts->toArray();
    					
    					//获取产品
    					$pinfo = Product::findFirstById($carts['pid']);
    					
    					if (!$pinfo){
    						echo json_encode(array('status'=>0,'err'=>'数据异常.'));
    						exit();
    					}else $pinfo= $pinfo->toArray();
    					//判断库存是否大于等购买量
    					$stock = intval($pinfo['num']);
    					if (trim($carts['skuid'], ',')){
    						$sku = self::getSku(trim($carts['skuid'], ','), intval($pinfo['id']));
    						if ($sku) $stock = intval($sku['stock']);
    						$pinfo['price_yh'] = $sku['price'];
    					}
    					if ($stock<$carts['num']){
    						echo json_encode(array('status'=>0, 'err'=>'库存不足.'));
    						exit();
    					}
    					if ($pinfo['hd_type'] == '1') {//秒杀
    						$ab = new ActivityBase();
    						$piArr = $ab->promotion(intval($pinfo['hd_id']));
    						if (count($piArr)){
    							$pinfo['price_yh'] = $piArr['pprice'];
    						}
    					}
    					
    					$pinfo['amount'] = $pinfo['price_yh'] * $carts['num'];
    					$prices += $pinfo['price_yh'] * $carts['num'];
    					$pinfo['num'] = $carts['num'];
    					
    					if (isset($shopArr[$pinfo['shop_id']])){
    						$shopArr[$pinfo['shop_id']]['amount'] += $pinfo['amount'];
    						array_push($shopArr[$pinfo['shop_id']]['shop_pros'], $pinfo);
    					}
    				}
    			}
    			
    			
    			//优惠券
    			foreach ($shopArr as $k=>$v){
    				foreach ($shopArr[$k]['shop_pros'] as $k1=>$v1){
    					$vous = $this->getVoucherAction($uid, $k, $v1['id'], $v['amount']);
    					//添加优惠券
    					foreach ($vous as $k2=>$v2){
    						if (!isset($shopArr[$k]['shop_vous'][$v2['id']])){
    							$shopArr[$k]['shop_vous'][$v2['id']] = $v2;
    					 	}
    					} 
    				}
    			}
    			
    			
    			//收货地址
    			if (!$addrId) $add = $this->getAddAction($uid);
    			else {
    				$add = Address::findFirstById($addrId);
    				$add = $add->toArray();
    			}
    			
    			if (!$add && !count($add)) {
    				$addemt = 1;
    			}else{
    				$addemt = 0;
    			}
    			
    			foreach ($shopArr as $k=>$v){
    				if (count($v['shop_pros']) == 0) {
    					unset($shopArr[$k]);
    					unset($vidarr[$k]);
    					unset($remarkarr[$k]);
    					unset($yfarr[$k]);
    				}else {
    					//获取运费
    					$shopArr[$k]['yunfei']= $this->getyunfeiAction($k, $v['amount']);
    				}
    			}
    			
    			echo json_encode(array('status'=>1, 'orderInfo'=>$shopArr, 'price'=>$prices, 'adds'=>$add, 'addemt'=>$addemt, 'vidarr'=>$vidarr, 'remarkarr'=>$remarkarr, 'yfarr'=>$yfarr));
    		}
    	}
    }
    
    /**
     * 获取砍价信息
     */
    public function getCutPrice($ucpId){
    	if (!$ucpId) return false;
    	
    	$ucp = CutPriceSpritesList::findFirstById($ucpId);
    	if ($ucp){
    		$ucp->cp_result = '3'; $ucp->status='S2'; $ucp->save();
    		$cp = $ucp->CutPriceSprites;
    		if ($cp){
    			if ($cp->friends<$ucp->cpnum) $ucp->cpnum = $cp->friends;
    			return array($cp->toArray(), $ucp->toArray());
    		}return false;
    	}return false;
    }
    
    //****************************
    // 获取可用优惠券
    //****************************
    public function getVoucherAction($uid, $shop_id, $pid, $amount){
    	$voulist = array();$vouarr = array();
    	
    	$time = time();
    	$vs = UserVoucher::find(array(
    			'conditions'=> "uid=?1 and full_money<=?2 and status=?3 and start_time<?4 and end_time>?5 and shop_id=?6",
    			'bind'		=> array(1=>$uid, 2=>$amount, 3=>1, 4=>$time, 5=>$time, 6=>$shop_id)
    	));
    	
    	if ($vs) $voulist= $vs->toArray();
    	
    	foreach ($voulist as $k=>$v){
    		$vouinfo = Voucher::findFirstById($v['vid']);
    		if ($vouinfo) {
    			$vinfo = $vouinfo->toArray();
    			if ($vinfo['proid']=='all' || strpos($vinfo['proid'], $pid)===true){
    				$vinfo['uvid'] = $v['id'];
    				array_push($vouarr, $vinfo);
    			}
    		}
    	}
    	
    	return $vouarr;
    }
    
    //****************************
    // 获取是否需要运费
    //****************************
    public function getyunfeiAction($sid, $amount){
    	$yunfei = array();
    	$yfs = Post::find(array('conditions'=>"shop_id=?1", 'bind'=>array(1=>$sid), 'order'=>"price_max desc"));
    	$hasmy = false;
    	if ($yfs && count($yfs->toArray())){
    		$yfs = $yfs->toArray();
    		foreach ($yfs as $k=>$v){
    			if ($v['price_max']<=$amount && !$hasmy){
    				$yunfei['0'] = array('id'=>0, 'name'=>'快递 免邮', 'price'=>0);
//     				if () array_unshift($yunfei, array('id'=>-1, 'name'=>$v['name'], 'price'=>0));
//     				else array_push($yunfei, array('id'=>-1, 'name'=>$v['name'], 'price'=>0));
    			}else{
    				$yunfei[$v['id']] = array('id'=>$v['id'], 'name'=>$v['name'], 'price'=>$v['price']);
    				//array_push($yunfei, array('id'=>$v['id'], 'name'=>$v['name'], 'price'=>$v['price']));
    			}
    		}
    	}else {
    		$yunfei['0'] = array('id'=>0, 'name'=>'快递 免邮', 'price'=>0);
    	}
    	
    	return $yunfei;
    }
    
    public function getAddAction($uid){
    	$add = array();
    	$address = Address::findFirst(array(
    			'conditions'=> 'uid=?1 and status=?2',
    			'bind'		=> array(1=>$uid, 2=>1),
    			'order'		=> 'is_default desc,id desc'
    	));
    	
    	if ($address) $add = $address->toArray();
    	
    	return $add;
    }
    
    //****************************
    // 获取可用优惠券
    //****************************
    public function getVoucher($uid, $pid, $cart_id){
    	//计算总价
    	$prices = 0;
    	foreach($cart_id as $ks => $vs){
    		$shpp = ShoppingChar::findFirst(array(
    				'conditions'=> 'uid=?1 and id=?2',
    				'bind'		=> array(1=>$uid, 2=>$vs)
    		));
    		$prod = $shpp->product;
    		$sc = $shpp->shangchang;
    		
    		$shppArr = $shpp->toArray();//$prodArr = $prod->toArray();//$scArr = $sc->toArray();
    		
    		$pros = array(
    				'num'	=> $shppArr['num'],//shopping_char
	    			'price'=> $shppArr['price'],//shopping_char
	    			'type'=> $shppArr['type'],//shopping_char
    		);
    		
    		$zprice = $pros['price']*$pros['num'];
    		$prices += $zprice;
    	}
    	
    	$vous = UserVoucher::find(array(
    			'conditions'=> 'uid=?1 and status=?2 and start_time<?3 and end_time>?4 and full_money<=?5',
    			'bind'		=> array(1=>$uid, 2=>1, 3=>time(), 4=>time(), 5=>floatval($prices)),
    			'order'		=> 'addtime desc'
    	));
    	
    	$vou = $vous ? $vous : array();
    	$vouarr = array();
    	foreach ($vou as $k => $v) {
    		$chk_order = Order::find(array(
    				'conditions'=> "uid=?1 and vid=?2 and status>?3",
    				'bind'		=> array(1=>$uid, 2=>intval($v['vid']), 3=>0)
    		));
    		
    		$vou_info = Voucher::findFirstById(intval($v['vid']));
    		$vou_info = $vou_info->toArray();
    		$proid = explode(',', trim($vou_info['proid'],','));
    		if (($vou_info['proid']=='all' || $vou_info['proid']=='' || in_array($pid, $proid)) && !$chk_order) {
    			$arr = array();
    			$arr['vid'] = intval($v['vid']);
    			$arr['full_money'] = floatval($v['full_money']);
    			$arr['amount'] = floatval($v['amount']);
    			$vouarr[] = $arr;
    		}
    	}
    	
    	return $vouarr;
    }
    
    
    //**********************************
    // 结算
    //***********************************
    public function paymentAction(){
    	$uid 		= isset($_POST['uid']) ? $_POST['uid'] : '';
    	$orderInfo	= isset($_POST['order_info']) ? json_decode($_POST['order_info'], true): '';
    	$aid		= isset($_POST['aid']) ? $_POST['aid'] : '';//地址的id
    	$remarkarr	= isset($_POST['remarkarr']) ? json_decode($_POST['remarkarr'], true) : '';//用户备注
    	$price		= isset($_POST['price']) ? $_POST['price'] : '';//总价
    	$vidarr		= isset($_POST['vidarr']) ? json_decode($_POST['vidarr'], true) : '';//优惠券ID
    	$payType 	= isset($_POST['type']) ? $_POST['type'] : 'weixin';
    	$yfarr 		= isset($_POST['yfarr']) ? json_decode($_POST['yfarr'], true) : '';
    	$fxsId 		= isset($_POST['fxs_id']) ? intval($_POST['fxs_id']) : 0;
    	
    	if (!$uid || !$orderInfo || !$aid || !$payType) { echo json_encode(array('status'=>0, 'err'=>'数据异常.')); exit(); }
    	
    	$hdId = 0;
    	if ($orderInfo['type']=='cutPrice'){
    		$hdId = (isset($orderInfo['cpId'])&&intval($orderInfo['cpId'])) ? intval($orderInfo['cpId']): 0;
    	}else if ($orderInfo['type']=='gb'){
    		$hdId = (isset($orderInfo['hdId'])&&intval($orderInfo['hdId'])) ? intval($orderInfo['hdId']): 0;
    	}else if ($orderInfo['type']=='promotion'){
    		$hdId = (isset($orderInfo['hdId'])&&intval($orderInfo['hdId'])) ? intval($orderInfo['hdId']): 0;
    	}
    	
    	if ($orderInfo['type']=='buyNow'||$orderInfo['type']=='cutPrice'||$orderInfo['type']=='gb'||$orderInfo['type']=='promotion') $order_id = $this->buyNowAction($uid, $orderInfo, $payType, $orderInfo['type'], $hdId);
    	else if ($orderInfo['type'] == 'buyCart') $order_id = $this->buyCartAction($orderInfo['cart_id'], $uid, $payType);
    	
    	//查询订单
    	$order = Order::find("id in({$order_id})");
    	if (!$order){ echo json_encode(array('status'=>0,'err'=>'订单不存在.')); exit(); }
    	
    	//查询地址
    	$address = Address::findFirstById($aid);
    	if (!$address){
    		echo json_encode(array('status'=>0,'err'=>'地址不存在.')); exit();
    	}else $address = $address->toArray();
    	
    	$order_sn = '';
    	foreach ($order as $k=>$v){
    		$order_sn .= $v->order_sn.',';
    		//查询优惠卷
    		if(isset($vidarr[$v->shop_id])){
    			$vous = UserVoucher::findFirstById(intval($vidarr[$v->shop_id]));
    			if ($vous){
    				$vou = $vous->toArray();
    				if (count($vou) > 0){
    					$v->price_h = $v->amount-$vou['amount'];
    					$v->vid = $vidarr[$v->shop_id];
    					$vous->status = 2; $vous->save();
    				}
    			}
    		}
    		if ($yfarr[$v->shop_id] && intval($yfarr[$v->shop_id])){
    			$post = Post::findFirstById(intval($yfarr[$v->shop_id]));
    			if ($post){
    				$v->post = intval($yfarr[$v->shop_id]);
    				$v->price_h += $post->price;
    			}else $v->post = 0;
    		}
    		//备注
    		$remark = '';
    		if (isset($remarkarr[$v->shop_id])) $remark = $remarkarr[$v->shop_id];
    		
    		//提成
    		if ($fxsId){
    			$sc = Shangchang::findFirstById($v->shop_id);
    			$v->fxtc = $v->amount*$sc->fstc/100;
    		}else $v->fxtc = 0;
    		
    		$v->fxs_id = $fxsId;
    		$v->receiver = $address['id'];
    		$v->tel = $address['tel'];
    		$v->address_xq = $address['address_xq'];
    		$v->code= $address['code'];
    		$v->remark = $remark;
    		$v->save();
    	}
    	
    	echo json_encode(array('status'=>1, 'arr'=>array('order_id'=>$order_id, 'order_sn'=>trim($order_sn), 'pay_type'=>$payType)));
    }
    
    /**生成唯一订单号
     *@return int 返回16位的唯一订单号
     */
    public function build_order_no($rand=true){
    	if ($rand)
    		return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8).rand(100,999);
    	else
    		return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }
    
    /**
     * 支付
     */
    public function wxpayAction(){
    	require_once PAYMENT."/wechat/lib/WxPay.Config.php";
    	$this->view->disable();
	   	$pay_sn = trim($_REQUEST['order_sn'], ',');
	   	$platform = (isset($_POST['platform'])&&$_POST['platform']=='zzyh-gzh') ? 'zzyh-gzh': '';
    	
    	//订单号错误
	   	if (!$pay_sn) { echo json_encode(array('status'=>0,'err'=>'支付信息错误！')); exit(); }
    	
    	//$order_info = Order::find("order_sn in({$pay_sn})");
	   	$order_info = Order::findFirstByOrderSn($pay_sn);
    	//订单不存在
    	if (!$order_info) { echo json_encode(array('status'=>0,'err'=>'没有找到支付订单！')); exit(); }
    	
    	if ($order_info->order_type == 3){//团购时间验证
    		$ab = new ActivityBase();
    		$ab->gblIsPd($order_info->hd_id);
    	}
    	$orderinfo = $order_info->toArray();
    	
    	//订单状态异常
    	if (intval($order_info->status)!=10) { echo json_encode(array('status'=>0,'err'=>'订单状态异常！')); exit(); }
    	//if (empty($v->order)) $v->order = $ordernew;
    	//$v->order = $ordernew;
    	//$v->paytime = time();
    	//$v->save();
    	
    	//$amount += $v->amount;
    	$amount = $order_info->price_h;
    	$uid = $order_info->uid;
    	
    	//①、获取用户openid
    	if ($platform) WxPayConfig::initPayInfo($platform);
    	$user = User::findFirstById($uid);
    	$openId = $user->openid;
    	//用户信息错误
    	if (!$openId) { echo json_encode(array('status'=>0,'err'=>'用户状态异常！')); exit(); }
    	
    	$tools = new WxJsApi();
    	//②、统一下单
    	$orderSn = $order_info->order_sn;
    	$datas = array(
    			'body'=>"专致贸易_".$orderSn, 'attach'=>"专致贸易_".$orderSn, 
    			'order_no'=>$orderSn, 'total_fee'=>floatval($amount)*100,
    			'indate'=>1, 'goods_tag'=>"专致贸易_".$orderSn, 'open_id'=>$openId
    	);
    	$order = $tools->jsApi($datas);
    	
    	$arr = array();
    	$arr['appId'] = $order['appid'];
    	$arr['nonceStr'] = $order['nonce_str'];
    	$arr['package'] = "prepay_id=".$order['prepay_id'];
    	$arr['signType'] = "MD5";
    	$arr['timeStamp'] = (string)time();
    	$str = $this->ToUrlParams($arr);
    	$jmstr = $str."&key=".\WxPayConfig::$key;
    	$arr['paySign'] = strtoupper(MD5($jmstr));
    	
    	echo json_encode(array('status'=>1,'arr'=>$arr));
    	exit();
    }
    
    //***************************
    //  支付回调 接口
    //***************************
    public function notifyAction(){
    	$res_xml = file_get_contents("php://input");
    	libxml_disable_entity_loader(true);
    	$ret = json_decode(json_encode(simplexml_load_string($res_xml,'simpleXMLElement',LIBXML_NOCDATA)),true);
    	
    	$data = array();
    	$data['order_sn'] = $ret['out_trade_no'];
    	$data['pay_type'] = 'weixin';
    	$data['trade_no'] = $ret['transaction_id'];
    	$data['total_fee'] = $ret['total_fee'];
    	$result = $this->orderhandle($data);
    	
    	if (is_array($result)) {
    		$xml = "<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg>";
    		$xml.="</xml>";
    		echo $xml;
    	}else{
    		$contents = 'error => '.json_encode($result);  // 写入的内容
    		$files = $path."error_".date("Ymd").".log";    // 写入的文件
    		file_put_contents($files,$contents,FILE_APPEND);  // 最简单的快速的以追加的方式写入写入方法，
    		echo 'fail';
    	}
    }
    
    //***************************
    //  订单处理 接口
    //***************************
    public function orderhandle($data){
    	$order_sn = trim($data['order_sn']);
    	$pay_type = trim($data['pay_type']);
    	$trade_no = trim($data['trade_no']);
    	$total_fee = floatval($data['total_fee']);
    	
    	$order = Order::findFirstByOrder($order_sn);
    	if (!$order) {
    		return "订单信息错误...";
    	}
    	
    	$check_info= $order->toArray();
    	if ($check_info['status']<10 || $check_info['back']>'0') {
    		return "订单异常...";
    	}
    	if ($check_info['status']>10) {
    		return array('status'=>1,'data'=>$data);
    	}
    	
    	$order->type = $pay_type;
    	$order->total_fee= printf("%.2f",floatval($total_fee/100));
    	$order->status = 20;
    	$order->paytime = time();
    	$order->trade_no = $trade_no;
    	$res = $order->save();
    	
    	if ($res) {
    		if ($order->order_type=='3'||$order->order_type=='4'){
    			$ab = new ActivityBase();
    			$ab->hdOrderSuc($order->order_type, $order->hd_id, $order->uid);
    			if ($order->order_type==3) $ab->joinGb($order->id, $order->hd_id, $order->uid);
    		}
    		
    		//更改库存
    		$ops = OrderProduct::find("order_id=$order->id");
    		$jifen= 0;
    		if ($ops){
    			foreach ($ops as $k=>$v){
    				$pro = Product::findFirstById($v->pid);
    				$pro->num = $pro->num-$v->num;
    				$pro->save();
    				$jifen += $pro->price_jf*$v->num;
    				
    				if (!empty($v->skuid)){//sku库存
    					$sku = ProductSku::findFirst(array(
    							'conditions'=> "skuid=?1 and pid=?2",
    							'bind'		=> array(1=>$v->skuid, 2=>$v->pid)
    					));
    					if ($sku) {
    						$skuStock = $sku->stock-$v->num;
    						$sku->stock = $skuStock<0 ? 0 : $skuStock;
    						$sku->save();
    					}
    				}
    			}
    		}
    		
    		//用户积分处理
    		if ($jifen>0){
    			$user = User::findFirstById($check_info['uid']);
    			$user->jifen = $user->jifen+$jifen;
    			$user->save();
    		}
    		
    		//处理优惠券
    		if (intval($check_info['vid'])) {
    			$uv = UserVoucher::findFirst(array(
    					'conditions'=> "uid=?1 and vid=?2",
    					'bind'		=> array(1=>intval($check_info['uid']), 2=>intval($check_info['vid']))
    			));
    			$vou_info = $uv->toArray();
    			if (intval($vou_info['status'])==1) {
    				$uv->status = 2;
    				$uv->save();
    			}
    		}
    		return array('status'=>1,'data'=>$data);
    	}else{
    		return '订单处理失败...';
    	}
    }
    
    //构建字符串
    private function ToUrlParams($urlObj){
    	$buff = "";
    	foreach ($urlObj as $k => $v) {
    		if($k != "sign"){ $buff .= $k . "=" . $v . "&"; }
    	}
    	
    	$buff = trim($buff, "&");
    	return $buff;
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
    
}

