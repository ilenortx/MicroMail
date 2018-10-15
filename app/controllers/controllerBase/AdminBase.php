<?php

class AdminBase extends ControllerBase{
	
	public function initialize(){
		$this->view->setTemplateAfter('admin');
		
	}
	
	/**
	 * 获取店铺权限
	 * @param unknown $sid 店铺id
	 * @return string|array|mixed [{paid:1,aid:[1,2],oids:{1:[1,2],2:[1,2]}}]
	 */
	public function shopRights($sid){
		$shop = Shangchang::shopInfo($sid);
		if (gettype($shop) != 'object') return 'SHOP_NO_EXIST';//店铺不存在
		
		$rights = array();//所有权限
		if ($shop->sc_type == 'ST0'){//判断是否是自营
			$conditions = array('conditions'=>"status=?1",'bind'=>array(1=>'S1'),'order'=>'sort asc');
			$apps = MmApps::getApps($conditions);//查询所有应用 status='S1'
			if (gettype($apps) != 'object') return 'DATAEXCEPTION';//app数据异常
			
			$pidArr = array(); $aoArr = array();
			foreach ($apps as $k=>$v){
				if (!in_array($v->id, $pidArr) && $v->pid==0) {//判断pid
					array_push($pidArr, $v->id);
					$aoArr[$v->id] = array();
				}
				
				if ($v->pid > 0){//二级菜单获取操作码
					$aos = $v->MmAppOpcode;
					if ($aos && count($aos)){//获取应用所有操作码
						$aoArr[$v->pid]['paid'] = $v->pid;
						if (!isset($aoArr[$v->pid]['aids'])) $aoArr[$v->pid]['aids'] = array();
						array_push($aoArr[$v->pid]['aids'], $v->id);
						$aoArr[$v->pid]['oids'][$v->id] = explode(',', trim($aos->oids, ','));
					}else unset($aos[$v->id]);
				}
			}
			foreach ($aoArr as $k=>$v){
				array_push($rights, $v);
			}
		}else {//待修改
			$sr = $shop->MmShopRights;//查询
			
			if (!$sr|| $ar->satus=='S2'){//不存在单个代理商权限或禁用单个代理商权限
				$sr= MmShopRights::findFirstBySid(0);
				
				if ($sr && count($sr)) {
					$rights = json_decode($sr->rjson, true);
					foreach ($rights as $k=>$v){
						$rights[$k]['oids'] = $v['rjson'];
					}
				}
			}
		}
		return $rights;
	}
	
	/**
	 * 获取管理员类型
	 */
	public function getMtype(){
		$mtype = $this->session->get('mtype');
		
		return $mtype;
	}
	
	/**
	 * 获取个人信息
	 */
	public function getMinfo(){
		$minfo = $this->session->get('minfo');
		
		return json_decode($minfo, true);
	}
	
	/**
	 * 获取管理员所有得应用(一级菜单、二级菜单)
	 */
	public function adminApps($uid, $mtype='T3', $sid=0){
		$appArr = array();
		if ($mtype=='T0' || $mtype=='T1'){
			$apps = MmApps::getApps(array(//查询所有应用 status='S1'
					'conditions'=> "status=?1",
					'bind'		=> array(1=>'S1'),
					'order'		=> 'sort asc'
			));
			
			$pidArr = array(); $app = array();
			foreach ($apps as $k=>$v){
				if (!in_array($v->id, $pidArr) && $v->pid==0) {//判断pid
					array_push($pidArr, $v->id);
					$app[$v->id] = $v->toArray(); $app[$v->id]['child'] = array();
				}
				
				if ($v->pid > 0){//二级菜
					array_push($app[$v->pid]['child'], $v->toArray());
				}
			}
			foreach ($app as $k=>$v){
				if (count($v['child'])) array_push($appArr, $v);
			}
		}else if ($mtype=='T2'){
			$magager = Adminuser::adminInfo($uid, $sid);
			$sid = $magager['sid'];
			
			//查询是否有店铺单独权限
			$sapps = MmShopRights::shopRight($sid);
			
			if ($sapps && count($sapps->toArray())){
				$rArr = json_decode($sapps->rjson, true);
				
				//获取所有应用
				$apps = MmApps::objIdToArr(MmApps::getApps(array('conditions'=>"status=?1",'bind'=>array(1=>'S1'),'order'=>'sort asc')));
				
				$pidArr = array(); $app = array();
				foreach ($rArr as $k=>$v){
					if (isset($apps[$v['paid']])){
						array_push($pidArr, $v['paid']);
						$app[$v['paid']] = $apps[$v['paid']];
						$app[$v['paid']]['child'] = array();
						
						foreach ($v['aids'] as $k1=>$v1){//二级菜
							if (isset($apps[$v1])){
								array_push($app[$v['paid']]['child'], $apps[$v1]);
							}
						}
					}
				}
				foreach ($app as $k=>$v){
					if (count($v['child'])) array_push($appArr, $v);
				}
			}
		}else if ($mtype=='T3'){//普通管理员
			$roleids = array();
			
			//店铺单独权限
			$sapps = MmShopRights::shopRight($sid);
			if ($sapps && count($sapps->toArray())){
				$sapps = json_decode($sapps->rjson, true);
				
				$rids = MmManagerRole::adminRids($uid);
				//查询所有权限
				$rights = MmRoleRights::find("rid in ($rids)");
				
				//获取所有应用
				$apps = MmApps::objIdToArr(MmApps::getApps(array('conditions'=>"status=?1",'bind'=>array(1=>'S1'),'order'=>'sort asc')));
				
				$pidArr = array(); $app = array();
				foreach ($rights as $k=>$v){//循环编辑不同职位权限
					$rjson = json_decode($v->rjson, true);
					foreach ($rjson as $k1=>$v1){
						if (isset($apps[$v1['paid']]) && isset($sapps[$v1['paid']])){//判断是否存在
							if (!in_array($v1['paid'], $pidArr)){
								array_push($pidArr, $v1['paid']);
								$app[$v1['paid']] = $apps[$v1['paid']];
								$app[$v1['paid']]['child'] = array();
							}
							
							foreach ($v1['aids'] as $k2=>$v2){
								if (isset($apps[$v2])){
									if (!isset($app[$v1['paid']]['child'][$v2]) && in_array($v2, $sapps[$v1['paid']]['aids'])){
										$app[$v1['paid']]['child'][$v2] = $apps[$v2];
									}
								}
							}
						}
					}
				}
				foreach ($app as $k=>$v){
					if (count($v['child'])) array_push($appArr, $v);
				}
			}
		}
		return $appArr;
	}
	
	
}

