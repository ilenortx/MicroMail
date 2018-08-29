<?php

/**
 * 砍价
 * @author xiao
 *
 */
class CutPriceSpritesController extends AdminBase{

    public function indexAction(){
    	$this->assets
	    	 ->collection('css1')
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css");
	    $this->assets
	    	 ->collection('css2')
	    	 ->addCss("css/static/h-ui.admin/style.css")
	    	 ->addCss("css/custom/marketing/public.css")
	    	 ->addCss("css/custom/marketing/cutPrice.css");
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
    	
    	
    	
    	$this->view->pick("admin/cutPriceSprites/index");
    }
    
    public function cpeditPageAction(){
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
	    
	    $cpId= isset($_GET['cpId']) ? intval($_GET['cpId']) : '';
	    $type = isset($_GET['type']) ? $_GET['type'] : 'add';
	    
	    $cpInfo = array(
	    		'name'=>'','stime'=>'','etime'=>'','cptype'=>''
	    		,'friends'=>'','low_price'=>'','pro_ids'=>'','status'=>''
	    );
	    if ($cpId){
	    	$shopId = $this->session->get('sid');
	    	$cp = CutPriceSprites::findFirstById($cpId);
	    	
	    	if ($cp && $cp->shop_id==$shopId) $cpInfo = $cp->toArray();
	    	if (count($cpInfo)){
	    		$cpInfo['stime'] = date('Y-m-d H:i',$cpInfo['stime']);
	    		$cpInfo['etime'] = date('Y-m-d H:i',$cpInfo['etime']);
	    	}
	    }
	    
	    $this->view->cpInfo = $cpInfo;
    	$this->view->cpId= $cpId;
    	$this->view->type = $type;
    	
    	$this->view->pick("admin/cutPriceSprites/cpedit");
    }
    
    /**
     * 选择产品页面
     */
    public function chooseProPageAction(){
    	$this->assets
	    	 ->addCss("css/main.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js");
    	
	    $choosed = isset($_GET['proIds']) ? trim($_GET['proIds'], ',') : '';
	    
	    $this->view->prolists = json_encode($this->shopProListAction(), true);
	    $this->view->choosed = $choosed?trim($choosed,','):'';
    	
	    $this->view->pick("admin/cutPriceSprites/choosePro");
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
     * 获取产品
     */
    public function getProsAction(){
    	if ($this->request->isPost()){
    		$proIds = isset($_POST['proIds']) ? $_POST['proIds'] : 'false';
    		if ($proIds == 'false'){
    			echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    			exit();
    		}
    		
    		$proArr = array();
    		if (strlen($proIds)){
    			$shopId = $this->session->get('sid');
    			$pros = Product::find("shop_id=$shopId and id in($proIds)");
    			
    			if ($pros) $proArr = $pros->toArray();
    		}
    		
    		echo json_encode(array('status'=>1, 'pros'=>$proArr));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }
    
    /**
     * 获取砍价列表
     */
    public function getCpListAction(){
    	$shopId = $this->session->get('sid');
    	$qtype = isset($_GET['qtype']) ? $_GET['qtype'] : 'all';
    	$status = $qtype=='all'?"status!='S0'":($qtype=='S1'?"status='S1'":($qtype=='S2'?"status='S2'":"status='S3'"));
    	$cps = CutPriceSprites::find("shop_id=$shopId and $status order by addtime desc");
    	
    	$cpArr = array();
    	if ($cps) $cpArr = $cps->toArray();
    	
    	$result = array();
    	for($i=0; $i<count($cpArr); ++$i){
    		$status = $cpArr[$i]['status']=='S1'?'未开始':($cpArr[$i]['status']=='S2'?'进行中':'已结束');
    		array_push($result, array(
    				'eidt'	=> '<a href="#" onclick="cpedit(\'砍价编辑\',\'../CutPriceSprites/cpeditPage?cpId='.$cpArr[$i]['id'].'&type=edit\',\'2\',\'770\',\'710\')">编辑</a> | <a href="#" onclick="cpDel('.$cpArr[$i]['id'].')">删除</a>',
    				'name'	=> $cpArr[$i]['name'],
    				'time'	=> date('Y-m-d H:i',$cpArr[$i]['stime']).'至'.date('Y-m-d H:i',$cpArr[$i]['etime']),
    				'status'=> $status,
    		));
    	}
    	
    	echo json_encode(array('data'=>$result));
    }
    
    /**
     * 砍价编辑
     */
    public function cpEditAction(){
    	if ($this->request->isPost()){
    		$cpId = isset($_POST['cpId']) ? intval($_POST['cpId']) : '';
    		$name = isset($_POST['name']) ? $_POST['name'] : '';
    		$stime = isset($_POST['stime']) ? $_POST['stime'] : '';
    		$etime = isset($_POST['etime']) ? $_POST['etime'] : '';
    		$cptype = isset($_POST['cptype']) ? intval($_POST['cptype']) : '';
    		$friends = isset($_POST['friends']) ? intval($_POST['friends']) : '';
    		$lowPrice = isset($_POST['low_price']) ? intval($_POST['low_price']) : '';
    		$proIds = isset($_POST['pro_ids']) ? $_POST['pro_ids'] : '';
    		$type = isset($_POST['type']) ? $_POST['type'] : '';//操作类型
    		
    		if (!$name || !$friends || !$lowPrice || !$type){
    			echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    			exit();
    		}
    		if ($type=='add'){
    			if (!$proIds || !$stime || !$etime || !$cptype){
    				echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    				exit();
    			}
    		}else if (!$cpId){
    			echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    			exit();
    		}
    		$shopId = $this->session->get('sid');
    		
    		if ($type == 'add'){
    			$cp = new CutPriceSprites();
    			$cp->stime = strtotime($stime);
    			$cp->cptype = $cptype;
    			$cp->friends = $friends;
    			$cp->low_price = $lowPrice;
    			$cp->pro_ids = $proIds;
    			$cp->addtime = time();
    			$cp->status = 'S1';
    			$cp->shop_id = $shopId;
    		}else {
    			$cp = CutPriceSprites::findFirstById($cpId);
    		}
    		$cp->name = $name;
    		$cp->etime = strtotime($etime);
    		
    		if ($cp->save()) {
    			if ($type == 'add'){
    				$pros = explode(',', $proIds);
    				for ($i=0; $i<count($pros); ++$i){
    					$pro = Product::findFirstById($pros[$i]);
    					if ($pro){ $pro->hd_type = '3'; $pro->hd_id = $cp->id; $pro->save(); }
    				}
    			}
    			echo json_encode(array('status'=>1, 'msg'=>'success'));
    		}
    		else json_encode(array('status'=>0, 'msg'=>'操作失败'));
    	}else json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }
    
    /**
     * 删除砍价活动
     */
    public function cpDelAction(){
    	$cpId = isset($_POST['cpId']) ? intval($_POST['cpId']) : '';
    	
    	if (!$cpId) {
    		echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    		exit();
    	}
    	
    	$cp = CutPriceSprites::findFirstById($cpId);
    	
    	if ($cp){
    		$shopId = $this->session->get('sid');
    		if ($cp->shop_id == $shopId){
    			if ($cp->status == 'S2'){
    				echo json_encode(array('status'=>0, 'msg'=>'进行中'));
    				exit();
    			}
    			$cp->status = 'S0';
    			if ($cp->save()){
    				$ucp = CutPriceSpritesList::find("cp_id=$cp->id");//用户砍价
    				if ($ucp){
    					foreach ($ucp as $k){
    						if ($k->cp_result == '1'){ $k->status = 'S2'; $k->cp_result = '2'; $k->save(); }
    					}
    				}
    				$pro = Product::find("hd_id=$cp->id and hd_type='3");//商品活动
    				if ($pro){
    					foreach ($pro as $k){ $k->hd_id = 0; $k->hd_type = '0'; $k->save(); }
    				}
    				
    				echo json_encode(array('status'=>1, 'msg'=>'success'));
    			}
    			else echo json_encode(array('status'=>0, 'msg'=>'操作失败'));
    		}else echo json_encode(array('status'=>0, 'msg'=>'数据异常'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'记录不存在'));
    }
    
}

