<?php

/**
 * 活动专区
 * @author xiao
 *
 */
class AaconfController extends AdminBase{

    public function indexAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/static/h-ui.admin/style.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js")
	    	 ->addJs("js/static/h-ui.admin/H-ui.admin.js")
	    	 ->addJs("lib/laypage/1.2/laypage.js");
    	
    	
    	$this->view->aaconf = $this->aaconfInfo($this->session->get("sid"));
    	$this->view->pick("admin/shopPageConf/aaconf");
    }
    /**
     * 获取信息
     */
    public function aaconfInfo($sid){
    	$info = array(
    			'id'=>'', 'shop_id'=>'', 'zqname'=>'', 'btname'=>'', 'ztype'=>'', 'zurl'=>'',
    			'zphoto'=>'', 'rttype'=>'', 'rturl'=>'', 'rtphoto'=>'', 'rbtype'=>'',
    			'rburl'=>'', 'rbphoto'=>'', 'zproid'=>'', 'rtproid'=>'', 'rbproid'=>'',
    	);
    	
    	$aai = Aaconf::findFirstByShopId($sid);
    	if ($aai && count($aai)) {
    		$info = $aai->toArray();
    		if ($info['ztype']=='4'){
    			$eurl = explode('=', $info['zurl']);
    			if (count($eurl)==2) $info['zproid'] = intval($eurl[1]);
    			else $info['zproid'] = '';
    		}else $info['zproid'] = '';
    		
    		if ($info['rttype']=='4'){
    			$eurl = explode('=', $info['rturl']);
    			if (count($eurl)==2) $info['rtproid'] = intval($eurl[1]);
    			else $info['rtproid'] = '';
    		}else $info['rtproid'] = '';
    		
    		if ($info['rbtype']=='4'){
    			$eurl = explode('=', $info['rburl']);
    			if (count($eurl)==2) $info['rbproid'] = intval($eurl[1]);
    			else $info['rbproid'] = '';
    		}else $info['rbproid'] = '';
    	}
    	
    	return $info;
    }
    
    /**
     * 编辑活动专区
     */
    public function aaEditAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? intval($_POST['id']) : '';
    		$zqname = isset($_POST['zqname']) ? $_POST['zqname'] : '';
    		$btname = isset($_POST['btname']) ? $_POST['btname'] : '';
    		$ztype = isset($_POST['ztype']) ? $_POST['ztype'] : '';
    		$zproid = isset($_POST['zproid']) ? $_POST['zproid'] : '';
    		$rttype = isset($_POST['rttype']) ? $_POST['rttype'] : '';
    		$rtproid = isset($_POST['rtproid']) ? $_POST['rtproid'] : '';
    		$rbtype = isset($_POST['rbtype']) ? $_POST['rbtype'] : '';
    		$rbproid = isset($_POST['rbproid']) ? $_POST['rbproid'] : '';
    		
    		if (!$zqname || !$btname || !$ztype || !$rttype || !$rbtype){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误')); exit();
    		}
    		if (($ztype=='4'&&!$zproid) || ($ztype=='4'&&!$rtproid) || ($ztype=='4'&&!$rbproid)){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误')); exit();
    		}
    		if (!$id && (empty($_FILES["photo_l"]["tmp_name"])||
    				empty($_FILES["photo_rt"]["tmp_name"])||empty($_FILES["photo_rb"]["tmp_name"]))) {
    			echo json_encode(array('status'=>0, 'err'=>'请上传相关图片')); exit();
    		}
    		
    		if ($id){
    			$aai = Aaconf::findFirstById($id);
    			if (!$aai || !count($aai)){
    				echo json_encode(array('status'=>0, 'err'=>'数据异常')); exit();
    			}
    		}else{
    			$aai = new Aaconf();
    		}
    		
    		//上传图片
    		if (!empty($_FILES["photo_l"]["tmp_name"])){
    			if ($id && !empty($aai->zphoto)){
    				$img_url = UPLOAD_FILE.$aai->zphoto;
    				if(file_exists($img_url)) { @unlink($img_url); }
    			}
    			$info = $this->upload_images($_FILES["photo_l"], "activityArea/".date('Ymd').'/', array('jpg','png','jpeg','gif'));
    			if(!is_array($info)) {
    				echo json_encode(array('status'=>0, 'err'=>'图片上传失败')); exit();
    			}else $aai->zphoto = $info['savepath'].$info['savename'];
    		}
    		if (!empty($_FILES["photo_rt"]["tmp_name"])){
    			if ($id && !empty($aai->zphoto)){
    				$img_url = UPLOAD_FILE.$aai->rtphoto;
    				if(file_exists($img_url)) { @unlink($img_url); }
    			}
    			$info = $this->upload_images($_FILES["photo_rt"], "activityArea/".date('Ymd').'/', array('jpg','png','jpeg','gif'));
    			if(!is_array($info)) {
    				$img_url = UPLOAD_FILE.$aai->zphoto;
    				if(file_exists($img_url)) { @unlink($img_url); }
    				echo json_encode(array('status'=>0, 'err'=>'图片上传失败')); exit();
    			}else $aai->rtphoto = $info['savepath'].$info['savename'];
    		}
    		if (!empty($_FILES["photo_rb"]["tmp_name"])){
    			if ($id && !empty($aai->zphoto)){
    				$img_url = UPLOAD_FILE.$aai->rbphoto;
    				if(file_exists($img_url)) { @unlink($img_url); }
    			}
    			$info = $this->upload_images($_FILES["photo_rb"], "activityArea/".date('Ymd').'/', array('jpg','png','jpeg','gif'));
    			if(!is_array($info)) {
    				$img_url = UPLOAD_FILE.$aai->zphoto;
    				if(file_exists($img_url)) { @unlink($img_url); }
    				$img_url = UPLOAD_FILE.$aai->rtphoto;
    				if(file_exists($img_url)) { @unlink($img_url); }
    				echo json_encode(array('status'=>0, 'err'=>'图片上传失败')); exit();
    			}else $aai->rbphoto = $info['savepath'].$info['savename'];
    		}
    		
    		$aai->zqname = $zqname;
    		$aai->btname = $btname;
    		$aai->shop_id = $this->session->get('sid');
    		$aai->ztype = $ztype;
    		$aai->zurl = self::getUrl($ztype, $zproid);
    		$aai->rttype = $rttype;
    		$aai->rturl = self::getUrl($rttype, $rtproid);
    		$aai->rbtype = $rbtype;
    		$aai->rburl = self::getUrl($rbtype, $rbproid);
    		
    		if ($aai->save()) echo json_encode(array('status'=>1, 'msg'=>'success', 'id'=>$aai->id));
    		else echo json_encode(array('status'=>0, 'err'=>'操作失败')); exit();
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误')); exit();
    }
    private function getUrl($type='1', $proid=0){
    	switch ($type){
    		case '1':
    			return '../groupBooking/groupBookingMore';
    		case '2':
    			return '../promotion/promotionMore';
    		case '3':
    			return '../cutPrice/cutPriceMore';
    			break;
    		case '4':
    			return '../product/detail?productId='.$proid;
    	}
    }

}

