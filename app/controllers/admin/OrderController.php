<?php

class OrderController extends AdminBase{

    public function indexAction(){
    	$this->assets
	    	 ->collection('css1')
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css");
	    $this->assets
	    	 ->collection('css2')
	    	 ->addCss("css/static/h-ui.admin/style.css");
	    $this->assets
	    	 ->collection('js1')
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js")
	    	 ->addJs("js/static/h-ui.admin/H-ui.admin.js");
	    $this->assets
	    	 ->collection('js2')
	    	 ->addJs("lib/My97DatePicker/4.8/WdatePicker.js")
	    	 ->addJs("lib/datatables/1.10.0/jquery.dataTables.min.js")
	    	 ->addJs("lib/laypage/1.2/laypage.js");
    	
	    $this->view->orderlist = $this->allOrderAction();
	    $this->view->order_status = array('0'=>'已取消','10'=>'待付款','20'=>'待发货','30'=>'待收货','40'=>'已收货','50'=>'交易完成');
    	
    	$this->view->pick("admin/order/index");
    }
    
    /**
     * 详情页面
     */
    public function showPageAction(){
    	$this->assets
	    	 ->collection('css1')
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css");
	    $this->assets
	    	 ->collection('css2')
	    	 ->addCss("css/static/h-ui.admin/style.css");
	    $this->assets
	    	 ->collection('js1')
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js")
	    	 ->addJs("js/static/h-ui.admin/H-ui.admin.js");
	    $this->assets
	    	 ->collection('js2')
	    	 ->addJs("lib/My97DatePicker/4.8/WdatePicker.js")
	    	 ->addJs("lib/datatables/1.10.0/jquery.dataTables.min.js")
	    	 ->addJs("lib/laypage/1.2/laypage.js");
    	
	    $oi = $this->orderInfoAction(intval($this->request->get('oid')));
	    $this->view->prolist = $this->orderProsAction();
	    $this->view->postInfo = $this->postInfoAction($oi['post']);
	    $this->view->orderInfo = $oi;
    	$this->view->order_status = array('0'=>'已取消','10'=>'待付款','20'=>'待发货','30'=>'待收货','40'=>'已收货','50'=>'交易完成');
    	
    	$this->view->pick("admin/order/show");
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

    /**
     * 获取订单信息
     */
    public function orderInfoAction($oid){
    	$order = Order::findFirstById($oid);
    	$oArr = array();
    	if ($order){
    		$address = $order->Address;
    		$oArr = $order->toArray();
    		if ($address) $oArr['address'] = $address->toArray();
    		else{
    			$oArr['address'] = array(
    					'id'=>'', 'name'=>'', 'tel'=>'', 'sheng'=>'', 'city'=>'',
    					'quyu'=>'', 'address'=>'', 'address_xq'=>'', 'code'=>'','uid'=>'',
    			);
    		}
    		
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
    
}

