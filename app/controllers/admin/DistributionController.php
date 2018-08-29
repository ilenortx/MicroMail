<?php

class DistributionController extends AdminBase{

    public function indexAction(){

    }
    
    /**
     * 待审核
     */
    public function sqListPageAction(){
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
    	
	    $this->view->sqList = $this->untgSqListAction();
    	
    	$this->view->pick("admin/distribution/sqList");
    }
    
    /**
     * 所有分销商
     */
    public function allfxsPageAction(){
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
    	
	    $this->view->sqList = $this->fxsListAction();
    	
    	$this->view->pick("admin/distribution/distribution");
    }
    
    /**
     * 提现页面
     */
    public function withdrawDepositAction(){
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
    	
    	$this->view->txList = $this->txListAction();
    	
    	$this->view->pick("admin/distribution/withdrawDeposit");
    }
    
    /**
     * 提现详情页
     */
    public function txdPageAction(){
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
    	
    	$msid = isset($_GET['msid']) ? intval($_GET['msid']) : false;
    	
    	$msInfo = $this->txInfoAction($msid);
    	$this->view->txInfo = $msInfo;
    	$this->view->msid = $msid;
    	
    	$this->view->pick("admin/distribution/txdPage");
    }
    
    /**
     * 获取所有未通过审核申请
     */
    public function untgSqListAction(){
    	$list = Distribution::find("status='S0' or status='S1'");
    	
    	$dArr = array();
    	if ($list) $dArr = $list->toArray();
    	for ($i=0; $i<count($dArr); ++$i){
    		$dArr[$i]['addtime'] = date('Y-m-d H:i:s', $dArr[$i]['addtime']);
    	}
    	
    	return $dArr;
    }

    /**
     * 获取所有分销商列表
     */
    public function fxsListAction(){
    	$list = Distribution::find("status='S2' or status='S3'");
    	
    	$dArr = array();
    	if ($list) $dArr = $list->toArray();
    	for ($i=0; $i<count($dArr); ++$i){
    		$dArr[$i]['addtime'] = date('Y-m-d H:i:s', $dArr[$i]['addtime']);
    	}
    	
    	return $dArr;
    }
    
    /**
     * 审核
     */
    public function auditAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? intval($_POST['id']) : '';
    		$status = isset($_POST['status']) ? $_POST['status'] : '';
    		
    		if (!$id || !$status){
    			echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    			exit();
    		}
    		
    		$sq = Distribution::findFirstById($id);
    		if ($sq){
    			$sq->status = $status;
    			if ($sq->save()) echo json_encode(array('status'=>1, 'msg'=>'success'));
    		}else echo json_encode(array('status'=>0, 'msg'=>'申请不存在'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }
    
    /**
     * 提现列表
     */
    public function txListAction(){
    	$shopId = $this->session->get('sid');
    	$txArr = array();
    	$mss = MonthSumFxs::find();
    	if ($mss) {
    		foreach ($mss as $k=>$v){
    			$fxs = $v->Distribution;
    			$v->addtime = $v->addtime?date('Y-m-d H:i:s', $v->addtime):'';
    			$v->sqtxtime = $v->sqtxtime?date('Y-m-d H:i:s', $v->sqtxtime):'';
    			$v->txtime = $v->txtime?date('Y-m-d H:i:s', $v->txtime):'';
    			$txArr[$k] = $v->toArray();
    			$txArr[$k][fxs] = $fxs->toArray();
    		}
    	}
    	
    	return $txArr;
    }
    
    /**
     * 获取提现信息
     */
    public function txInfoAction($msid){
    	$ms = MonthSumFxs::findFirstById($msid);
    	
    	$info = array();
    	if ($ms) {
    		$info = $ms->toArray();
    		$fxs = $ms->Distribution;
    		$info['fxs'] = $fxs->toArray();
    		$info['addtime'] = date('Y-m-d H:i:s', $info['addtime']);
    		$info['sqtxtime'] = date('Y-m-d H:i:s', $info['sqtxtime']);
    		$info['txtime'] = date('Y-m-d H:i:s', $info['txtime']);
    	}
    	
    	return count($info) ? $info : false;
    }
    
    /**
     * 提现操作
     */
    public function dotxAction(){
    	if ($this->request->isPost()){
    		$msid = isset($_POST['msid']) ? intval($_POST['msid']) : '';
    		$type = isset($_POST['type']) ? $_POST['type']: '';
    		
    		if (!$msid || !$type){
    			echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    			exit();
    		}
    		
    		if ($this->session->get('scType') == 'ST0'){
    			$status = $type=='T0' ? 'S3' : 'S2';
    			$ms = MonthSumFxs::findFirstById($msid);
    			if ($ms){
    				$ms->status = $status;
    				if ($type=='T0') $ms->txtime = time();
    				if ($ms->save()) echo json_encode(array('status'=>1, 'msg'=>'success'));
    				else echo json_encode(array('status'=>0, 'msg'=>'操作失败'));
    			}else echo json_encode(array('status'=>0, 'msg'=>'记录不存在'));
    		}else echo json_encode(array('status'=>0, 'msg'=>'权限不够'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }
    
}

