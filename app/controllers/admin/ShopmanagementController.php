<?php

use Phalcon\Cache\Frontend\Data;

class ShopmanagementController extends AdminBase{
	/**
	* 店铺列表页面
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

    	$this->view->shopList = $this->shopListAction();

    	$this->view->pick("admin/shop/index");
    }

    /**
     * 店铺审核页面
     */
    public function shopShPageAction(){
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

    	$this->view->jsList = $this->shopShListAction();

    	$this->view->pick("admin/shop/shList");
    }

    /**
     * 审核页面
     */
    public function shopAuditPageAction(){
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

	    $id = isset($_GET['id']) ? intval($_GET['id']): '';
	    $this->view->sai = $this->shopAuditInfoAction($id);

    	$this->view->pick("admin/shop/shopAudit");
    }

    /**
     * 店铺信息页面
     */
    public function shopInfoPageAction(){
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
             ->addJs("plugins/xheditor/xheditor-1.2.2.min.js")
             ->addJs("plugins/xheditor/xheditor_lang/zh-cn.js")
    		 ->addJs("lib/jquery.validation/1.14.0/jquery.validate.js")
    		 ->addJs("lib/jquery.validation/1.14.0/validate-methods.js")
    		 ->addJs("lib/jquery.validation/1.14.0/messages_zh.js")
    		 ->addJs("lib/laypage/1.2/laypage.js");

    	$id = isset($_GET['id']) ? intval($_GET['id']): '';
    	//获取店铺信息
    	$shop = Shangchang::findFirstById($this->session->get('sid'));
    	$this->view->sinfo = $shop->toArray();

    	$this->view->pick("admin/shop/shopInfo");
    }

    /**
     * 店铺商品页面
     */
    public function spListPageAction(){
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

	    $sid = isset($_GET['sid']) ? intval($_GET['sid']) : '';
    	$products = array();
    	$plist = Product::find(array(
    			'conditions'=>'del!=?1 and shop_id=?2',
    			'bind'=>array(1=>1, 2=>$sid)
    	));
    	if ($plist) $products = $plist->toArray();
    	$this->view->products = $products;


    	$this->view->pick("admin/shop/sproList");
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
	    $this->view->scType = $this->session->scType;

    	$this->view->pick("admin/shop/withdrawDeposit");
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

    	$this->view->pick("admin/shop/txdPage");
    }

    /**
     * 店铺列表
     */
    public function shopListAction(){
    	$shops = Shangchang::find();
    	$shopArr = array();

    	if ($shops) $shopArr = $shops->toArray();

    	return $shopArr;
    }

    /**
     * 待审核列表
     */
    public function shopShListAction(){
    	$jss = JoinShangchang::find("status in('S0','S1','S3')");
    	$jsArr = array();
    	if ($jss) $jsArr = $jss->toArray();
    	foreach ($jsArr as $k=>$v){
    		$jsArr[$k]['addtime'] = date('Y-m-d H:i:s', $jsArr[$k]['addtime']);
    		$jsArr[$k]['sqtime'] = date('Y-m-d H:i:s', $jsArr[$k]['sqtime']);
    	}
    	return $jsArr;
    }

    /**
     * 店铺审核信息
     */
    public function shopAuditInfoAction($id){
    	$sai = JoinShangchang::findFirstById($id);
    	$saiArr = array(
    			'hyinfo'=>'', 'uname'=>'', 'shop_name'=>'', 'utel'=>'', 'address'=>'',
    			'address_xq'=>'', 'kftel'=>'', 'addtime'=>'', 'sqtime'=>'',
    			'sale_type'=>'', 'status'=>'', 'id'=>'', 'fxtc'=>''
    	);

    	if ($sai){
    		if ($sai->status == 'S0'){
    			$sai->status = 'S1'; $sai->save();
    		}
    		$saiArr = $sai->toArray();
    		$user = $sai->user;
    		$saleType = $sai->saleType;
    		$saiArr['hyinfo'] = $user->uname;
    		$saiArr['sale_type'] = $saleType->name;
    		$saiArr['addtime'] = date('Y-m-d H:i:s', $saiArr['addtime']);
    		$saiArr['sqtime'] = date('Y-m-d H:i:s', $saiArr['sqtime']);
    	}

    	return $saiArr;
    }

    /**
     * 改变店铺状态
     */
    public function shopStatusAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? intval($_POST['id']) : '';
    		$type = isset($_POST['type']) ? intval($_POST['type']) : '';

    		if (!$id || empty($type)){
    			echo json_encode(array('status'=>0, 'mag'=>'数据错误!'));
    			exit();
    		}

    		$shop = Shangchang::findFirstById($id);
    		if ($shop){
    			$shop->status = $type;
    			if ($shop->save()) echo json_encode(array('status'=>1, 'mag'=>'success'));
    			else echo json_encode(array('status'=>0, 'mag'=>'操作失败!'));
    		}else echo json_encode(array('status'=>0, 'mag'=>'店铺不存在!'));
    	}else echo json_encode(array('status'=>0, 'mag'=>'请求方式错误!'));
    }

    /**
     * 提交审核
     */
    public function subAuditAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? intval($_POST['id']) : '';
    		$status= isset($_POST['status']) ? $_POST['status'] : '';
    		$info= isset($_POST['info']) ? $_POST['info'] : '';
    		if (!$id || !$status || !$info){
    			echo json_encode(array('status'=>0, 'mag'=>'数据错误!'));
    			exit();
    		}

    		$js = JoinShangchang::findFirstById($id);
    		if ($js && count($js->toArray())){
    			$js->status = $status;
    			$js->audit_info = $info;
    			if ($status == 'S2') $this->createShopAction($id);
    			if ($js->save()) echo json_encode(array('status'=>1, 'mag'=>'success'));
    			else echo json_encode(array('status'=>0, 'mag'=>'操作失败!'));
    		}else echo json_encode(array('status'=>0, 'mag'=>'申请不存在!'));
    	}else echo json_encode(array('status'=>0, 'mag'=>'请求方式错误!'));
    }

    /**
     * 创建店铺
     */
    public function createShopAction($id){
    	$js = JoinShangchang::findFirstById($id);
    	$jsi = array();
    	if ($js){
    		$jsi = $js->toArray();

    		$shop = new Shangchang();
    		$shop->uid = $jsi['uid'];
    		$shop->fxtc = 5;
    		$shop->name = $jsi['shop_name'];
    		$shop->uname = $jsi['uname'];
    		$shop->logo = 'shop/shop.png';
    		$shop->address = $jsi['address'];
    		$shop->address_xq = $jsi['address_xq'];
    		$shop->addtime = time();
    		$shop->updatetime = time();
    		$shop->tel = $jsi['kftel'];
    		$shop->utel = $jsi['utel'];
    		$shop->grade = 1;
    		$shop->status = 1;
    		$shop->sc_type = 'ST1';
    		$shop->type = 0;
    		$shop->name = $jsi['shop_name'];

    		if ($shop->save()){//创建管理账户
    			$admin = new Adminuser();
    			$admin->sid = $shop->id;
    			$admin->name = $shop->utel;
    			$admin->uname = $shop->uname;
    			$admin->pwd = md5($shop->utel);
    			$admin->phone = $shop->utel;
    			$admin->qx = 4;
    			$admin->addtime = time();
    			$admin->status = 'S1';

    			$admin->save();
    		}
    	}
    }

    /**
     * 保存店铺信息
     */
    public function saveShopAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? intval($_POST['id']) : '';
    		$name = isset($_POST['name']) ? $_POST['name'] : '';
    		$uname = isset($_POST['uname']) ? $_POST['uname'] : '';
    		$address = isset($_POST['address']) ? $_POST['address'] : '';
    		$address_xq= isset($_POST['address_xq']) ? $_POST['address_xq'] : '';
    		$intro= isset($_POST['intro']) ? $_POST['intro'] : '';
    		$tel= isset($_POST['tel']) ? $_POST['tel'] : '';
    		$qq = isset($_POST['qq']) ? $_POST['qq'] : '';
    		$wx_appid= isset($_POST['wx_appid']) ? $_POST['wx_appid'] : '';
    		$wx_secret= isset($_POST['wx_secret']) ? $_POST['wx_secret'] : '';
    		$shh_mch_id= isset($_POST['shh_mch_id']) ? $_POST['shh_mch_id'] : '';
    		$shh_key= isset($_POST['shh_key']) ? $_POST['shh_key'] : '';
    		$xcx_appid= isset($_POST['xcx_appid']) ? $_POST['xcx_appid'] : '';
    		$xcx_secret= isset($_POST['xcx_secret']) ? $_POST['xcx_secret'] : '';
    		$fxtc = isset($_POST['fxtc']) ? intval($_POST['fxtc']) : 0;
            $html_content = isset($_POST['content']) ? $_POST['content']:'';

    		if (!$id || !$name || !$uname || !$address || !$address_xq || !$intro || !$tel || ($fxtc<=0||$fxtc>100)){
    			echo json_encode(array('status'=>0, 'msg'=>'数据错误!'));
    			exit();
    		}

    		$shop = Shangchang::findFirstById($id);
    		$shop->name = $name;
    		$shop->fxtc = $fxtc;
    		$shop->uname = $uname;
    		$shop->address = $address;
    		$shop->address_xq = $address_xq;
    		$shop->intro = $intro;
    		$shop->tel = $tel;
    		$shop->qq = $qq;
    		$shop->wx_appid = $wx_appid;
    		$shop->wx_secret = $wx_secret;
    		$shop->shh_mch_id = $shh_mch_id;
    		$shop->shh_key = $shh_key;
    		$shop->content = $html_content;
    		$shop->xcx_appid = $xcx_appid;
    		$shop->xcx_secret = $xcx_secret;

    		//上传商铺LOGO
    		if (!empty($_FILES["logo"]["tmp_name"])) {
    			//文件上传
    			$info = $this->upload_images($_FILES["logo"], "shop/logo/".date('Ymd').'/', array('jpg','png','jpeg'));
    			if(!is_array($info)) {
    				$this->err($info);
    				exit();
    			}else{
    				if ($shop->logo) {
    					$img_url = UPLOAD_FILE.$shop->logo;
    					if(file_exists($img_url)) {
    						@unlink($img_url);
    					}
    				}
    				$shop->logo = $info['savepath'].$info['savename'];
    			}
    		}
    		//上传广告图
    		if (!empty($_FILES["vip_char"]["tmp_name"])) {
    			//文件上传
    			$info = $this->upload_images($_FILES["vip_char"], "shop/".date('Ymd').'/', array('jpg','png','jpeg'));
    			if(!is_array($info)) {
    				$this->err($info);
    				exit();
    			}else{
    				if ($shop->vip_char) {
    					$img_url = UPLOAD_FILE.$shop->vip_char;
    					if(file_exists($img_url)) {
    						@unlink($img_url);
    					}
    				}
    				$shop->vip_char= $info['savepath'].$info['savename'];
    			}
    		}
    		
    		$shhCert = ''; $shhKey = '';
    		//上传证书 cert
    		if (!empty($_FILES["shh_cert"]["tmp_name"])) {
    			//文件上传
    			$info = $this->uploadFile($_FILES["shh_cert"], "cert", array('pem'), WECHAT.'/', false);
    			if(!is_array($info)) {
    				$this->err($info);exit();
    			}else $shhCert = WECHAT.'/'.$info['savepath'].$info['savename'];
    		}
    		//上传证书密钥 key
    		if (!empty($_FILES["shh_key"]["tmp_name"])) {
    			//文件上传
    			$info = $this->uploadFile($_FILES["shh_key"], "cert", array('pem'), WECHAT.'/', false);
    			if(!is_array($info)) {
    				$this->err($info);exit();
    			}else $shhKey = WECHAT.'/'.$info['savepath'].$info['savename'];
    		}
    		
    		if ($shop->save()) {
    			$ecode = $this->esbEcode();
    			//保存公众号信息
    			$gzhd = IniFileOpe::getIniFile(WECHAT.'/config.ini', $ecode.'-gzh');
    			$gzhd['appid'] = $wx_appid; $gzhd['secret'] = $wx_secret;
    			$gzhd['mchid'] = $shh_mch_id; $gzhd['key'] = $shh_key;
    			if (!empty($shhCert))$gzhd['sslcertPath'] = $shhCert; 
    			if (!empty($shhKey))$gzhd['sslkeyPath'] = $shhKey; 
    			IniFileOpe::reinitFile(WECHAT.'/config.ini', $gzhd, $ecode.'-gzh');
    			
    			//保存小程序信息
    			$xcxd = IniFileOpe::getIniFile(WECHAT.'/config.ini', $ecode.'-xcx');
    			$xcxd['appid'] = $xcx_appid; $xcxd['secret'] = $xcx_secret;
    			$xcxd['mchid'] = $shh_mch_id; $xcxd['key'] = $shh_key;
    			if (!empty($shhCert))$gzhd['sslcertPath'] = $shhCert;
    			if (!empty($shhKey))$gzhd['sslkeyPath'] = $shhKey; 
    			IniFileOpe::reinitFile(WECHAT.'/config.ini', $xcxd, $ecode.'-xcx');
    			
    			echo json_encode(array('status'=>1, 'msg'=>'success'));
    		}else echo json_encode(array('status'=>0, 'msg'=>'操作失败!'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误!'));
    }

    /**
     * 提现列表
     */
    public function txListAction(){
    	$shopId = $this->session->get('sid');
    	$txArr = array();
    	if ($this->session->get('scType') == 'ST0'){
    		$mss = MonthSum::find("shop_id!={$shopId}");
    	}else {
    		$mss = MonthSum::find("shop_id={$shopId}");
    	}
    	if ($mss) {
    		foreach ($mss as $k=>$v){
    			$shop = $v->Shangchang;
    			$v->addtime = $v->addtime?date('Y-m-d H:i:s', $v->addtime):'';
    			$v->sqtxtime = $v->sqtxtime?date('Y-m-d H:i:s', $v->sqtxtime):'';
    			$v->txtime = $v->txtime?date('Y-m-d H:i:s', $v->txtime):'';
    			$txArr[$k] = $v->toArray();
    			$txArr[$k]['shop'] = $shop->toArray();
    		}
    	}

    	return $txArr;
    }

    public function sqtxAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['msid']) ? intval($_POST['msid']) : '';

    		if (!$id){
    			echo json_encode(array('status'=>0, 'msg'=>'参数错误'));
    			exit();
    		}

    		$ms = MonthSum::findFirstById($id);
    		if ($ms){
    			if ($ms->shop_id == $this->session->get('sid')){
    				$ms->sqtxtime = time();
    				$ms->status = 'S1';
    				if ($ms->save()){
    					echo json_encode(array('status'=>1, 'msg'=>'success'));
    				}else echo json_encode(array('status'=>0, 'msg'=>'操作失败'));
    			}else echo json_encode(array('status'=>0, 'msg'=>'权限不够'));
    		}else echo json_encode(array('status'=>0, 'msg'=>'记录不存在'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }

    /**
     * 获取提现信息
     */
    public function txInfoAction($msid){
    	$ms = MonthSum::findFirstById($msid);

    	$info = array();
    	if ($ms) {
    		$info = $ms->toArray();
    		$shop = $ms->Shangchang;
    		$info['shop'] = $shop->toArray();
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
    			$ms = MonthSum::findFirstById($msid);
    			if ($ms){
    				$ms->status = $status;
    				if ($type=='T0') $ms->txtime = $status=='S3'?time():'';
    				if ($ms->save()) echo json_encode(array('status'=>1, 'msg'=>'success'));
    				else echo json_encode(array('status'=>0, 'msg'=>'操作失败'));
    			}else echo json_encode(array('status'=>0, 'msg'=>'记录不存在'));
    		}else echo json_encode(array('status'=>0, 'msg'=>'权限不够'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }

}

