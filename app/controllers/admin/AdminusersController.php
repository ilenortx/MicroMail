<?php

/**
 * 用户(admin-user和user)
 * @author xiao
 *
 */
class AdminusersController extends AdminBase{
	
	/**
	 * 验证是否登陆或session有效
	 */
	public function initialize(){
		if (!$this->session->has("uid") || $this->session->get("uid")==""){
			header("Location: ../Adminlogin/index");
		}
	}
	
    public function indexAction(){

    }
    
    //----------
    // 管理员管理
    //----------
    /**
     * 管理员用户列表页面
     */
    public function adminUserListAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/layui/layui.css")
	    	 ->addCss("css/pages/admin/public.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layui/layui.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/pages/admin/adminUsers/admin.js");
    	
	    $aus = Adminuser::ausersList('shop', array('sid'=>$this->session->get('sid')));
	    if (!is_array($aus)) $aus = array();
	    
	    $this->view->userLists = $aus;
	    	 
    	$this->view->pick("admin/adminUsers/adminUserList");
    }
    /**
     * 获取所有管理员列表
     */
	public function getAdminUserListAction(){
		$aaData['aaData'] = $this->usersListAction();
		echo json_encode($aaData['aaData']);
	}
	
	/**
	 * 所有管理员
	 */
	public function shopAdminAction(){
		$sid = $this->session->get('sid');
		$aus = Adminuser::ausersList('shop', array('sid'=>$sid));
		
		$auarr = array();
		if (gettype($aus) == 'object'){
			foreach ($aus as $k=>$v){
				$auarr[$k] = $v->toArray();
				
				if ($v->status == 'S0') $auarr[$k]['statusdesc'] = '<span class="label label-default radius">已禁用</span>';
				else if ($v->status == 'S1') $auarr[$k]['statusdesc'] = '<span class="label label-success radius">启用</span>';
				
				$auarr[$k]['addtime'] = empty($v->addtime) ? '' : date('Y-m-d', $v->addtime);
			}
		}
		
		$this->tableData($auarr);
	}
	
	/**
	 * 单个修改管理员状态
	 */
	public function setAdminUserStatusAction(){
		$uid = $this->request->getPost("uid");
		$status= $this->request->getPost("status");
		
		$result = Adminuser::setAUserStatus($uid, $status, $this->session->get('sid'));
		
		if ($result['status'] == 0) $this->err($result['err']);
		else if ($result['status']==1 && $status=='S2') $this->msg('SUCCESS');
		else {
			if ($status == 'S0') $result['auinfo']['statusdesc'] = '<span class="label label-default radius">已禁用</span>';
			else $result['auinfo']['statusdesc'] = '<span class="label label-success radius">启用</span>';
			
			$this->result(1, 'success', array('auinfo'=>$result['auinfo']));
		}
	}
    
	
	/**
	 * 管理员编辑页面
	 */
	public function adminEditPageAction(){
		$this->assets
			 ->addCss("css/static/h-ui/H-ui.min.css")
			 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
			 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
			 ->addCss("css/layui/layui.css")
			 ->addCss("css/pages/admin/public.css")
			 ->addCss("css/pages/admin/adminUsers/edit.css")
			 ->addJs("lib/jquery/1.9.1/jquery.min.js")
			 ->addJs("lib/layui/layui.js")
			 ->addJs("lib/layer/layer.js")
			 ->addJs("js/pages/admin/adminUsers/edit.js");
		
		$id = (isset($_GET['id'])&&intval($_GET['id'])) ? intval($_GET['id']) : 0;
		
		$adminInfo = Adminuser::adminInfo($id, $this->session->get('sid'));
		$this->view->adminInfo = $adminInfo;
		$this->view->mtype = $this->getMtype();
		$this->view->roleArr = Adminuser::adminRoles($adminInfo['rids'], $this->session->get('sid'));
		
		$this->view->pick('admin/adminUsers/adminEdit');
	}
	
	/**
	 * 管理员编辑
	 */
	public function adminEditAction(){
		if ($this->request->isPost()){
			$id = (isset($_POST['id'])&&intval($_POST['id'])) ? intval($_POST['id']) : 0;
			$name = isset($_POST['name']) ? $_POST['name'] : '';
			$uname = isset($_POST['uname']) ? $_POST['uname'] : '';
			$pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
			$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
			$email = isset($_POST['email']) ? $_POST['email'] : '';
			$roles = isset($_POST['roles']) ? trim($_POST['roles'], ',') : '';
			$mtyp = isset($_POST['mtyp']) ? $_POST['mtyp'] : 'T3';
			
			if (!$name || !$uname){ $this->err('参数错误!'); exit(); }
			if (!strlen($roles)){ $this->err('职位至少选择一项!'); exit(); }
			
			$sid = $this->session->get('sid');
			$aresult = Adminuser::adminEdit($id, $sid, array(
					'name'=>$name, 'uname'=>$uname, 'pwd'=>$pwd, 'phone'=>$phone,
					'email'=>$email, 'mtype'=>$mtyp
			));
			if (gettype($aresult) == 'object'){
				//修改manager_role
				MmManagerRole::adminRoleEdit('aobj', $aresult, $roles);
				
				$this->msg('success');
			}else if ($aresult == 'ADMIN_NOT_EXIST') $this->err('管理员不存在!');
			else if ($aresult == 'RIGHTS_ERR') $this->err('权限不够!');
			else if ($aresult == 'ADMIN_EXIST') $this->err('管理员一存在!');
			else $this->err('操作失败!');
		}else $this->err('请求方式错误!');
	}
	
	
	//----------
	// 职位管理
	//----------
	/**
	 * 所有职位页面
	 */
	public function rolePageAction(){
		$this->assets
			 ->addCss("css/static/h-ui/H-ui.min.css")
			 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
			 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
			 ->addCss("css/layui/layui.css")
			 ->addCss("css/pages/admin/public.css")
			 ->addJs("lib/jquery/1.9.1/jquery.min.js")
			 ->addJs("lib/layui/layui.js")
			 ->addJs("js/pages/admin/adminUsers/role.js");
		
		$this->view->pick('admin/adminUsers/role');
	}
	
	/**
	 * 职位编辑页面
	 */
	public function roleEditPageAction(){
		$this->assets
			 ->addCss("css/static/h-ui/H-ui.min.css")
			 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
			 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
			 ->addCss("css/layui/layui.css")
			 //->addCss("css/pages/admin/public.css")
			 ->addCss("css/pages/admin/adminUsers/edit.css")
			 ->addJs("lib/jquery/1.9.1/jquery.min.js")
			 ->addJs("lib/layui/layui.js")
			 ->addJs("lib/layer/layer.js")
			 ->addJs("js/pages/admin/adminUsers/edit.js");
		
		$id = (isset($_GET['id'])&&intval($_GET['id'])) ? intval($_GET['id']) : 0;
		
		$rights = $this->shopRights($this->session->get('sid'));//获取当前店铺所有权限
		$roleInfo = MmRole::getRoleInfo($id);
		
		$rArr = array();//权限列表
		if (is_array($rights)){
			//获取所有应用
			$apArr = MmApps::getApps(array('conditions'=>"status=?1",'bind'=>array(1=>'S1')));
			if (gettype($apArr)=='object'){
				$apArr = $apArr->toArray(); $aas = array();
				foreach ($apArr as $k=>$v){ $aas[$v['id']] = $v; }
				$apArr = $aas;
			}else $apArr = array();
			
			//获取所有操作码
			$oArr = MmOpcode::getOpcodes(array('conditions'=>"status=?1",'bind'=>array(1=>'S1')));
			if (gettype($oArr)=='object'){
				$oArr = $oArr->toArray(); $oas = array();
				foreach ($oArr as $k=>$v){ $oas[$v['id']] = $v; }
				$oArr = $oas;
			}else $oArr = array();
			
			$arights = array();//职位权限
			if ($id) {//如果id不为0，获取职位已有权限
				$rr = $roleInfo['rjson'];//获取职位权限
				if (is_array($rr)) {//判断职位权限是否存在
					foreach ($rr as $k=>$v){ $arights[$k] = $v['rjson']; }
				}
			}
			
			foreach ($rights as $k=>$v){
				if (isset($apArr[$v['paid']])){//判断应用是否存在
					if (!isset($rArr[$v['paid']])) {
						$rArr[$v['paid']] = array();//添加
						$rArr[$v['paid']]['pappInfo'] = $apArr[$v['paid']];//获取一级菜单信息
					}
					
					$rArr[$v['paid']]['app'] = array();//二级菜单信息
					foreach ($v['aids'] as $k1=>$v1){
						$appInfo = $apArr[$v1];
						
						$opcode = array();//操作码
						foreach ($v['oids'][$v1] as $k2=>$v2){
							if (in_array($oArr[$v2]['id'], ($arights[$v['paid']][$v1]))) $oArr[$v2]['checked']='1';
							else $oArr[$v2]['checked']='0';
							if (isset($oArr[$v2])) array_push($opcode, $oArr[$v2]);
						}
						array_push($rArr[$v['paid']]['app'], array('appInfo'=>$appInfo, 'opcode'=>$opcode));
					}
				}
			}
		}
		
		$this->view->rarr = $rArr;
		$this->view->roleInfo = $roleInfo;
		
		$this->view->pick('admin/adminUsers/roleEdit');
	}
	
	/**
	 * 获取店铺所有职位
	 */
	public function shopRolesAction(){
		//获取页面参数
		$page = (isset($_GET['page'])&&intval($_GET['page'])) ? intval($_GET['page']) : 0;
		$limit = (isset($_GET['limit'])&&intval($_GET['limit'])) ? intval($_GET['limit']) : 0;
		
		$sid = $this->session->get('sid');
		$srs = MmRole::shopRoles($sid);
		
		$status = array('S1'=>'正常', 'S2'=>'禁用');
		foreach ($srs as $k=>$v){
			$srs[$k]['addtime'] = date('Y-m-d H:i:s', $v['addtime']);
			$srs[$k]['status'] = $status[$v['status']];
		}
		
		$this->tableData($srs, 0, '加载成功!', array('page'=>$page, 'limit'=>$limit));
	}
	
	/**
	 * 职位编辑
	 */
	public function roleEditAction(){
		if ($this->request->isPost()){
			$id = (isset($_POST['id'])&&intval($_POST['id'])) ? intval($_POST['id']) : 0;
			$name = isset($_POST['name']) ? $_POST['name'] : '';
			$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
			$oitems = isset($_POST['oitems']) ? trim($_POST['oitems'], ',') : '';
			
			if(!$name){ $this->err('名称必填!'); exit(); }
			if (!strlen($oitems)){ $this->err('职位权限至少选择一项!'); exit(); }
			
			$rjson = MmRole::rightToJson($oitems);
			
			$sid = $this->session->get('sid'); //$aid = $aid==0 ? 1 : $aid;
			
			$result = MmRole::roleEdit($id, array('sid'=>$sid, 'name'=>$name, 'remark'=>$remark), $rjson);
			
			if ($result == 'SUCCESS') $this->msg('success');
			else if ($result == 'DATAERR') $this->err('数据错误!');
			else if ($result == 'OPEFILE') $this->err('操作失败!');
			else $this->err($result);
		}else $this->err('请求方式错误!');
	}
	
	/**
	 * 职位删除
	 */
	public function roleDelAction(){
		if ($this->request->isPost()){
			$id = (isset($_POST['id'])&&intval($_POST['id'])) ? intval($_POST['id']) : 0;
			
			if(!$id){ $this->err('数据错误!'); exit(); }
			
			$result = MmRole::roleDel($id, $this->session->get('sid'));
			
			if ($result == 'SUCCESS') $this->msg('success');
			else if ($result == 'OPEFILE') $this->err('操作失败!');
			else if ($result == 'DATAEXCEPTION') $this->err('数据异常');
		}else $this->err('请求方式错误!');
	}
	
	
	//----------
	// 入驻店铺权限
	//----------
	public function shopRightsPageAction(){
		$this->assets
			 ->addCss("css/static/h-ui/H-ui.min.css")
			 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
			 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
			 ->addCss("css/layui/layui.css")
			 //->addCss("css/pages/admin/public.css")
			 ->addCss("css/pages/admin/adminUsers/edit.css")
			 ->addJs("lib/jquery/1.9.1/jquery.min.js")
			 ->addJs("lib/layui/layui.js")
			 ->addJs("lib/layer/layer.js")
			 ->addJs("js/pages/admin/adminUsers/edit.js");
		
		$id = (isset($_GET['id'])&&intval($_GET['id'])) ? intval($_GET['id']) : 0;
		
		//获取所有应用
		$apArr = MmApps::objIdToArr(MmApps::getApps(array('conditions'=>"status=?1",'bind'=>array(1=>'S1'))));
		
		//获取所有操作码
		$oArr = MmOpcode::objIdToArr(MmOpcode::getOpcodes(array('conditions'=>"status=?1",'bind'=>array(1=>'S1'))));
		
		$rights = MmShopRights::shopRirghts($this->session->get('sid'));//所有权限
		$arights = MmShopRights::shopAllRights();
		
		$rArr = array();//权限列表
		if (is_array($rights)){
			foreach ($rights as $k=>$v){
				if (isset($apArr[$v['paid']])){//判断应用是否存在
					if (!isset($rArr[$v['paid']])) {
						$rArr[$v['paid']] = array();//添加
						$rArr[$v['paid']]['pappInfo'] = $apArr[$v['paid']];//获取一级菜单信息
					}
					
					$rArr[$v['paid']]['app'] = array();//二级菜单信息
					foreach ($v['aids'] as $k1=>$v1){
						$appInfo = $apArr[$v1];
						$opcode = array();//操作码
						foreach ($v['oids'][$v1] as $k2=>$v2){
							if (in_array($oArr[$v2]['id'], ($arights[$v['paid']]['rjson'][$v1]))) $oArr[$v2]['checked']='1';
							else $oArr[$v2]['checked']='0';
							if (isset($oArr[$v2])) array_push($opcode, $oArr[$v2]);
						}
						array_push($rArr[$v['paid']]['app'], array('appInfo'=>$appInfo, 'opcode'=>$opcode));
					}
				}
			}
		}
		
		$this->view->rarr = $rArr;
		
		$this->view->pick('admin/adminUsers/shopRights');
	}
	
	/**
	 * 入驻店铺权限编辑(不包括总店铺)
	 */
	public function shopRightEditAction(){
		if ($this->request->isPost()){
			$oitems = isset($_POST['oitems']) ? trim($_POST['oitems'], ',') : '';
			
			if(!$oitems){ $this->err('必须选择一项!'); exit(); }
			
			$rjson = MmRole::rightToJson($oitems);
			
			$result = MmShopRights::shopRightEdit(0, $rjson);
			
			if ($result == 'SUCCESS') $this->msg('success');
			else $this->err('操作失败!');
		}else $this->err('请求方式错误!');
	}
	
}

