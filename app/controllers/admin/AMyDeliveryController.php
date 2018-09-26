<?php

class AMyDeliveryController extends AdminBase{
	
	public $cysarr = array('1'=>'快递承运商');
	
	//---------
	// 物流管理
	//---------
	public function wlmanagePageAction(){
		$this->assets
			 ->addCss("css/static/h-ui/H-ui.min.css")
			 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
			 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
			 ->addCss("css/layui/layui.css")
			 ->addCss("css/pages/admin/public.css")
			 ->addCss("css/pages/admin/myDelivery/wlmanage.css")
			 ->addJs("lib/jquery/1.9.1/jquery.min.js")
			 ->addJs("lib/layui/layui.js")
			 ->addJs("js/pages/admin/pageOpe.js")
			 ->addJs("js/pages/admin/myDelivery/wlmanage.js");
		
		$this->view->pick("admin/myDelivery/wlmanage");
	}
	
	/**
	 * 添加物流公司
	 */
	public function wlgsmAddPageAction(){
		$this->assets
		->addCss("css/static/h-ui/H-ui.min.css")
		->addCss("css/static/h-ui.admin/H-ui.admin.css")
		->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
		->addCss("css/layui/layui.css")
		->addCss("css/pages/admin/public.css")
		->addJs("lib/jquery/1.9.1/jquery.min.js")
		->addJs("lib/layui/layui.js")
		->addJs("js/pages/admin/pageOpe.js")
		->addJs("js/pages/admin/myDelivery/wlgsmAdd.js");
		
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		
		$wli = Logistics::wlminfo($id);
		
		$this->view->id = $id;
		$this->view->wli = $wli;
		
		$this->view->pick("admin/myDelivery/wlgsmAdd");
	}
	
	/**
	 * 获取所有物流公司
	 */
	public function wlgsListAction(){
		$ls = Logistics::wlgsList();
		
		if ($ls=='DATAEXCEPTION') $ls= array();
		
		foreach ($ls as $k=>$v){
			$ls[$k]['cys'] = $this->cysarr[$ls[$k]['cys']];
			
			$ls[$k]['isjscx'] = $ls[$k]['isjscx']=='1'?'支持':'不支持';
			$ls[$k]['iswlgz'] = $ls[$k]['iswlgz']=='1'?'支持':'不支持';
			$ls[$k]['isdzmd'] = $ls[$k]['isdzmd']=='1'?'支持':'不支持';
			$ls[$k]['isqj'] = $ls[$k]['isqj']=='1'?'支持':'不支持';
		}
		
		$this->tableData($ls, 0, '加载成功!');
	}
	
	/**
	 * 保存物理信息
	 */
	public function saveWlminfoAction(){
		if ($this->request->isPost()){
			$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
			$cys = isset($_POST['cys']) ? intval($_POST['cys']) : 1;
			$name = isset($_POST['name']) ? $_POST['name'] : '';
			$code = isset($_POST['code']) ? $_POST['code'] : '';
			$tel = isset($_POST['tel']) ? $_POST['tel'] : '';
			$isaccount = isset($_POST['isaccount']) ? $_POST['isaccount'] : false;
			$isjscx = isset($_POST['isjscx']) ? $_POST['isjscx'] : false;
			$iswlgz = isset($_POST['iswlgz']) ? $_POST['iswlgz'] : false;
			$isdzmd= isset($_POST['isdzmd']) ? $_POST['isdzmd'] : false;
			$isqj = isset($_POST['isqj']) ? $_POST['isqj'] : false;
			$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
			$sort = isset($_POST['sort']) ? intval($_POST['sort']) : 0;
			
			if (!$cys || !$name || !$code){ $this->err('数据错误'); exit(); }
			
			
			$result = Logistics::saveWlminfo(array(
					'cys'=>$cys, 'name'=>$name, 'code'=>$code, 'tel'=>$tel,
					'isjscx'=>$isjscx, 'iswlgz'=>$iswlgz, 'isdzmd'=>$isdzmd, 
					'isqj'=>$isqj, 'remark'=>$remark, 'sort'=>$sort, 'isaccount'=>$isaccount
			), $id);
			
			if ($result == 'SUCCESS') $this->msg('success');
			else $this->err('操作失败');
		}else $this->err('请求方式错误');
	}
	
	/**
	 * 删除店铺物流
	 */
	public function delWlgsAction(){
		if ($this->request->isPost()){
			$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
			
			if (!$id) { $this->err('数据错误'); exit(); }
			
			$result = Logistics::delWl($id);
			if ($result == 'SUCCESS') $this->msg('success');
			else if ($result == 'OPEFILE') $this->err('操作失败');
			else if ($result == 'DATAEXCEPTION') $this->err('数据异常');
		}else $this->err('请求方式错误');
	}
	
	//---------
	// 物流公司
	//---------
	public function wlgsListPageAction(){
		$this->assets
			 ->addCss("css/static/h-ui/H-ui.min.css")
			 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
			 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
			 ->addCss("css/layui/layui.css")
			 ->addCss("css/pages/admin/public.css")
			 ->addCss("css/pages/admin/myDelivery/wlgslist.css")
			 ->addJs("lib/jquery/1.9.1/jquery.min.js")
			 ->addJs("lib/layui/layui.js")
			 ->addJs("js/pages/admin/pageOpe.js")
			 ->addJs("js/pages/admin/myDelivery/wlgslist.js");
		
		$this->view->pick("admin/myDelivery/wlgslist");
	}
	
	/**
	 * 添加物流公司
	 */
	public function wlgsAddPageAction(){
		$this->assets
			 ->addCss("css/static/h-ui/H-ui.min.css")
			 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
			 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
			 ->addCss("css/layui/layui.css")
			 ->addCss("css/pages/admin/public.css")
			 ->addCss("css/pages/admin/myDelivery/wlgsAdd.css")
			 ->addJs("lib/jquery/1.9.1/jquery.min.js")
			 ->addJs("lib/layui/layui.js")
			 ->addJs("js/pages/admin/pageOpe.js")
			 ->addJs("js/pages/admin/myDelivery/wlgsAdd.js");
		
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		
		//获取物流公司信息
		$lcInfo = LogisticsShop::lcInfo($id, $this->session->get('sid'));
		
		//所有物流公司
		$wlall = Logistics::wlgsList();
		if (!is_array($wlall)) $wlall = array();
		
		$wlallArr = array();
		foreach ($wlall as $k=>$v){
			if (!isset($wlgsArr[$v['cys']])) $wlgsArr[$v['cys']] = array();
			
			$wlgsArr[$v['cys']][$v['code']] = $v;
		}
		
		$ccids = array();
		foreach ($this->cysarr as $k=>$v){
			array_push($ccids, array('ccid'=>$k, 'ccname'=>$v));
		}
		
		if (!is_array($lcInfo)) {
			$this->view->id = 0;
			$this->view->ccys= 0;
			$this->view->cwlgs = array();
			$this->view->lcifno = array(
					'shop_id'=>'', 'name'=>'', 'description'=>'',
					'printkd'=>'', 'remark'=>'', 'sort'=>'', 'default'=>'',
					'customer_name'=>'', 'customer_pwd'=>'', 'station_code'=>'',
					'station_name'=>'', 'month_code'=>'', 'nickname'=>''
			);
			$this->view->isaccount = '0';
		}else {
			$this->view->id = $id;
			$this->view->ccys = $lcInfo['ccid'];
			$this->view->cwlgs = $wlgsArr[$lcInfo['ccid']];
			$this->view->lcifno = $lcInfo;
			$isaccount = $wlgsArr[$lcInfo['ccid']][$lcInfo['code']]['isaccount']=='1'?1:0;
			$this->view->isaccount = $isaccount;
		}
		
		$this->view->cys = $ccids;
		$this->view->wlgs = json_encode($wlgsArr);
		
		$this->view->pick("admin/myDelivery/wlgsAdd");
	}
	
	/**
	 * 获取店铺物流
	 */
	public function shopwlgsListAction(){
		$lcs = LogisticsShop::shopAllWl($this->session->get('sid'));
		
		if ($lcs=='DATAERR' || $lcs=='DATAEXCEPTION') $lcs = array();
		
		foreach ($lcs as $k=>$v){
			if ($v['default']=='D1') $lcs[$k]['default'] = '是';
			else $lcs[$k]['default'] = '';
		}
		
		$this->tableData($lcs, 0, '加载成功!');
	}
	
	public function saveLcAction(){
		if ($this->request->isPost()){
			$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
			$cys = isset($_POST['cys']) ? $_POST['cys'] : null;
			$wlgs = isset($_POST['wlgs']) ? $_POST['wlgs'] : null;
			$nickname = isset($_POST['nickname']) ? $_POST['nickname'] : null;
			$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
			$sort = isset($_POST['sort']) ? intval($_POST['sort']) : 0;
			$default = isset($_POST['default']) ? $_POST['default'] : false;
			
			$cname = isset($_POST['customer_name']) ? $_POST['customer_name'] : '';
			$cpwd = isset($_POST['customer_pwd']) ? $_POST['customer_pwd'] : '';
			$stationCode = isset($_POST['station_code']) ? $_POST['station_code'] : '';
			$stationName = isset($_POST['station_name']) ? $_POST['station_name'] : '';
			$monthCode= isset($_POST['month_code']) ? $_POST['month_code'] : '';
			
			if (!$cys || !$wlgs){ $this->err('数据错误'); exit(); }
			
			$wl = Logistics::getWlinfo('code', $wlgs);
			if (!is_array($wl)) { $this->err('数据异常'); exit(); }
			
			$result = LogisticsShop::saveLogistics(array(
					'shop_id'=>$this->session->get('sid'), 'name'=>$wl['name'],
					'description'=>$wl['name'], 'printkd'=>'S1', 'code'=>$wlgs,
					'remark'=>$remark, 'sort'=>$sort, 'default'=>$default, 'cys'=>$cys,
					'customer_name'=>$cname, 'customer_pwd'=>$cpwd, 'station_code'=>$stationCode,
					'station_name'=>$stationName, 'month_code'=>$monthCode, 'nickname'=>$nickname
			), $id);
			
			if ($result == 'SUCCESS') $this->msg('success');
			else $this->err('操作失败');
		}else $this->err('请求方式错误');
	}
	
	/**
	 * 删除店铺物流
	 */
	public function delShopWlgsAction(){
		if ($this->request->isPost()){
			$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
			
			if (!$id) { $this->err('数据错误'); exit(); }
			
			$result = LogisticsShop::delLogistics($id, $this->session->get('sid'));
			if ($result == 'SUCCESS') $this->msg('success');
			else if ($result == 'OPEFILE') $this->err('操作失败');
			else if ($result == 'DATAEXCEPTION') $this->err('数据异常');
		}else $this->err('请求方式错误');
	}
	
	//---------
	// 发货地址
	//---------
	public function shipAddressPageAction(){
		$this->assets
			 ->addCss("css/static/h-ui/H-ui.min.css")
			 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
			 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
			 ->addCss("css/layui/layui.css")
			 ->addCss("css/pages/admin/public.css")
			 ->addCss("css/pages/admin/myDelivery/shipAddress.css")
			 ->addJs("lib/jquery/1.9.1/jquery.min.js")
			 ->addJs("lib/layui/layui.js")
			 ->addJs("js/pages/admin/pageOpe.js")
			 ->addJs("js/pages/admin/myDelivery/shipAddress.js");
		
		$this->view->pick("admin/myDelivery/shipAddress");
	}
	
	/**
	 * 添加发货地址
	 */
	public function saaddPageAction(){
		$this->assets
			 ->addCss("css/static/h-ui/H-ui.min.css")
			 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
			 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
			 ->addCss("css/layui/layui.css")
			 ->addCss("css/pages/admin/public.css")
			 ->addCss("css/pages/admin/myDelivery/saadd.css")
			 ->addJs("lib/jquery/1.9.1/jquery.min.js")
			 ->addJs("lib/layui/layui.js")
			 ->addJs("js/pages/admin/pageOpe.js")
			 ->addJs("js/pages/admin/myDelivery/saadd.js");
		
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		$this->view->id = $id;
		
		$asinfo = ShipAddress::saInfo($id, $this->session->get('sid'));
		
		if ($id){
			$this->view->sheng = $asinfo['sheng'];
		}else {
			$sheng = Area::getAllArea(0);
			$this->view->sheng = $sheng;
		}
		$this->view->shi = $asinfo['shi'];
		$this->view->qu = $asinfo['qu'];
		$this->view->jd = $asinfo['jd'];
		$this->view->addressInfo = $asinfo['addressInfo'];
		
		$this->view->pick("admin/myDelivery/shipAddressAdd");
	}
	
	
	
	/**
	 * 获取发货地址
	 */
	public function getSAListAction(){
		$sid = $this->session->get('sid');
		$result = ShipAddress::getSAs('sid', $sid, array(
				'conditions'=>"shop_id=$sid and status='S1'",
				'order'		=> 'sort desc'
		));
		
		if (is_array($result)){
			$this->tableData($result, 0, '加载成功!');
		}else $this->tableData(array(), 0, '加载成功!');
	}
	
	/**
	 * 根据地区id获取子地区
	 */
	public function getAreaChildAction(){
		if ($this->request->isPost()){
			$aid = isset($_POST['aid']) ? intval($_POST['aid']) : null;
			if ($aid==null&& $aid!=0) { $this->err('数据错误'); exit(); }
			
			$areaArr = array();
			if($aid){
				$area = Area::getAllArea($aid);
				foreach ($area as $k=>$v){
					$areaArr[$k] = array('id'=>$v['id'], 'pid'=>$v['parent_id'], 'name'=>$v['area_name']);
				}
			}
			
			$this->result(1, 'success', $areaArr);
		}
	}
	
	/**
	 * 保存发货地址
	 */
	public function saveSaAction(){
		if ($this->request->isPost()){
			$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
			$sheng = isset($_POST['sheng']) ? intval($_POST['sheng']) : null;
			$shi = isset($_POST['shi']) ? intval($_POST['shi']) : null;
			$qu = isset($_POST['qu']) ? intval($_POST['qu']) : null;
			$jd = isset($_POST['jd']) ? intval($_POST['jd']) : null;
			$address = isset($_POST['address']) ? $_POST['address'] : null;
			$postcode = isset($_POST['postcode']) ? $_POST['postcode'] : null;
			$tel = isset($_POST['tel']) ? $_POST['tel'] : null;
			$fhname = isset($_POST['fhname']) ? $_POST['fhname'] : null;
			$default = isset($_POST['default']) ? $_POST['default'] : false;
			
			if (!$sheng || !$shi || !$qu || !$address || !$tel || !$fhname){
				$this->err('数据错误'); exit();
			}
			$areaIds = $sheng.','.$shi.','.$qu;
			if ($jd) $areaIds .= ','.$jd;
			$result = ShipAddress::saveSa(array(
					'shop_id'=>$this->session->get('sid'), 'area_ids'=>$areaIds,
					'address'=>$address, 'postcode'=>$postcode, 'tel'=>$tel,
					'fhname'=>$fhname, 'default'=>$default
			), $id);
			if ($result == 'SUCCESS') $this->msg('success');
			
		}else $this->err('请求方式错误');
	}
	
	/**
	 * 删除发货地址
	 */
	public function delSaAction(){
		if ($this->request->isPost()){
			$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
			
			if (!$id) { $this->err('数据错误'); exit(); }
			
			$result = ShipAddress::delSa($id, $this->session->get('sid'));
			if ($result == 'SUCCESS') $this->msg('success');
			else if ($result == 'OPEFILE') $this->err('操作失败');
			else if ($result == 'DATAEXCEPTION') $this->err('数据异常');
		}
	}
}

