<?php

/**
 * 订单接口
 * @author xiao
 *
 */
class ApiorderController extends ApiBase{

	/**
	 * 获取订单记录
	 */
    public function indexAction(){
    	$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    	if (!$uid) {
    		echo json_encode(array('status'=>0,'err'=>'登录状态异常'));
    		exit();
    	}
    	
    	//分页
    	$pages = isset($_POST['page']) ? intval($_POST['page']) : 0;
    	
    	//按条件查询
    	$status = 10;
    	$order_type = trim($_REQUEST['order_type']);
    	if ($order_type) {
    		switch ($order_type) {
    			case 'pay':
    				$status= '10';
    				break;
    			case 'deliver':
    				$status = '20';
    				break;
    			case 'receive':
    				$status = '30';
    				break;
    			case 'evaluate':
    				$status = '40,50';
    				break;
    			case 'finish':
    				$status = '40,50,51';
    				break;
    			default:
    				$status = '10';
    				break;
    		}
    	}
    	
    	//获取总页数
    	$count = Order::find(array(
    			'conditions'=> "del=?1 and back=?2 and uid=?3 and status in(?4)",
    			'bind'		=> array(1=>0, 2=>'0', 3=>intval($uid), 4=>$status)
    	));
    	$count = $count->count();
    	
    	$eachpage = 7;
    	
    	$order_status = array('0'=>'已取消','10'=>'待付款','20'=>'待发货','30'=>'待收货','40'=>'待评价','50'=>'交易完成','51'=>'交易关闭');
    	
    	$order = Order::find(array(
    			'conditions'=> 'del=?1 and back=?2 and uid=?3 and status in(?4)',
    			'bind'		=> array(1=>0, 2=>'0', 3=>intval($uid), 4=>$status),
    			'columns'	=> "id,order_sn,pay_sn,status,price,type,product_num,post,price_h",
    			'order'		=> 'id desc',
    			'limit'		=> array('number'=>7, 'offset'=>$pages*7)
    	));
    	$order = $order->toArray();
    	foreach ($order as $n=>$v){
    		$order[$n]['desc'] = $order_status[$v['status']];
    		$prolist = OrderProduct::find(array('conditions'=>'order_id=?1', 'bind'=>array(1=>intval($v['id']))));
    		$prolist = $prolist->toArray();
    		$order[$n]['pro'] = array();
    		$post = self::getPostInfo($v['post']);
    		$order[$n]['postage'] = $post ? $post['price'] : 0;
    		foreach ($prolist as $k1=>$v1){
    			$attrstr = '';
    			if (trim($v1['skuid'], ',')){
    				$sb = new SkuBase();
    				$sta = $sb->skuToAttrs(trim($v1['skuid'], ','));
    				foreach ($sta as $k2=>$v2){
    					$attrstr.= $v2['pname'].': '.$v2['name'].'   ';
    				}
    			}
    			array_push($order[$n]['pro'], array(
    					'photo_x' => $v1['photo_x'],
    					'pid' => $v1['pid'],
    					'name' => $v1['name'],
    					'price_yh' => $v1['price']/$v1['num'],
    					'price' => $v1['price'],
    					'product_num' => $v1['num'],
    					'skuid' => $v1['skuid'],
    					'attrs' => $attrstr
    			));
    		}
    	}
    	
    	echo json_encode(array('status'=>1, 'ord'=>$order, 'eachpage'=>$eachpage));
    	exit();
    }
    
    /**
     * 获取邮费
     */
    private function getPostInfo($postId){
    	$post = Post::findFirstById($postId);
    	
    	if ($post && count($post)) return $post->toArray();
    	else return false;
    }

    /**
     * 退款记录
     */
    public function orderRefundAction(){
    	$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    	if (!$uid) {
    		echo json_encode(array('status'=>0,'err'=>'登录状态异常'));
    		exit();
    	}
    	
    	//分页
    	$pages = isset($_POST['page']) ? intval($_POST['page']) : 0;
    	
    	//获取总页数
    	$count = Order::find(array(
    			'conditions'=> "del=?1 and back>?2 and uid=?3",
    			'bind'		=> array(1=>0, 2=>'0', 3=>$uid)
    	));
    	$count = $count->count();
    	$the_page = ceil($count/6);
    	
    	$refund_status = array('1'=>'退款申请中','2'=>'已退款','3'=>'处理中','4'=>'已拒绝');
    	
    	$order = Order::find(array(
    			'conditions'=> 'del=?1 and back>?2 and uid=?3',
    			'bind'		=> array(1=>0, 2=>'0', 3=>intval($uid)),
    			'columns'	=> "id,price,order_sn,product_num,back,back_addtime,price_h,post",
    			'order'		=> 'back_addtime desc',
    			'limit'		=> array('number'=>6, 'offset'=>$pages*6)
    	));
    	$order = $order->toArray();
    	foreach ($order as $n=>$v) {
    		$order[$n]['desc'] = $refund_status[$v['back']];
    		$prolist = OrderProduct::find(array('conditions'=>'order_id=?1', 'bind'=>array(1=>intval($v['id']))));
    		$prolist = $prolist->toArray();
    		$order[$n]['pro'] = array();
    		foreach ($prolist as $k1=>$v1){
    			array_push($order[$n]['pro'], array(
    					'photo_x' => $v1['photo_x'],
    					'pid' => $v1['pid'],
    					'name' => $v1['name'],
    					'price_yh' => $v1['price'],
    					'price' => $v1['price']*$v1['num'],
    					'product_num' => $v1['num']
    			));
    		}
    	}
    	
    	echo json_encode(array('status'=>1,'ord'=>$order));
    	exit();
    }
    
    /**
     * 订单编辑
     */
    public function ordersEditAction(){
    	
    	$order_id = isset($_POST['id']) ? intval($_POST['id']) : '';
    	$type = isset($_POST['type']) ? $_POST['type'] : '';
    	
    	$check_id = Order::findFirst(array('conditions'=>"id=?1 and del=?2", 'bind'=>array(1=>intval($order_id), 2=>0)));
    	if (!$check_id || !$type) {
    		echo json_encode(array('status'=>0,'err'=>'订单信息错误.'.__LINE__));
    		exit();
    	}
    	
    	$data = array();
    	$order = Order::findFirstById($order_id);
    	if ($type==='cancel') {
    		$order->status = 0;
    	}elseif ($type==='receive') {
    		$order->status = 40;
    	}elseif ($type==='refund') {
    		$order->back = 1;
    		$order->back_remark = $_REQUEST['back_remark'];
    	}else{
    		echo json_encode(array('status'=>0,'err'=>'订单信息错误.'.__LINE__));
    		exit();
    	}
    	
    	$result = $order->save();
    	
    	if($result !== false){
    		echo json_encode(array('status'=>1));
    		exit();
    	}else{
    		echo json_encode(array('status'=>0,'err'=>'操作失败.'.__LINE__));
    		exit();
    	}
    }
    
    //***************************
    //  获取订单信息
    //***************************
    public function getOrderInfoAction(){
    	if ($this->request->isPost()){
    		$oid = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    		
    		if (!$oid){ $this->err('数据错误！'); exit(); }
    		
    		$order = Order::orderInfo('id', $oid);
    		if (ModelBase::isObject($order)){
    			$pros = $order->OrderProduct;
    			if ($pros){
    				$pros = $pros->toArray();
    				$vid = intval($order->vid);//优惠券id
    				$pid = intval($order->post);//快递id
    				$rid = intval($order->receiver);//收货人
    				
    				$proZj = 0;
    				foreach ($pros as $k=>$v){
    					$proZj += $v['price'];
    					
    					$attrstr = '';
    					if (trim($v['skuid'], ',')){
    						$sb = new SkuBase();
    						$sta = $sb->skuToAttrs(trim($v['skuid'], ','));
    						foreach ($sta as $k1=>$v1){
    							$attrstr.= $v1['pname'].': '.$v1['name'].'   ';
    						}
    					}
    					$pros[$k]['attrs'] = $attrstr;
    				}
    				$order = $order->toArray();
    				$order['proZj'] = $proZj;
    				$order['addtime'] = date('Y-m-d H:i:s', $order['addtime']);
    				$order['paytime'] = date('Y-m-d H:i:s', $order['paytime']);
    				$order['fhtime'] = date('Y-m-d H:i:s', $order['fhtime']);
    				$order['finishtime'] = date('Y-m-d H:i:s', $order['finishtime']);
    				
    				//获取优惠券
    				$vouArr = array();
    				if ($vid){
    					$v = Voucher::findFirstById($vid);
    					if ($v) $vouArr = $v->toArray();
    				}
    				//获取快递信息
    				$pArr = array('id'=>'0', 'name'=>'快递 免邮', 'price'=>0);
    				if ($pid) {
    					$p = Post::findFirstById($pid);
    					if ($p) $pArr = $p->toArray();
    				}
    				//收货人信息
    				if ($rid){
    					$r = Address::addrInfo('id', $rid);
    					if (ModelBase::isObject($r)){
    						$order['receiver'] = $r->name;
    						$order['tel'] = $r->tel;
    						$order['address'] = $r->address;
    						$order['address_xq'] = $r->address_xq;
    					}
    				}
    				
    				echo json_encode(array('status'=>1, 'orderInfo'=>$order, 'pros'=>$pros, 'vouInfo'=>$vouArr, 'postInfo'=>$pArr));
    			}else $this->err('数据异常！');
    		}else $this->err('数据异常！');
    	}
    }
    
}

