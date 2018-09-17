<?php

class OrderController extends AdminBase{

    public function indexAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/layui/layui.css")
	    	 ->addCss("css/pages/admin/public.css")
	    	 ->addCss("css/pages/admin/order/order.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layui/layui.js")
	    	 ->addJs("js/pages/admin/pageOpe.js")
	    	 ->addJs("js/pages/admin/order/orderList.js");
    	
// 	    $this->view->orderlist = $this->allOrderAction();
// 	    $this->view->order_status = array('0'=>'已取消','10'=>'待付款','20'=>'待发货','30'=>'待收货','40'=>'已收货','50'=>'交易完成');
    	
    	$this->view->pick("admin/order/index");
    }
    
    /**
     * 详情页面
     */
    public function showPageAction(){
    	/* $this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/static/h-ui.admin/style.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js")
	    	 ->addJs("js/static/h-ui.admin/H-ui.admin.js")
	    	 ->addJs("lib/My97DatePicker/4.8/WdatePicker.js")
	    	 ->addJs("lib/datatables/1.10.0/jquery.dataTables.min.js")
	    	 ->addJs("lib/laypage/1.2/laypage.js"); */
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/layui/layui.css")
	    	 ->addCss("css/pages/admin/public.css")
	    	 ->addCss("css/pages/admin/order/order.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/jquery/clipboard.min.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("lib/layui/layui.js")
	    	 ->addJs("lib/datatables/1.10.0/jquery.dataTables.min.js")
	    	 ->addJs("js/pages/admin/pageOpe.js")
	    	 ->addJs("js/pages/admin/order/orderShow.js");
    	
	    $oi = $this->orderInfoAction(intval($this->request->get('oid')));
	    $orderPros = $this->orderProsAction();
	    $proTF = 0.00;
	    foreach ($orderPros as $k=>$v){ $proTF += $v['price']; }
	    $oi['proTF'] = $this->numberFormat($proTF);
	    
	    $this->view->prolist = $orderPros;
	    $this->view->postInfo = $this->postInfoAction($oi['post']);
	    $this->view->orderInfo = $oi;
    	$this->view->order_status = array('0'=>'已取消','10'=>'待付款','20'=>'待发货','30'=>'待收货','40'=>'已收货','50'=>'交易完成');
    	
    	$this->view->pick("admin/order/show");
    }
    
    public function dfGodownPageAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/layui/layui.css")
	    	 ->addCss("css/pages/admin/public.css")
	    	 ->addCss("css/pages/admin/order/dfGodown.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/jquery/clipboard.min.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("lib/layui/layui.js")
	    	 ->addJs("lib/datatables/1.10.0/jquery.dataTables.min.js")
	    	 ->addJs("js/pages/admin/pageOpe.js")
	    	 ->addJs("js/pages/admin/order/orderShow.js");
    	
    	$oi = $this->orderInfoAction(intval($this->request->get('oid')));
    	$orderPros = $this->orderProsAction();
    	$proTF = 0.00;
    	foreach ($orderPros as $k=>$v){ $proTF += $v['price']; }
    	$oi['proTF'] = $this->numberFormat($proTF);
    	
    	$this->view->prolist = $orderPros;
    	$this->view->postInfo = $this->postInfoAction($oi['post']);
    	$this->view->orderInfo = $oi;
    	$this->view->order_status = array('0'=>'已取消','10'=>'待付款','20'=>'待发货','30'=>'待收货','40'=>'已收货','50'=>'交易完成');
    	
    	$this->view->pick("admin/order/dfGodown");
    }
    
    /**
     * 获取所有订单
     */
    public function allOrderAction(){
    	$sid = $this->session->get('sid');
    	
    	$orders = Order::find(array(
    			'conditions'=> "shop_id=?1 and del=?2",
    			'bind'		=> array(1=>$sid, 2=>0),
    			'order'		=> "addtime desc"
    	));
    	
    	$orderArr = array();
    	if ($orders){
    		foreach ($orders as $k=>$v){
    			$user = $v->user;
    			$orderArr[$k] = $v->toArray();
    			$orderArr[$k]['name'] = $user->name;
    			$orderArr[$k]['addtime'] = date("Y-m-d H:i:s", $orderArr[$k]['addtime']);
    		}
    		//$orderArr= $orders->toArray();
    	}
    	
    	return $orderArr;
    }
	public function orderListAction(){
		//获取页面参数
		$page = (isset($_GET['page'])&&intval($_GET['page'])) ? intval($_GET['page']) : 0;
		$limit = (isset($_GET['limit'])&&intval($_GET['limit'])) ? intval($_GET['limit']) : 0;
		
		$sid = $this->session->get('sid');
		$orderArr = Order::orderList(array(
				'conditions'=> "shop_id=$sid and del=0",
				'order'		=> "addtime desc",
				'limit'		=> array("number" => $limit, "offset" => $limit*($page-1))
		));
		
		$count = Order::getCount("shop_id=$sid and del=0");
		
		$ptype = array('weixin'=>'微信支付', 'cash'=>'货到付款');
		$status = array('0'=>'<text style="">取消订单</text>',
				'10'=>'<text style="">待付款</text>', '20'=>'<text style="color:red">待发货</text>',
				'30'=>'<text style="">待收货</text>', '40'=>'<text style="color:green">完成</text>',
				'50'=>'<text style="color:green">完成</text>','51'=>'<text style="color:green">完成</text>'
		);
		
		$noteG = array(
				'<img lay-event="openNote" class="gradeImg" style="cursor:pointer;" src="../img/common/note/note_gray.png" />',
				'<img lay-event="openNote" class="gradeImg" style="cursor:pointer;" src="../img/common/note/note_red.png" />',
				'<img lay-event="openNote" class="gradeImg" style="cursor:pointer;" src="../img/common/note/note_yellow.png" />',
				'<img lay-event="openNote" class="gradeImg" style="cursor:pointer;" src="../img/common/note/note_green.png" />',
				'<img lay-event="openNote" class="gradeImg" style="cursor:pointer;" src="../img/common/note/note_blue.png" />',
				'<img lay-event="openNote" class="gradeImg" style="cursor:pointer;" src="../img/common/note/note_purple.png" />',
		);
		foreach ($orderArr as $k=>$v){
			$orderArr[$k]['addtime'] = date('Y-m-d H:i:s', $orderArr[$k]['addtime']);
			$orderArr[$k]['paytime'] = date('Y-m-d H:i:s', $orderArr[$k]['paytime']);
			
			$orderArr[$k]['type'] = $ptype[$orderArr[$k]['type']];
			
			$orderArr[$k]['operate'] = "<a title=\"查看订单详情\" onclick=\"openEditFull('订单详情','../Order/showPage?oid={$orderArr[$k]['id']}')\" class=\"ml-5\" style=\"text-decoration:none\">详情</a> | ";
			$x = $orderArr[$k]['status'];
			if ($orderArr[$k]['status']==20) {
				$orderArr[$k]['operate'] .= "<a title=\"出货\" href=\"../Order/dfGodownPage?oid={$orderArr[$k]['id']}\" class=\"ml-5\" style=\"text-decoration:none;color:#29f\">出货</a> | ";
			}
			$ng = empty($orderArr[$k]['note_grade']) ? 0 : $orderArr[$k]['note_grade'];
			$orderArr[$k]['operate'] .= $noteG[$ng];
			
			
			$orderArr[$k]['status'] = $status[$orderArr[$k]['status']];
			
		}
		
		$this->tableData1($count, $orderArr, 0, '加载成功!');
	}
    
    /**
     * 获取订单信息
     */
    public function orderInfoAction($oid){
    	$order = Order::findFirstById($oid);
    	$oArr = array();
    	if ($order){
    		//地址
    		$address = $order->Address;
    		//优惠券
    		$uvoucher = $order->UserVoucher;
    		
    		$oArr = $order->toArray();
    		if ($address) $oArr['address'] = $address->toArray();
    		else{
    			$oArr['address'] = array(
    					'id'=>'', 'name'=>'', 'tel'=>'', 'sheng'=>'', 'city'=>'',
    					'quyu'=>'', 'address'=>'', 'address_xq'=>'', 'code'=>'','uid'=>'',
    			);
    		}
    		
    		$oArr['voucher'] = array(
    				'id'=>'', 'title'=>'', 'full_money'=>'0.00', 'amount'=>'0.00'
    		);
    		if ($uvoucher) {
    			$voucher = $uvoucher->Voucher;
    			$oArr['voucher']['id'] = $uvoucher->id;
    			$oArr['voucher']['title'] = $voucher->title;
    			$oArr['voucher']['full_money'] = $this->numberFormat($voucher->full_money);
    			$oArr['voucher']['amount'] = $this->numberFormat($voucher->amount);
    		}
    		
    		$payType = array('weixin'=>'微信支付', 'cash'=>'货到付款');
    		$oArr['addtime'] = date('Y-m-d H:i:s', $oArr['addtime']);
    		$oArr['paytime'] = date('Y-m-d H:i:s', $oArr['paytime']);
    		$oArr['type'] = $payType[$oArr['type']];
    	}
    	return $oArr;
    }
    
    /**
     * 邮费
     */
    public function postInfoAction($postId){
    	$post = Post::findFirstById($postId);
    	
    	$postArr = array();
    	if ($post) $postArr= $post->toArray();
    	
    	if (count($postArr) == 0) $postArr = false;
    	
    	return $postArr;
    }
    
    /**
     * 获取订单商品
     */
    public function orderProsAction(){
    	$oid = isset($_GET['oid']) ? intval($this->request->get('oid')) : '';
    	
    	$proArr = array();
    	if ($oid){
    		$pros = OrderProduct::find(array(
    				'conditions'=> "order_id=?1",
    				'bind'		=> array(1=>$oid)
    		));
    		
    		if ($pros) $proArr = $pros->toArray();
    		
    		$sb = new SkuBase();
    		foreach ($proArr as $k=>$v){
    			if (trim($v['skuid'])){
    				$sta = $sb->skuToAttrs(trim($v['skuid'], ','));
    				$attrstr = '';
    				foreach ($sta as $k2=>$v2){
    					$attrstr.= $v2['pname'].': '.$v2['name'].'   ';
    				}
    			}
    			$proArr[$k]['attrs'] = $attrstr;
    		}
    	}
    	return $proArr;
    }
    
    /**
     * 保存订单
     */
    public function saveOrderAction(){
    	if ($this->request->isPost()){
    		$oid = isset($_POST['oid']) ? intval($_POST['oid']) : '';
    		$orderStatus = isset($_POST['order_status']) ? $_POST['order_status'] : '';
    		$kuaidiName = isset($_POST['kuaidi_name']) ? $_POST['kuaidi_name'] : '';
    		$kuaidiNum = isset($_POST['kuaidi_num']) ? $_POST['kuaidi_num'] : '';
    		$note = isset($_POST['note']) ? $_POST['note'] : '';
    		
    		//if (!$oid || empty($orderStatus) || !$kuaidiName || !$kuaidiNum){
    		if (!$oid || empty($orderStatus)){
    			echo json_encode(array('status'=>0, 'msg'=>"数据错误"));
    			exit();
    		}
    		
    		$order = Order::findFirstById($oid);
    		if ($order){
    			$order->kuaidi_name = $kuaidiName;
    			$order->kuaidi_num = $kuaidiNum;
    			$order->status = $orderStatus;
    			$order->note = $note;
    			if ($order->save()) echo json_encode(array('status'=>1, 'msg'=>"success"));
    			else echo json_encode(array('status'=>0, 'msg'=>"保存失败"));
    		}else echo json_encode(array('status'=>0, 'msg'=>"订单不存在"));
    	}else echo json_encode(array('status'=>0, 'msg'=>"请求方式错误"));
    }
    
    /**
     * 修改备注
     */
    public function renoteAction(){
    	if ($this->request->isPost()){
    		$ong = isset($_POST['ong']) ? intval($_POST['ong']) : 0;
    		$onc = isset($_POST['onc']) ? $_POST['onc'] : '';
    		$oid = isset($_POST['oid']) ? intval($_POST['oid']) : 0;
    		
    		if (!$oid) { $this->err('数据错误'); exit(); }
    		
    		$result = Order::renote($oid, $this->session->get('sid'), $ong, $onc);
    		
    		if ($result == 'SUCCESS') $this->msg('success');
    		else if ($result == 'DATAERR') $this->err('数据错误');
    		else if ($result == 'OPEFILE') $this->err('操作失败');
    		else if ($result == 'DATAEXCEPTION') $this->err('数据异常');
    	}else $this->err('请求方式错误');
    }
    
}

