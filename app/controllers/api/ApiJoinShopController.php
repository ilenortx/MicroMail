<?php

/**
 * 商城入驻
 * @author xiao
 *
 */
class ApiJoinShopController extends ApiBase{

    public function indexAction(){

    }
    
    /**
     * 提交入驻信息
     */
    public function subJoinAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['user_id']) ? intval($_POST['user_id']) : '';
    		$region = isset($_POST['region']) ? $_POST['region'] : '';
    		$saleType = isset($_POST['sale_type']) ? $_POST['sale_type'] : '';
    		$uname = isset($_POST['uname']) ? $_POST['uname'] : '';
    		$utel = isset($_POST['utel']) ? $_POST['utel'] : '';
    		$name = isset($_POST['name']) ? $_POST['name'] : '';
    		$addressXq = isset($_POST['address_xq']) ? $_POST['address_xq'] : '';
    		$kftel = isset($_POST['kftel']) ? $_POST['kftel'] : '';
    		
    		if (!$uid || !$region || !$saleType || !$uname || !$utel || !$name || !$addressXq || !$kftel){
    			echo json_encode(array('status'=>0, 'err'=>'参数错误错误'));
    			exit();
    		}
    		
    		//插叙用户是否提交过
    		$jscjl = JoinShangchang::findFirstByUid($uid);
    		
    		if ($jscjl && count($jscjl->toArray())){
    			$jscjl->shnum = $jscjl->shnum+1;
    			$jscjl->sqtime = time();
    			$jscjl->uname = $uname;
    			$jscjl->shop_name = $name;
    			$jscjl->utel = $utel;
    			$jscjl->address = $region;
    			$jscjl->address_xq = $addressXq;
    			$jscjl->kftel = $kftel;
    			$jscjl->sqtime = time();
    			$jscjl->status = 'S0';
    			$jscjl->sale_type = $saleType;
    			$result = $jscjl->save();
    		}else {
    			$jsc = new JoinShangchang();
    			$jsc->uid = $uid;
    			$jsc->uname = $uname;
    			$jsc->shop_name = $name;
    			$jsc->utel = $utel;
    			$jsc->address = $region;
    			$jsc->address_xq = $addressXq;
    			$jsc->kftel = $kftel;
    			$jsc->addtime = time();
    			$jsc->sqtime = time();
    			$jsc->shnum = 1;
    			$jsc->status = 'S0';
    			$jsc->sale_type = $saleType;
    			$result = $jsc->save();
    		}
    		
    		if ($result) echo json_encode(array('status'=>1, 'msg'=>'申请成功!'));
    		else echo json_encode(array('status'=>0, 'err'=>'申请失败!'));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误!'));
    }

    /**
     * 获取入驻信息
     */
    public function joinInfoAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['user_id']) ? intval($_POST['user_id']) : '';
    		
    		if (!$uid){
    			echo json_encode(array('status'=>0, 'err'=>'登陆信息错误'));
    			exit();
    		}
    		
    		$jsci = JoinShangchang::findFirstByUid($uid);
    		
    		if ($jsci){
    			echo json_encode(array('status'=>1, 'info'=>$jsci->toArray()));
    		}else echo json_encode(array('status'=>2, 'err'=>'还没申请!'));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误!'));
    }
    
    /**
     * 获取允许销售类目
     */
    public function saleTypeAction(){
    	$sts = SaleType::find(array('conditions'=>"status=?1", 'bind'=>array(1=>'S1')));
    	$stArr = array();
    	
    	if ($sts) $stArr = $sts->toArray();
    	
    	echo json_encode(array('status'=>1, 'st'=>$stArr));
    }
    
}

