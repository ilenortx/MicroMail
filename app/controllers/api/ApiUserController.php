<?php

use Phalcon\DI\Service;

/**
 * 用户接口
 * @author xiao
 *
 */
class ApiUserController extends ApiBase{

    public function indexAction(){

    }
    
    public function getorderAction(){
    	$uid = isset($_POST['userId']) ? intval($_POST['userId']) : '';
    	if (!$uid) {
    		echo json_encode(array('status'=>0,'err'=>'非法操作.'));
    		exit();
    	}
    	
    	$order = array();
    	$pay = Order::find(array(
    			'conditions'=> "uid=?1 and status=?2 and del=?3 and back=?4",
    			'bind'		=> array(1=>$uid, 2=>10, 3=>0, 4=>0)
    	));
    	$order['pay_num'] = $pay ? $pay->count() : 0;
    	
    	$deliver= Order::find(array(
    			'conditions'=> "uid=?1 and status=?2 and del=?3 and back=?4",
    			'bind'		=> array(1=>$uid, 2=>20, 3=>0, 4=>0)
    	));
    	$order['deliver_num'] = $deliver ? $deliver->count() : 0;
    	
    	$rec = Order::find(array(
    			'conditions'=> "uid=?1 and status=?2 and del=?3 and back=?4",
    			'bind'		=> array(1=>$uid, 2=>30, 3=>0, 4=>0)
    	));
    	$order['rec_num'] = $rec ? $rec->count() : 0;
    	
    	$finish= Order::find(array(
    			'conditions'=> "uid=?1 and status>?2 and del=?3 and back=?4",
    			'bind'		=> array(1=>$uid, 2=>30, 3=>0, 4=>0)
    	));
    	$order['finish_num'] = $finish ? $finish->count() : 0;
    	
    	$refund= Order::find(array(
    			'conditions'=> "uid=?1 and back>?2",
    			'bind'		=> array(1=>$uid, 2=>'0')
    	));
    	$order['refund_num'] = $refund ? $refund->count() : 0;
    	
    	//获取个人商城信息
    	$sci = Shangchang::findFirstByUid($uid);
    	$sciArr = array();
    	$scjoin = false;
    	if ($sci && count($sci->toArray())) {
    		$sciArr= $sci->toArray(); $scjoin = true;
    	}
    	
    	echo json_encode(array('status'=>1, 'orderInfo'=>$order, 'scjoin'=>$scjoin));
    	exit();
    }

    
    /**
     * 添加地址
     */
    public function addAddsAction(){
    	if ($this->request->isPost()){
    		$uid 		= isset($_POST['user_id']) ? $_POST['user_id'] : '';
    		$receiver	= isset($_POST['receiver']) ? $_POST['receiver'] : '';
    		$tel		= isset($_POST['tel']) ? $_POST['tel'] : '';
    		$region		= isset($_POST['region']) ? str_replace(' ', ',', $_POST['region']) : '';
    		$adds		= isset($_POST['adds']) ? $_POST['adds'] : '';
    		$code		= isset($_POST['code']) ? $_POST['code'] : '';
    		
    		if (!$uid || !$receiver || !$tel|| !$region|| !$adds){
    			echo json_encode(array('status'=>0,'err'=>'请填写地址信息.')); exit();
    		}
    		
    		$isAddr = Address::findFirst(array(
    				'conditions'=> "uid=?1 and name=?2 and tel=?3 and address=?4 and address_xq=?5 and code=?6",
    				'bind'		=> array(1=>$uid, 2=>$receiver, 3=>$tel, 4=>$region, 5=>$adds, 6=>$code)
    		));
    		if ($isAddr){
    			$addr = $isAddr->toArray();
    			if (count($addr)>0){
    				$isAddr->status = 1;
    				$isAddr->save();
    				echo json_encode(array('status'=>1));
    				exit();
    			}
    		}
    		
    		$add = new Address();
    		$add->uid 		= $uid;
    		$add->name		= $receiver;
    		$add->tel		= $tel;
    		$add->address	= $region;
    		$add->address_xq= $adds;
    		$add->code		= $code;
    		$add->is_default= 0;
    		if ($add->save()){
    			echo json_encode(array('status'=>1));
    			exit();
    		}else {
    			echo json_encode(array('status'=>0,'err'=>'添加失败.'));
    			exit();
    		}
    	}
    }
    public function editAddsAction(){
    	if ($this->request->isPost()){
    		$id 		= isset($_POST['id']) ? intval($_POST['id']) : '';
    		$uid 		= isset($_POST['user_id']) ? $_POST['user_id'] : '';
    		$receiver	= isset($_POST['receiver']) ? $_POST['receiver'] : '';
    		$tel		= isset($_POST['tel']) ? $_POST['tel'] : '';
    		$region		= isset($_POST['region']) ? $_POST['region'] : '';
    		$adds		= isset($_POST['adds']) ? $_POST['adds'] : '';
    		$code		= isset($_POST['code']) ? $_POST['code'] : '';
    		
    		if(!$id){
    			echo json_encode(array('status'=>0,'err'=>'数据错误.')); exit();
    		}
    		if (!$uid || !$receiver || !$tel|| !$region|| !$adds){
    			echo json_encode(array('status'=>0,'err'=>'请填写地址信息.')); exit();
    		}
    		
    		$add= Address::findFirstById($id);
    		if ($add){
    			if ($add->uid != $uid){
    				echo json_encode(array('status'=>0,'err'=>'数据异常.'));
    				exit();
    			}
    			$add->name		= $receiver;
    			$add->tel		= $tel;
    			$add->address	= $region;
    			$add->address_xq= $adds;
    			if ($add->save()) echo json_encode(array('status'=>1));
    			else echo json_encode(array('status'=>0,'err'=>'修改失败.'));
    		}else echo json_encode(array('status'=>0,'err'=>'数据异常.'));
    	}
    }

	/**
	 * 获取地址
	 */
    public function getAddsAction(){
    	$user_id=intval($_REQUEST['user_id']);
    	if (!$user_id){
    		echo json_encode(array('status'=>0,'err'=>'网络异常.'.__LINE__));
    		exit();
    	}
    	
    	//所有地址
    	$addressModel = Address::find(array(
    			'conditions'=>"uid=?1 and status=?2",
    			'bind'=>array(1=>intval($user_id), 2=>1),
    			'order'		=> 'is_default desc,id desc'
    	));
    	$adds_list = $addressModel->toArray();
    	foreach ($adds_list as $k=>$v){
    		$adds_list[$k]['address'] = str_replace(',', ' ', $v['address']);
    	}
    	
    	echo json_encode(array('status'=>1,'adds'=>$adds_list));
    	exit();
    }
    
    /**
     * 设置地址为默认
     */
    public function setAddsDefaultAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['uid']) ? $_POST['uid'] : '';
    		$addr_id = isset($_POST['addr_id']) ? $_POST['addr_id'] : '';
    		if (!$uid || !$addr_id){
    			echo json_encode(array('status'=>0,'err'=>'数据异常.'.__LINE__));
    			exit();
    		}
    		
    		$addrs = Address::find(array(
    				'conditions'=> "uid=?1 and id!=?2",
    				'bind'		=> array(1=>$uid, 2=>$addr_id)
    		));
    		if ($addrs){
    			foreach ($addrs as $k){
    				$k->is_default = 0;
    				$k->save();
    			}
    		}
    		$addr = Address::findFirst(array(
    				'conditions'=> "uid=?1 and id=?2",
    				'bind'		=> array(1=>$uid, 2=>$addr_id)
    		));
    		if ($addr){
    			$addr->is_default = 1;
    			if ($addr->save()){
    				echo json_encode(array('status'=>1));
    				exit();
    			}else {
    				echo json_encode(array('status'=>0,'err'=>'修改失败.'.__LINE__));
    				exit();
    			}
    		}else {
    			echo json_encode(array('status'=>0,'err'=>'地址不存在.'.__LINE__));
    			exit();
    		}
    	}
    }
    
    /**
     * 删除地址
     */
    public function delAddsAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    		$addr_id = isset($_POST['addr_id']) ? $_POST['addr_id'] : '';
    		if (!$uid || !$addr_id){
    			echo json_encode(array('status'=>0,'err'=>'数据异常.'.__LINE__));
    			exit();
    		}
    		
    		$addr = Address::findFirst(array(
    				'conditions'=> "uid=?1 and id=?2",
    				'bind'		=> array(1=>$uid, 2=>$addr_id)
    		));
    		if ($addr){
    			if ($addr->delete()){
    				echo json_encode(array('status'=>1));
    				exit();
    			}else {
    				echo json_encode(array('status'=>0,'err'=>'删除失败.'.__LINE__));
    				exit();
    			}
    		}else {
    			echo json_encode(array('status'=>0,'err'=>'地址不存在.'.__LINE__));
    			exit();
    		}
    	}
    }
    
    /**
     * 获取服务
     */
    public function serviceCenterAction(){
    	$scs = ServiceCenter::find("status!='S0'");
    	
    	$scArr = array();
    	if ($scs) $scArr = $scs->toArray();
    	
    	echo json_encode(array('status'=>1, 'scs'=>$scArr));
    }
    /**
     * 获取服务详情
     */
    public function scDetailAction(){
    	$scid = isset($_POST['scid']) ? intval($_POST['scid']) : '';
    	
    	if (!$scid){
    		echo json_encode(array('status'=>0, 'err'=>'数据错误'));
    		exit();
    	}
    	
    	$scInfo = ServiceCenter::findFirstById($scid);
    	
    	if ($scInfo){
    		echo json_encode(array('status'=>1, 'content'=>$scInfo->content));
    	}else echo json_encode(array('status'=>0, 'err'=>'不存在'));
    }
    
    /**
     * 根据地址id获取地址
     */
    public function aidAddressAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    		$aid = isset($_POST['aid']) ? intval($_POST['aid']) : '';
    		
    		if (!$uid || !$aid){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误'));
    			exit();
    		}
    		
    		$addr = Address::findFirstById($aid);
    		if ($addr && count($addr->toArray()) && $addr->uid==$uid){
    			echo json_encode(array('status'=>1, 'addrInfo'=>$addr->toArray()));
    		}else echo json_encode(array('status'=>0, 'err'=>'地址信息错误'));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误'));
    }
}

