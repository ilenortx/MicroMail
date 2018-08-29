<?php

class ApiDistributionController extends ApiBase{

	/**
	 * 获取分销商状态
	 */
    public function indexAction(){
		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
		if (!$uid){
			echo json_encode(array('status'=>0, 'err'=>'数据错误'));
			exit();
		}
		
		$d = Distribution::findFirstByUid($uid);
		
		if ($d && count($d->toArray())) {
			if ($d->status == 'S0') echo json_encode(array('status'=>1, 'info'=>$d->toArray()));
			else if ($d->status == 'S1') echo json_encode(array('status'=>0, 'err'=>'申请未通过'));
			else if ($d->status == 'S2') echo json_encode(array('status'=>2, 'info'=>$d->toArray()));
			else if ($d->status == 'S3') echo json_encode(array('status'=>3, 'err'=>'分销商被禁用'));
		}
		else echo json_encode(array('status'=>0, 'err'=>'不存在'));
    }
    
    /**
     * 提交申请
     */
    public function submitSqAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    		$shopId = isset($_POST['shop_id']) ? ($_POST['shop_id']=='all'?1:intval($_POST['shop_id'])) : '';
    		$name = isset($_POST['name']) ? $_POST['name'] : '';
    		$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    		
    		if (!$uid || !$shopId || !$name || !$phone){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误'));
    			exit();
    		}
    		
    		$distribution = new Distribution();
    		$distribution->shop_id = $shopId;
    		$distribution->name = $name;
    		$distribution->phone = $phone;
    		$distribution->addtime = time();
    		$distribution->status = 'S0';
    		
    		if ($distribution->save()) echo json_encode(array('status'=>1, 'msg'=>'申请成功!'));
    		else echo json_encode(array('status'=>0, 'msg'=>'申请失败!'));
    	}
    }

    /**
     * 获取分销商成功订单
     */
    public function orderListAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    		$fxsId = isset($_POST['fxs_id']) ? intval($_POST['fxs_id']) : '';
    		$page = isset($_POST['page']) ? intval($_POST['page']) : 0;
    		
    		if (!$uid || !$fxsId){
    			echo json_encode(array('status'=>0, 'err'=>"数据错误"));
    			exit();
    		}
    		
    		//查询分销商
    		$fxs = Distribution::findFirstById($fxsId);
    		if ($fxs){
    			if ($uid != $fxs->uid){
    				echo json_encode(array('status'=>0, 'err'=>"数据错误"));
    				exit();
    			}
    			
    			$order = Order::find(array(
    					'conditions'=> 'del=?1 and back=?2 and fxs_id=?3 and status=?4',
    					'bind'		=> array(1=>0, 2=>'0', 3=>$fxsId, 4=>50),
    					'limit'		=> array('number'=>15, 'offset'=>$page*15)
    			));
    			$order = $order->toArray();
    			
    			for ($i=0; $i<count($order); ++$i){
    				$order[$i]['finishtime'] = date('Y-m-d H:i:s', $order[$i]['finishtime']);
    			}
    			
    			echo json_encode(array('status'=>1, 'ord'=>$order));
    		}else echo json_encode(array('status'=>0, 'err'=>"分销商不存在"));
    	}else echo json_encode(array('status'=>0, 'err'=>"请求方式错误"));
    }
    
    /**
     * 统计数据
     */
    public function getDatasAction(){
    	$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    	$fxsId = isset($_POST['fxs_id']) ? intval($_POST['fxs_id']) : '';
    	$cds = isset($_POST['cds']) ? $_POST['cds'] : '';
    	$cxdw = isset($_POST['cxdw']) ? $_POST['cxdw'] : '';
    	if (!$uid || !$fxsId|| !$cds || !$cxdw) {
    		echo json_encode(array('status'=>0,'err'=>'登录状态异常'));
    		exit();
    	}
    	
    	$dArr = array();
    	if ($cxdw == '1'){
    		$d = Order::find(array(
    				'conditions'=> 'del=?1 and back=?2 and fxs_id=?3 and status=?4',
    				'bind'		=> array(1=>0, 2=>'0', 3=>$fxsId, 4=>50),
    				'columns'	=> "sum(price_h) as price_h, FROM_UNIXTIME(addtime,'%Y') as time",
    				'group'		=> 'time'
    		));
    	}else if ($cxdw == '2'){
    		$d = Order::find(array(
    				'conditions'=> "del=?1 and back=?2 and fxs_id=?3 and FROM_UNIXTIME(addtime,'%Y')=?4 and status=?5",
    				'bind'		=> array(1=>0, 2=>'0', 3=>$fxsId, 4=>$cds, 5=>50),
    				'columns'	=> "sum(price_h) as price_h, FROM_UNIXTIME(addtime,'%Y-%c') as time",
    				'group'		=> "time"
    		));
    	}else if ($cxdw == '3'){
    		$d = Order::find(array(
    				'conditions'=> "del=?1 and back=?2 and fxs_id=?3 and FROM_UNIXTIME(addtime,'%Y-%c')=?4 and status=?5",
    				'bind'		=> array(1=>0, 2=>'0', 3=>$fxsId, 4=>$cds, 5=>50),
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
    	$fxsId = isset($_POST['fxs_id']) ? intval($_POST['fxs_id']) : '';
    	if (!$fxsId){
    		echo json_encode(array('status'=>0, 'err'=>'参数错误'));
    		exit();
    	}
    	
    	$total = 0; $nowMonth = 0; $ktx = 0;
    	//总收入
    	$tm = Order::find(array(
    			'conditions'=> "fxs_id=$fxsId and del=0 and status=50",
    			'columns'	=> "sum(price_h) as total"
    	));
    	$total = ($tm&&count($tm->toArray())&&$tm->toArray()[0]['total']) ? $tm->toArray()[0]['total'] : 0;
    	
    	//当月收入
    	$dy = date('Y-m', time());
    	$nm = Order::find(array(
    			'conditions'=> "fxs_id=$fxsId and del=0 and status=50 and FROM_UNIXTIME(finishtime,'%Y-%m')='{$dy}'",
    			'columns'	=> "sum(price_h) as nm"
    	));
    	$nowMonth= ($nm&&count($nm->toArray())&&$nm->toArray()[0]['nm']) ? $nm->toArray()[0]['nm'] : 0;
    	
    	//可提现
    	$km = MonthSumFxs::find(array(
    			'conditions'=> "fxs_id=$fxsId and status='S0'",
    			'columns'	=> "sum(amount) as ktx"
    	));
    	$ktx= ($km&&count($km->toArray())&&$km->toArray()[0]['ktx']) ? $km->toArray()[0]['ktx'] : 0;
    	
    	echo json_encode(array('status'=>1, 'tm'=>$total, 'nm'=>$nowMonth, 'km'=>$ktx));
    }
    
    /**
     * 查询月统计
     */
    public function monthSumListAction(){
    	$fxsId = isset($_POST['fxs_id']) ? intval($_POST['fxs_id']) : '';
    	if (!$fxsId){
    		echo json_encode(array('status'=>0, 'err'=>'参数错误'));
    		exit();
    	}
    	
    	$msl = MonthSumFxs::find("fxs_id=$fxsId and status='S0'");
    	
    	$msArr = array();
    	if ($msl && count($msl->toArray())) $msArr = $msl->toArray();
    	
    	echo json_encode(array('status'=>1, 'msl'=>$msArr));
    }
    
    /**
     * 提现申请
     */
    public function txRequestAction(){
    	if ($this->request->isPost()){
    		$fxsId= isset($_POST['fxs_id']) ? intval($_POST['fxs_id']) : '';
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    		$year = isset($_POST['year']) ? intval($_POST['year']) : '';
    		$month = isset($_POST['month']) ? intval($_POST['month']) : '';
    		
    		if (!$fxsId || !$uid || !$year|| !$month){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误'));
    			exit();
    		}
    		
    		$month = $month<10 ? '0'.$month : '';
    		
    		//分销商验证
    		$fxs = Distribution::findFirstById($fxsId);
    		
    		if ($fxs && $fxs->uid==$uid){
    			//查询月统计
    			$ms = MonthSumFxs::findFirst("fxs_id=$fxsId and year='$year' and month='$month'");
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

