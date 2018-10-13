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
			$conditions = array('conditions'=>"status=?1",'bind'=>array(1=>'S1'));
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
		}else {
			$ar = $agent->MmAgentRights;//查询
			
			if (!$ar || $ar->satus=='S2'){//不存在单个代理商权限或禁用单个代理商权限
				$ar = VmAgentRights::findFirstByAid(0);
				
				if ($ar && count($ar)) $rights = json_decode($ar->rjson, true);
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
}

