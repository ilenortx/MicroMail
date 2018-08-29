<?php

/**
 * 限时促销
 * @author xiao
 *
 */
class PromotionController extends AdminBase{

    public function indexAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/static/h-ui.admin/style.css")
	    	 ->addCss("css/custom/marketing/public.css")
	    	 ->addCss("css/custom/marketing/promotion.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js")
	    	 ->addJs("js/static/h-ui.admin/H-ui.admin.js")
	    	 ->addJs("lib/My97DatePicker/4.8/WdatePicker.js")
	    	 ->addJs("lib/datatables/1.10.0/jquery.dataTables.min.js")
	    	 ->addJs("lib/laypage/1.2/laypage.js");
    	
    	
    	
    	$this->view->pick("admin/promotion/index");
    }

    /**
     * 编辑页面
     */
    public function peditPageAction(){
    	$this->assets
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
	    	 ->addJs("lib/laypage/1.2/laypage.js");
    	
    	$pIp = isset($_GET['pId']) ? intval($_GET['pId']) : '';
    	$type = isset($_GET['type']) ? $_GET['type'] : 'add';
    	
    	$pInfo = array(
    			'name'=>'','stime'=>'','etime'=>'','pro_id'=>'',
    			'pprice'=>'','maxnum'=>'','status'=>''
    	);
    	if ($pIp){
    		$shopId = $this->session->get('sid');
    		$pi = Promotion::findFirstById($pIp);
    		
    		if ($pi && $pi->shop_id==$shopId) $pInfo = $pi->toArray();
    		if (count($pInfo)){
    			$pInfo['stime'] = date('Y-m-d H',$pInfo['stime']);
    			$pInfo['etime'] = date('Y-m-d H',$pInfo['etime']);
    		}
    	}
    	
    	$this->view->pInfo = $pInfo;
    	$this->view->pId= $pIp;
    	$this->view->type = $type;
    	
    	$this->view->pick("admin/promotion/pedit");
    }
    
    /**
     * 选择产品页面
     */
    public function chooseProPageAction(){
    	$this->assets
	    	 ->addCss("css/main.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js");
    	
    	$choosed = isset($_GET['proId']) ? intval($_GET['proId']) : '';
    	
    	$this->view->prolists = json_encode($this->shopProListAction(), true);
    	$this->view->choosed = $choosed;
    	
    	$this->view->pick("admin/groupBooking/choosePro");
    }
    
    /**
     * 获取店铺商品列表
     */
    public function shopProListAction(){
    	$proArr = array(); $num = 0;
    	$shopId = $this->session->get('sid');
    	
    	$conditions = array(
    			'conditions'=> "shop_id=?1 and del=?2 and hd_type=?3",
    			'bind'		=> array(1=>$shopId, 2=>0, 3=>0)
    	);
    	$count = Product::find($conditions);
    	
    	$pros = Product::find($conditions);
    	
    	if ($pros) $proArr = $pros->toArray();
    	
    	return $proArr;
    }
    
    
    /**
     * 获取促销列表
     */
    public function getPListAction(){
    	$shopId = $this->session->get('sid');
    	$qtype = isset($_GET['qtype']) ? $_GET['qtype'] : 'all';
    	$status = $qtype=='all'?"status!='S0'":($qtype=='S1'?"status='S1'":($qtype=='S2'?"status='S2'":"(status='S3' or status='S4')"));
    	$ps = Promotion::find("shop_id=$shopId and $status order by addtime desc");
    	
    	$pArr = array();
    	if ($ps) $pArr= $ps->toArray();
    	
    	$result = array();
    	for($i=0; $i<count($pArr); ++$i){
    		$status = $pArr[$i]['status']=='S1'?'未开始':($pArr[$i]['status']=='S2'?'进行中':(($pArr[$i]['status']=='S3'?'已结束':'抢光')));
    		array_push($result, array(
    				'eidt'	=> '<a href="#" onclick="pedit(\'团购编辑\',\'../Promotion/peditPage?pId='.$pArr[$i]['id'].'&type=edit\',\'2\',\'770\',\'400\')">编辑</a> | <a href="#" onclick="pDel('.$pArr[$i]['id'].')">删除</a>',
    				'name'	=> $pArr[$i]['name'],
    				'time'	=> date('Y-m-d H',$pArr[$i]['stime']).'至'.date('Y-m-d H',$pArr[$i]['etime']),
    				'status'=> $status,
    		));
    	}
    	
    	echo json_encode(array('data'=>$result));
    }
    
    /**
     * 促销编辑
     */
    public function pEditAction(){
    	if ($this->request->isPost()){
    		$pId = isset($_POST['pId']) ? intval($_POST['pId']) : '';
    		$name = isset($_POST['name']) ? $_POST['name'] : '';
    		$stime = isset($_POST['stime']) ? $_POST['stime'] : '';
    		$etime = isset($_POST['etime']) ? $_POST['etime'] : '';
    		$proId= isset($_POST['proId']) ?  intval($_POST['proId']) : '';
    		$pprice = isset($_POST['pprice']) ? floatval($_POST['pprice']) : '';
    		$type = isset($_POST['type']) ? $_POST['type'] : '';//操作类型
    		
    		if (!$name || !$pprice || !$type){
    			echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    			exit();
    		}
    		if ($type=='add'){
    			if (!$proId || !$stime || !$etime){
    				echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    				exit();
    			}
    		}else if (!$pId){
    			echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    			exit();
    		}
    		$shopId = $this->session->get('sid');
    		
    		if ($type == 'add'){
    			$pi = new Promotion();
    			$pi->stime = strtotime($stime.':00');
    			$pi->addtime = time();
    			$pi->pro_id = $proId;
    			$pi->shop_id = $shopId;
    			$pi->status = 'S1';
    		}else {
    			$pi= Promotion::findFirstById($pId);
    		}
    		$pi->name = $name;
    		$pi->etime = strtotime($etime.':00');
    		$pi->pprice = $pprice;
    		
    		if ($pi->save()) {
    			if ($type == 'add'){
    				$pro = Product::findFirstById($proId);
    				if ($pro){ $pro->hd_type = '1'; $pro->hd_id = $pi->id; $pro->save(); }
    			}
    			echo json_encode(array('status'=>1, 'msg'=>'success'));
    		}
    		else json_encode(array('status'=>0, 'msg'=>'操作失败'));
    	}else json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }
    
    /**
     * 删除团购活动
     */
    public function pDelAction(){
    	$pId= isset($_POST['pId']) ? intval($_POST['pId']) : '';
    	
    	if (!$pId) {
    		echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    		exit();
    	}
    	
    	$pi = Promotion::findFirstById($pId);
    	
    	if ($pi){
    		$shopId = $this->session->get('sid');
    		if ($pi->shop_id == $shopId){
    			if ($pi->status == 'S2'){
    				echo json_encode(array('status'=>0, 'msg'=>'进行中'));
    				exit();
    			}
    			$pi->status = 'S0';
    			if ($pi->save()) {
    				$pro = Product::findFirstById($pi->pro_id);
    				if ($pro && count($pro)) {
    					$pro->hd_type = '0'; $pro->hd_id = 0; 
    					$pro->save();
    				}
    				echo json_encode(array('status'=>1, 'msg'=>'success'));
    			}
    			else echo json_encode(array('status'=>0, 'msg'=>'操作失败'));
    		}else echo json_encode(array('status'=>0, 'msg'=>'数据异常'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'记录不存在'));
    }
    
}

