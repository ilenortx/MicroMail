<?php

class AMyDeliveryController extends AdminBase{
	
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
		$lcInfo = LogisticsCompany::lcInfo($id, $this->session->get('sid'));
		
		//读取物流公司json数据
		$cccid = -1;
		$lcjson = file_get_contents(APP_PATH.'/data/logistics.json');
		$lcArr = $lcjson ? json_decode($lcjson, true) : array();
		$cysArr = array(); $wlgsArr = array();	
		foreach ($lcArr as $k=>$v){
			if (!isset($cysArr[$v['ccid']])){
				array_push($cysArr, array('ccid'=>$v['ccid'], 'ccname'=>$v['ccname']));
				$wlgsArr[$v['ccid']] = $v['lcs'];
				
				if ($cccid == -1){
					foreach ($v['lcs'] as $k1=>$v1){
						if (is_array($lcInfo) && $lcInfo['code']==$v1['code']) {
							$cccid = $v['ccid']; break;
						}
					}
				}
			}
		}
		
		if (!is_array($lcInfo)) {
			$this->view->id = 0;
			$this->view->ccys= 0;
			$this->view->cwlgs = array();
			$this->view->lcifno = array(
					'shop_id'=>'', 'name'=>'', 'description'=>'',
					'printkd'=>'', 'remark'=>'', 'sort'=>'', 'default'=>''
			);
		}else {
			$this->view->id = $id;
			$this->view->ccys = $cccid;
			$this->view->cwlgs = $wlgsArr[$cccid];
			$this->view->lcifno = $lcInfo;
		}
		
		$this->view->cys = $cysArr;
		$this->view->wlgs = json_encode($wlgsArr);
		
		$this->view->pick("admin/myDelivery/wlgsAdd");
	}
	
	/**
	 * 获取店铺物流
	 */
	public function shopwlgsListAction(){
		$lcs = LogisticsCompany::shopAllWl($this->session->get('sid'));
		
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
			$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
			$sort = isset($_POST['sort']) ? intval($_POST['sort']) : 0;
			$default = isset($_POST['default']) ? $_POST['default'] : false;
			
			if (!$cys || !$wlgs){ $this->err('数据错误'); exit(); }
			
			//读取物流公司json数据
			$lcjson = file_get_contents(APP_PATH.'/data/logistics.json');
			$lcArr = $lcjson ? json_decode($lcjson, true) : array();
			$cysArr = array(); $wlgsArr = array();
			foreach ($lcArr as $k=>$v){
				if (!isset($cysArr[$v['ccid']])){
					array_push($cysArr, array('ccid'=>$v['ccid'], 'ccname'=>$v['ccname']));
					foreach ($v['lcs'] as $k1=>$v1){
						$wlgsArr[$v1['code']] = $v1;
					}
				}
			}
			if (!isset($wlgsArr[$wlgs])) { $this->err('数据异常'); exit(); }
			$result = LogisticsCompany::saveLogistics(array(
					'shop_id'=>$this->session->get('sid'), 'name'=>$wlgsArr[$wlgs]['name'],
					'description'=>$wlgsArr[$wlgs]['name'], 'printkd'=>'S1', 'code'=>$wlgs,
					'remark'=>$remark, 'sort'=>$sort, 'default'=>$default
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
			
			$result = LogisticsCompany::delLogistics($id, $this->session->get('sid'));
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

