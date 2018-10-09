<?php

/**
 * 商品评论
 * @author xiao
 *
 */
class ApiproevaluateController extends ApiBase{

    public function indexAction(){

    }
    
    //----------
    // 商品评论
    //----------
    /**
     * 获取商品评论
     */
    public function proEvaluatesAction(){
    	if ($this->request->isPost()){
    		$pid = isset($_POST['pid']) ? intval($_POST['pid']): 0;
    		$type = (isset($_POST['type'])&&intval($_POST['type'])) ? intval($_POST['type']): 0;
    		$offset = (isset($_POST['offset'])&&intval($_POST['offset'])) ? intval($_POST['offset']) : 0;
    		
    		if(!$pid) { $this->err('数据错误'); exit(); }
    		
    		if ($type==-1) $limit = array('number'=>2, 'offset'=>0);
    		else $limit = array('number'=>10, 'offset'=>$offset*10);
    		$result = OrderEvaluate::proEvaluates('pid', array(
    				'pid'=>$pid, 'type'=>$type, 'limit'=>$limit
    		));
    		
    		if (is_array($result)){
    			$this->result(1, 'success', array('peInfo'=>$result, 'typeNum'=>OrderEvaluate::getTypeNum($pid)));
    		}else $this->err('数据异常');
    		
    	}else $this->err('请求方式错误');
    }
    
    
    //----------
    // 订单评论操作
    //----------
    /**
     * 获取订单评论信息
     */
    public function orderEvaluateInfoAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : 0;
    		$orderSn = isset($_POST['orderSn']) ? $_POST['orderSn'] : 0;
    		
    		if (!$uid || !$orderSn) {//数据验证
    			$this->err('数据错误错误!'); exit();
    		}
    		
    		$oe = OrderEvaluate::find("order_sn='{$orderSn}' order by id desc");
    		if ($oe && count($oe)){
    			$oeArr = array(); $proArr = array();
    			foreach ($oe as $k=>$v){
    				if ($v->uid == $uid){
    					if (!isset($proArr[$v->pid])){
    						$oeArr[$v->pid] = array(
    								'id'=>$v->id, 'pid'=>$v->pid, 'orderSn'=>$v->order_sn,
    								'uid'=>$v->uid, 'grade'=>$v->grade, 'evaluate'=>$v->evaluate,
    								'show_photos'=>explode(',', $v->show_photos), 'status'=>$v->status
    						);
    						
    						$pro = $v->Product;
    						$proArr[$v->pid] = array(
    								'pid'=>$pro->id, 'name'=>$pro->name, 'photo'=>$pro->photo_x
    						);
    					}
    				}else $this->err('数据异常!');
    			}
    			$this->result(2, 'success', array('oeInfo'=>$oeArr, 'proInfo'=>$proArr));
    		}else {
    			$order = Order::findFirst("order_sn=$orderSn");
    			if ($order){
    				$ops = $order->OrderProduct;
    				if ($ops){
    					$proArr = array();
    					foreach ($ops as $k=>$v){
    						if (!isset($proArr['pid'])){
    							$proArr[$v->pid] = array(
    									'id'=>$v->id, 'pid'=>$v->pid, 'name'=>$v->name, 'photo'=>$v->photo_x
    							);
    						}
    					}
    					$this->result(1, 'success', array('proInfo'=>$proArr));
    				}else $this->err('数据异常');
    			}else $this->err('数据异常');
    		}
    	}else $this->err('请求方式错误!');
    }
    
    /**
     * 添加订单评论
     */
    public function addOrderEvaluateAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : 0;
    		$orderSn = isset($_POST['orderSn']) ? $_POST['orderSn'] : 0;
    		$grade = isset($_POST['grade']) ? $_POST['grade'] : null;
    		$evaluate = isset($_POST['evaluate']) ? $_POST['evaluate'] : null;
    		
    		if (!$uid || !$orderSn) {//数据验证
    			$this->err('数据错误错误!'); exit();
    		}
    		
    		//文件上传
    		$filePath = 'evaluate/'.date('Ymd');
    		$sp = new FileUpload($this->request, UPLOAD_FILE.$filePath, array('jpg','png'), 5*1024*1024);
    		$sp->uploadfile(); $spArr = array();
    		if(!$sp->errState()){
    			foreach ($sp->getFileNames() as $k=>$v){
    				$spKey = explode('.', str_replace('image.', '', $k))[0];
    				if (!isset($spArr[$spKey])) $spArr[$spKey] = $filePath.'/'.$v.',';
    				else $spArr[$spKey] .= $filePath.'/'.$v.',';
    				
    				//压缩图片
    				$ic = new ImgCompres(UPLOAD_FILE.$filePath.'/'.$v);
    				$ic->compressImg(UPLOAD_FILE.$filePath, $v);
    				if ($ic->errState()) { $this->err($sp->errInfo()); exit(); }
    				
    				/* $_img = new CreatLitimg(UPLOAD_FILE.$filePath.'/'.$v, UPLOAD_FILE.$filePath.'/ll', 'heheh.png');
    				$_img->litimg(100, 100); */
    			}
    		}else{//文件上传失败
    			$this->err($sp->errInfo()); exit();
    		}
    		
    		$result = OrderEvaluate::addEvaluate($orderSn, $uid, array(
    				'grade'=>$grade, 'evaluate'=>$evaluate, 'showPhotos'=>$spArr
    		));
    		
    		if ($result == 'SUCCESS') $this->msg('success');
    		else if ($result == 'DATAERR') $this->err('数据错误');
    		else if ($result == 'OPEFILE') $this->err('操作失败');
    		else if ($result == 'S2') $this->err('已评价');
    		
    	}else $this->err('请求方式错误!');
    }

}

