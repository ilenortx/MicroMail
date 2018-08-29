<?php

/**
 * 个人店铺接口
 * @author xiao
 *
 */
class ApiShopController extends ApiBase{

	/**
	 * 获取店铺信息
	 */
    public function indexAction(){
		if ($this->request->isPost()){
			$uid = (isset($_POST['uid'])&&intval($_POST['uid'])) ? intval($_POST['uid']) : '';
			
			if (!$uid){
				echo json_encode(array('status'=>0, 'err'=>'登录状态异常'));
				exit();
			}
			
			$siArr = array();
			$shop = Shangchang::findFirstByUid($uid);
			
			if ($shop) {
				$amount = 0; $num = 0;
				
				$oa = Order::find(array(
						'conditions'=> "del=?1 and back=?2 and shop_id=?3 and status>=?4 and FROM_UNIXTIME(addtime,'%Y-%c-%d')=?5",
						'bind'		=> array(1=>0, 2=>'0', 3=>$shop->id, 4=>20, 5=>date("Y-m-d",time())),
						'columns'	=> "sum(price_h) as price_h, count(id) as num"
				));
				if ($oa) {
					$oa= $oa->toArray();
					if (count($oa)){
						
					}
					$amount = intval($oa[0]['price_h']) ? intval($oa[0]['price_h']) : 0;
					$num = intval($oa[0]['num']) ? intval($oa[0]['num']) : 0;
				}
				
				echo json_encode(array('status'=>1, 'shopInfo'=>$shop->toArray(), 'amount'=>$amount, 'orderNum'=>$num));
			}else echo json_encode(array('status'=>0, 'err'=>'店铺不存在!'));
		}
    }
    
    /**
     * 获取店铺信息
     */
    public function shopInfoAction(){
    	if ($this->request->isPost()){
    		$shopId = isset($_POST['shop_id']) ? $_POST['shop_id'] : '';
    		
    		if (!$shopId || ($shopId!='all'&&!intval($_POST['shop_id']))){
    			echo json_encode(array('status'=>0, 'err'=>"参数错误"));
    			exit();
    		}
    		
    		if ($shopId == 'all') $shopId = 1;
    		
    		$shop = Shangchang::findFirstById($shopId);
    		
    		if ($shop && count($shop->toArray())){
    			echo json_encode(array('status'=>1, 'shopInfo'=>$shop->toArray()));
    		}else echo json_encode(array('status'=>0, 'err'=>"店铺不存在"));
    	}else echo json_encode(array('status'=>0, 'err'=>"请求方式错误"));
    }
    
    /**
     * 获取订单记录
     */
    public function orderListAction(){
    	$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    	$shopId = isset($_POST['shop_id']) ? intval($_POST['shop_id']) : '';
    	if (!$uid || !$shopId) {
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
    			case 'deliver':
    				$status = '20';
    				break;
    			case 'receive':
    				$status = '30';
    				break;
    			case 'evaluate':
    				$status = '40';
    				break;
    			case 'finish':
    				$status = '40,50';
    				break;
    			default:
    				$status = '20';
    				break;
    		}
    	}
    	
    	//获取总页数
    	$count = Order::find(array(
    			'conditions'=> "del=?1 and back=?2 and shop_id=?3 and status in(?4)",
    			'bind'		=> array(1=>0, 2=>'0', 3=>$shopId, 4=>$status)
    	));
    	$count = $count->count();
    	
    	$eachpage = 7;
    	
    	$order_status = array('20'=>'待发货','30'=>'待收货','40'=>'待评价','50'=>'交易完成','51'=>'交易关闭');
    	
    	$order = Order::find(array(
    			'conditions'=> 'del=?1 and back=?2 and shop_id=?3 and status in(?4)',
    			'bind'		=> array(1=>0, 2=>'0', 3=>$shopId, 4=>$status),
    			'limit'		=> array('number'=>7, 'offset'=>$pages*7)
    	));
    	$order = $order->toArray();
    	
    	echo json_encode(array('status'=>1, 'ord'=>$order, 'eachpage'=>$eachpage));
    	exit();
    }

    /**
     * 退款记录
     */
    public function orderRefundAction(){
    	$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    	$shopId = isset($_POST['shop_id']) ? intval($_POST['shop_id']) : '';
    	if (!$uid || !$shopId) {
    		echo json_encode(array('status'=>0,'err'=>'登录状态异常'));
    		exit();
    	}
    	
    	//分页
    	$pages = isset($_POST['page']) ? intval($_POST['page']) : 0;
    	
    	//获取总页数
    	$count = Order::find(array(
    			'conditions'=> "del=?1 and back>?2 and shop_id=?3",
    			'bind'		=> array(1=>0, 2=>'0', 3=>$shopId)
    	));
    	$count = $count->count();
    	$the_page = ceil($count/6);
    	
    	$refund_status = array('1'=>'退款申请中','2'=>'已退款','3'=>'处理中','4'=>'已拒绝');
    	
    	$order = Order::find(array(
    			'conditions'=> 'del=?1 and back>?2 and shop_id=?3',
    			'bind'		=> array(1=>0, 2=>'0', 3=>$shopId),
    			'columns'	=> "id,price,order_sn,product_num,back,back_addtime",
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
     * 订单信息
     */
    public function orderInfoAction(){
    	$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    	$shopId = isset($_POST['shop_id']) ? intval($_POST['shop_id']) : '';
    	$orderSn = isset($_POST['order_sn']) ? $_POST['order_sn'] : '';
    	if (!$uid || !$shopId || !$orderSn) {
    		echo json_encode(array('status'=>0,'err'=>'登录状态异常'));
    		exit();
    	}
    	
    	$order_status = array('20'=>'待发货','30'=>'待收货','40'=>'待评价','50'=>'交易完成','51'=>'交易关闭');
    	
    	$order = Order::find(array(
    			'conditions'=> 'del=?1 and back=?2 and shop_id=?3 and order_sn=?4',
    			'bind'		=> array(1=>0, 2=>'0', 3=>$shopId, 4=>$orderSn)
    	));
    	$order = $order->toArray();
    	foreach ($order as $n=>$v){
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
    	
    	echo json_encode(array('status'=>1, 'orderInfo'=>$order[0]));
    	exit();
    }
    
    /**
     * 统计数据
     */
    public function getDatasAction(){
    	$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    	$shopId = isset($_POST['shop_id']) ? intval($_POST['shop_id']) : '';
    	$cds = isset($_POST['cds']) ? $_POST['cds'] : '';
    	$cxdw = isset($_POST['cxdw']) ? $_POST['cxdw'] : '';
    	if (!$uid || !$shopId || !$cds || !$cxdw) {
    		echo json_encode(array('status'=>0,'err'=>'登录状态异常'));
    		exit();
    	}
    	
    	$dArr = array();
    	if ($cxdw == '1'){
    		$d = Order::find(array(
    				'conditions'=> 'del=?1 and back=?2 and shop_id=?3 and status>=?4',
    				'bind'		=> array(1=>0, 2=>'0', 3=>$shopId, 4=>20),
    				'columns'	=> "sum(price_h) as price_h, FROM_UNIXTIME(addtime,'%Y') as time",
    				'group'		=> 'time'
    		));
    	}else if ($cxdw == '2'){
    		$d = Order::find(array(
    				'conditions'=> "del=?1 and back=?2 and shop_id=?3 and FROM_UNIXTIME(addtime,'%Y')=?4 and status>=?5",
    				'bind'		=> array(1=>0, 2=>'0', 3=>$shopId, 4=>$cds, 5=>20),
    				'columns'	=> "sum(price_h) as price_h, FROM_UNIXTIME(addtime,'%Y-%c') as time",
    				'group'		=> "time"
    		));
    	}else if ($cxdw == '3'){
    		$d = Order::find(array(
    				'conditions'=> "del=?1 and back=?2 and shop_id=?3 and FROM_UNIXTIME(addtime,'%Y-%c')=?4 and status>=?5",
    				'bind'		=> array(1=>0, 2=>'0', 3=>$shopId, 4=>$cds, 5=>20),
    				'columns'	=> "sum(price_h) as price_h, FROM_UNIXTIME(addtime,'%Y-%c-%d') as time",
    				'group'		=> "time"
    		));
    	}
    	
    	if ($d) $dArr = $d->toArray();
    	echo json_encode(array('status'=>1, 'datas'=>$dArr));
    	exit();
    }
    
    /**
     * 资产
     */
    public function propertyAction(){
    	$shopId = isset($_POST['shop_id']) ? intval($_POST['shop_id']) : '';
    	if (!$shopId){
    		echo json_encode(array('status'=>0, 'err'=>'参数错误'));
    		exit();
    	}
    	
    	$total = 0; $nowMonth = 0; $ktx = 0;
    	//总收入
    	$tm = Order::find(array(
    			'conditions'=> "shop_id=$shopId and del=0 and status=50 and type='weixin'",
    			'columns'	=> "sum(price_h) as total"
    	));
    	$total = ($tm&&count($tm->toArray())&&$tm->toArray()[0]['total']) ? $tm->toArray()[0]['total'] : 0;
    	
    	//当月收入
    	$dy = date('Y-m', time());
    	$nm = Order::find(array(
    			'conditions'=> "shop_id=$shopId and del=0 and status=50 and type='weixin' and finishtime='{$dy}'",
    			'columns'	=> "sum(price_h) as nm"
    	));
    	$nowMonth= ($nm&&count($nm->toArray())&&$nm->toArray()[0]['nm']) ? $nm->toArray()[0]['nm'] : 0;
    	
    	//可提现
    	$km = MonthSum::find(array(
    			'conditions'=> "shop_id=$shopId and status='S0'",
    			'columns'	=> "sum(amount) as ktx"
    	));
    	$ktx= ($km&&count($km->toArray())&&$km->toArray()[0]['ktx']) ? $km->toArray()[0]['ktx'] : 0;
    	
    	echo json_encode(array('status'=>1, 'tm'=>$total, 'nm'=>$nowMonth, 'km'=>$ktx));
    }
    
    /**
     * 查询月统计
     */
    public function monthSumListAction(){
    	$shopId = isset($_POST['shop_id']) ? intval($_POST['shop_id']) : '';
    	if (!$shopId){
    		echo json_encode(array('status'=>0, 'err'=>'参数错误'));
    		exit();
    	}
    	
    	$msl = MonthSum::find("shop_id=$shopId and status='S0'");
    	
    	$msArr = array();
    	if ($msl && count($msl->toArray())) $msArr = $msl->toArray();
    	
    	echo json_encode(array('status'=>1, 'msl'=>$msArr));
    }
    
    /**
     * 提现申请
     */
    public function txRequestAction(){
    	if ($this->request->isPost()){
    		$shopId = isset($_POST['shop_id']) ? intval($_POST['shop_id']) : '';
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    		$year = isset($_POST['year']) ? intval($_POST['year']) : '';
    		$month = isset($_POST['month']) ? intval($_POST['month']) : '';
    		
    		if (!$shopId || !$uid|| !$year|| !$month){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误'));
    			exit();
    		}
    		
    		$month = $month<10 ? '0'.$month : '';
    		
    		//商城验证
    		$sc = Shangchang::findFirstByUid($uid);
    		
    		if ($sc && $sc->id==$shopId){
    			//查询月统计
    			$ms = MonthSum::findFirst("shop_id=$shopId and year='$year' and month='$month'");
    			if ($ms && count($ms)){
    				$ms->status = 'S1';
    				$ms->sqtxtime = time();
    				if ($ms->save()){
    					echo json_encode(array('status'=>1, 'msg'=>'申请成功!'));
    				}else echo json_encode(array('status'=>0, 'err'=>'申请失败'));
    			}else echo json_encode(array('status'=>0, 'err'=>'记录不存在'));
    		}else echo json_encode(array('status'=>0, 'err'=>'数据错误'));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误'));
    }
    
}

