<?php

class VoucherController extends AdminBase{

	/**
	 * 优惠卷列表
	 */
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
    	
	    $this->view->vouLists = $this->vouListAction();
    	
    	$this->view->pick("admin/voucher/index");
    }
    
    /**
     * 添加优惠券
     */
    public function addPageAction(){
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
    	
	    	 
	    $vid = (isset($_GET['vid'])&&intval($_GET['vid'])) ? intval($_GET['vid']) : '';
	    $this->view->vinfo = $this->vouInfoAction($vid);
	    $this->view->vid = $vid;
    	
    	$this->view->pick("admin/voucher/add");
    }
    
    /**
     * 选择商品页面
     */
    public function chooseProPageAction(){
    	$this->assets
	    	 ->addCss("css/main.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js");
    	
    	
	    $tuijian = isset($_GET['tuijian']) ? $_GET['tuijian'] : '';
	    $page = isset($_GET['page']) ? intval($_GET['page']) : 0;
	    
	    $qresurt = $this->shopProListAction($page, $tuijian);
	    $prolist = $qresurt[1];
	    foreach ($prolist as $k=>$v){
	    	$cn = Category::findFirstById(intval($v['cid']));
	    	$prolist[$k]['cat_name']= $cn ? $cn->name : '';
	    }
	    $this->view->prolist = $prolist;
	    $this->view->tuijian = $tuijian;
	    $this->view->page = $page;
	    $this->view->page_index = $this->pageIndex($qresurt[0], ceil($qresurt[0]/10), $page);
    	
    	$this->view->pick("admin/voucher/choose_pro");
    }
    
    /**
     * 获取优惠券列表
     */
    public function vouListAction(){
    	$vous = Voucher::find(array(
    			'conditions'=> "shop_id=?1 and del=?2",
    			'bind'		=> array(1=>$this->session->get('sid'), 2=>0)
    	));
    	
    	$vouArr = array();
    	if ($vous) $vouArr = $vous->toArray();
    	
    	foreach ($vouArr as $k=>$v){
    		$vouArr[$k]['start_time'] = date('Y-m-d 00:00:00', $vouArr[$k]['start_time']);
    		$vouArr[$k]['end_time'] = date('Y-m-d 23:59:59', $vouArr[$k]['end_time']);
    	}
    	
    	return $vouArr;
    }

    /**
     * 获取优惠券信息
     */
    public function vouInfoAction($vid){
    	$vinfo = array(
    			'title'=>'', 'start_time'=>'', 'end_time'=>'', 
    			'full_money'=>'', 'amount'=>'', 'point'=>'',
    			'count'=>'', 'proid'=>'', 'id'=>'', 'pro_list'=>array()
    	);
    	
    	$vou = Voucher::findFirstById($vid);
    	
    	if ($vou) $vinfo = $vou->toArray();
    	if (!empty($vinfo['start_time']) && !empty($vinfo['end_time'])){
    		$vinfo['start_time'] = date('Y-m-d', $vinfo['start_time']);
    		$vinfo['end_time'] = date('Y-m-d', $vinfo['end_time']);
    	}
    	if (!empty($vinfo['proid']) && $vinfo['proid']!='all'){
    		$proid = explode(',', trim($vinfo['proid'], ','));
    		for ($i=0; $i<count($proid); ++$i){
    			$pid = intval($proid[$i]);
    			
    			if ($pid){
    				$pro = Product::findFirstById($pid);
    				if ($pro) array_push($vinfo['pro_list'], $pro->photo_x);
    			}
    		}
    	}
    	return $vinfo;
    }
    
    /**
     * 保存优惠券
     */
    public function vouSaveAction(){
    	if ($this->request->isPost()){
    		$title = isset($_POST['title']) ? $_POST['title'] : '';
    		$stime = isset($_POST['start_time']) ? $_POST['start_time'] : '';
    		$etime = isset($_POST['end_time']) ? $_POST['end_time'] : '';
    		$full_money= isset($_POST['full_money']) ? $_POST['full_money'] : '';
    		$amount= isset($_POST['amount']) ? $_POST['amount'] : '';
    		$point= isset($_POST['point']) ? $_POST['point'] : '';	//积分
    		$count= isset($_POST['count']) ? $_POST['count'] : '';	//发行数量
    		$proid= isset($_POST['proid']) ? $_POST['proid'] : '';	//产品id
    		$vid = isset($_POST['id']) ? intval($_POST['id']) : '';
    		
    		if (!empty($stime) || !empty($etime) || !empty($full_money) || !empty($amount) || !empty($count)){
    			//
    			if (!empty($vid)){
    				$vou = Voucher::findFirstById($vid);
    			}else {
    				$vou = new Voucher();
    				$vou->addtime = time();
    				$vou->shop_id = $this->session->get('sid');
    			}
    			$vou->title = $title;
    			$vou->start_time = strtotime($stime.' 00:00:00');
    			$vou->end_time = strtotime($etime.' 23:59:59');
    			$vou->full_money = $full_money;
    			$vou->amount = $amount;
    			$vou->point = $point;
    			$vou->count = $count;
    			$vou->proid = $proid;
    			
    			if ($vou->save()) {
    				if ($vid) echo "<script> window.location.href='../Voucher/index'; </script>";
    				else echo "<!doctype html><html lang='en'><head><meta charset='UTF-8'></head><body style='background-color:#fff'><div style='width:200px;height:100px;background:#000;border:1px solid #f3f3f3;border-radius:5px;position:absolute;left:50%;top:50%;margin:-50px -100px;'><div style='width:100%;height:50px;color:#fff;font-size:16px;line-height:40px;padding-left:30px;'>添加成功!</div><button id='btn' style='width:70px;height:30px;background:#000;color:#fff;font-size:16px;margin:5px 65px;border:1px solid #f3f3f3;border-radius:5px;'>确定</button></div></body></html><script>function jump(){ window.location.href='../Voucher/addPage'; }window.setTimeout('jump()', 1000);var i=5;var btn = document.getElementById('btn'); btn.onclick = function(){ jump(); } </script>";
    			}else {
    				echo "<!doctype html><html lang='en'><head><meta charset='UTF-8'></head><body style='background-color:#fff'><div style='width:200px;height:100px;background:#000;border:1px solid #f3f3f3;border-radius:5px;position:absolute;left:50%;top:50%;margin:-50px -100px;'><div style='width:100%;height:50px;color:#fff;font-size:16px;line-height:40px;padding-left:30px;'>添加成功!</div><button id='btn' style='width:70px;height:30px;background:#000;color:#fff;font-size:16px;margin:5px 65px;border:1px solid #f3f3f3;border-radius:5px;'>确定</button></div></body></html><script>function jump(){ window.location.href='../Voucher/addPage?vid={$vid}'; }window.setTimeout('jump()', 1000);var i=5;var btn = document.getElementById('btn'); btn.onclick = function(){ jump(); } </script>";
    			}
    		}
    	}
    }
    
    /**
     * 获取店铺商品列表
     */
    public function shopProListAction($page=0, $tuijian=''){
    	$proArr = array(); $num = 0;
    	$shopId = $this->session->get('sid');
    	
    	$conditions = array(
    			'conditions'=> "shop_id=?1 and del=?2",
    			'bind'		=> array(1=>$shopId, 2=>0)
    	);
    	$conditions1 = array(
    			'conditions'=> "shop_id=?1 and del=?2",
    			'bind'		=> array(1=>$shopId, 2=>0),
    			'limit'		=> array('number'=>10, 'offset'=>$page*10)
    	);
    	if (!empty($tuijian) || $tuijian=='0'){
    		$conditions['conditions'] .= " and type=?3";
    		$conditions['bind'][3] = $tuijian;
    		
    		$conditions1['conditions'] .= " and type=?3";
    		$conditions1['bind'][3] = $tuijian;
    	}
    	$count = Product::find($conditions);
    	
    	if ($count){
    		$num= $count->count();
    		
    		$pros = Product::find($conditions1);
    		
    		if ($pros) $proArr = $pros->toArray();
    	}
    	
    	return array($num, $proArr);
    }
    
    /**
     * 删除优惠券
     */
    public function delVouAction(){
    	if ($this->request->isPost()){
    		$vid = (isset($_POST['vid'])&&intval($_POST['vid'])) ? intval($_POST['vid']) : '';
    		if ($vid){
    			$vou = Voucher::findFirstById($vid);
    			if ($vou){
    				if ($vou->delete()) echo json_encode(array('status'=>1, 'msg'=>'success'));
    				else echo json_encode(array('status'=>0, 'msg'=>'操作失败!'));
    			}else echo json_encode(array('status'=>0, 'msg'=>'优惠券不存在!'));
    		}else echo json_encode(array('status'=>0, 'msg'=>'操作失败!'));
    	}
    }
    
}

