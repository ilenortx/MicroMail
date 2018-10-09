<?php

/**
 * 优惠券接口
 * @author xiao
 *
 */
class ApivoucherController extends ApiBase{

    public function indexAction(){

    }
    
    /**
     * 获取我的优惠券
     */
    public function myVoucherAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    		
    		if (!$uid){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误'));
    			exit();
    		}
    		
    		$time = time();
    		$uvs = UserVoucher::find("uid=$uid and start_time<=$time and end_time>=$time and status=1");
    		
    		$vArr = array();
    		
    		if ($uvs){
    			foreach ($uvs as $k=>$v){
    				$vinfo = Voucher::findFirstById($v->vid);
    				if ($vinfo){
    					$vi = $vinfo->toArray();
    					$vi['start_time'] = date('Y-m-d', $vi['start_time']);
    					$vi['end_time'] = date('Y-m-d', $vi['end_time']);
    					
    					array_push($vArr, $vi);
    				}
    			}
    		}
    		
    		echo json_encode(array('status'=>1, 'varr'=>$vArr));
    	}
    }
    
    /**
     * 获取所有未领优惠券
     */
    public function unGetVoucherAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    		
    		/* if (!$uid){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误'));
    			exit();
    		} */
    		
    		$time = time();
    		$uvs = UserVoucher::find("uid=$uid and start_time<=$time and end_time>=$time");
    		
    		if ($uvs && count($uvs->toArray())){
    			$uvids = '';
    			
    			foreach ($uvs as $k=>$v){
    				$uvids .= $v->vid.',';
    			}
    			$uvids = trim($uvids, ',');
    			
    			$vs = Voucher::find("start_time<=$time and end_time>=$time and id not in ($uvids) and del=0");
    		}else {
    			$vs = Voucher::find("start_time<=$time and end_time>=$time and del=0");
    		}
    		
    		$vArr = array();
    		
    		if ($vs) $vArr = $vs->toArray();
    		
    		for ($i=0; $i<count($vArr); ++$i){
    			$vArr[$i]['start_time'] = date('Y-m-d', $vArr[$i]['start_time']);
    			$vArr[$i]['end_time'] = date('Y-m-d', $vArr[$i]['end_time']);
    		}
    		
    		echo json_encode(array('status'=>1, 'varr'=>$vArr));
    	}
    }
    
    /**
     * 领取优惠券
     */
    public function getCouponAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    		$vid = isset($_POST['vid']) ? intval($_POST['vid']) : '';
    		
    		if (!$uid || !$vid){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误'));
    			exit();
    		}
    		
    		$user = User::findFirstById($uid);
    		if (!$user || !count($user)){
    			echo json_encode(array('status'=>0, 'err'=>'用户不存在'));
    			exit();
    		}
    		
    		$vinfo = Voucher::findFirstById($vid);
    		if (!$vinfo|| !count($vinfo)){
    			echo json_encode(array('status'=>0, 'err'=>'优惠券不存在'));
    			exit();
    		}
    		
    		if ($user->jifen < $vinfo->point){
    			echo json_encode(array('status'=>0, 'err'=>'积分不足'));
    			exit();
    		}
    		
    		$uv = new UserVoucher();
    		$uv->uid = $uid;
    		$uv->vid = $vid;
    		$uv->shop_id = $vinfo->shop_id;
    		$uv->full_money = $vinfo->full_money;
    		$uv->amount = $vinfo->amount;
    		$uv->start_time = $vinfo->start_time;
    		$uv->end_time = $vinfo->end_time;
    		$uv->addtime = time();
    		$uv->status = 1;
    		if ($uv->save()){
    			$time = time();
    			$uvs = UserVoucher::find("uid=$uid and start_time<=$time and end_time>=$time");
    			
    			if ($uvs && count($uvs->toArray())){
    				$uvids = '';
    				foreach ($uvs as $k=>$v){
    					$uvids .= $v->vid.',';
    				}
    				$uvids = trim($uvids, ',');
    				
    				$vs = Voucher::find("start_time<=$time and end_time>=$time and id not in ($uvids) and del=0");
    			}else {
    				$vs = Voucher::find("start_time<=$time and end_time>=$time and del=0");
    			}
    			
    			$vArr = array();
    			
    			if ($vs) $vArr = $vs->toArray();
    			
    			for ($i=0; $i<count($vArr); ++$i){
    				$vArr[$i]['start_time'] = date('Y-m-d', $vArr[$i]['start_time']);
    				$vArr[$i]['end_time'] = date('Y-m-d', $vArr[$i]['end_time']);
    			}
    			
    			echo json_encode(array('status'=>1, 'varr'=>$vArr));
    		}else echo json_encode(array('status'=>0, 'err'=>'领取失败'));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误'));
    }

}

