<?php

/**
 * 系统配置
 * @author xiao
 *
 */
class AsysdeployController extends AdminBase{

    public function indexAction(){
    	
    }
    
    public function moduleMaintailPageAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
    		 ->addCss("css/layui/layui.css")
    		 ->addCss("css/pages/admin/public.css")
    		 ->addJs("lib/jquery/1.9.1/jquery.min.js")
    		 ->addJs("lib/layer/layer.js")
    		 ->addJs("lib/layui/layui.js")
    		 ->addJs("js/pages/admin/sysdeploy/moduleMaintain.js");
    	
    	$this->view->pick('admin/sysDeploy/moduleMaintain');
    }
    
    /**
     * 功能编辑页面
     */
    public function apEditPageAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/layui/layui.css")
	    	 ->addCss("css/admin/public.css")
	    	 ->addCss("css/admin/sysdeploy/edit.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layui/layui.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/pages/admin/sysdeploy/edit.js");
    	
    	$id = (isset($_GET['id'])&&intval($_GET['id'])) ? intval($_GET['id']) : 0;
    	$this->view->appInfo = $this->appDetail($id);
    	$this->view->sms = $this->stairMenu();
    	$this->view->opcodes = $this->allOpcode();
    	
    	$this->view->pick('admin/sysDeploy/appEdit');
    }
    
    /**
     * 操作码编辑页面
     */
    public function opcodeEditPageAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/layui/layui.css")
	    	 ->addCss("css/admin/public.css")
	    	 ->addCss("css/admin/sysdeploy/edit.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layui/layui.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/pages/admin/sysdeploy/edit.js");
    	
	    $id = (isset($_GET['id'])&&intval($_GET['id'])) ? intval($_GET['id']) : 0;
	    $this->view->opcodeInfo = $this->opcodeDetail($id);
    	
    	$this->view->pick('admin/sysDeploy/opcodeEdit');
    }
    
    /**
     * 获取所有功能
     */
    public function allAppsAction(){
    	$conditions = array('conditions'=>"status!=?1",'bind'=>array(1=>'S0'),'order'=>'sort asc');
    	$apps = MmApps::getApps($conditions);
    	
    	if (gettype($apps) == 'object') $apps = $apps->toArray();
    	else $apps = array();
    	
    	$count = MmApps::getCount('MmApps', $conditions);
    	
    	echo json_encode(array("code"=>0,"msg"=>"加载成功!","count"=>$count,"data"=>$apps));
    }
    
    /**
     * app操作
     */
    public function appEditAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    		$name = isset($_POST['name']) ? $_POST['name'] : '';
    		$ename = isset($_POST['ename']) ? $_POST['ename'] : '';
    		$path = isset($_POST['path']) ? $_POST['path'] : '';
    		$icon = isset($_POST['icon']) ? $_POST['icon'] : '';
    		$sort = isset($_POST['sort']) ? $_POST['sort'] : 0;
    		$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
    		$pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;
    		$oids = isset($_POST['oids']) ? trim($_POST['oids'], ',') : '';
    		
    		if(!$name || empty($icon)){
    			$this->err('数据错误!'); exit();
    		}
    		if ($pid && empty($oids)){//不为一级菜单，判断是否选择操作编码
    			$this->err('请先选择操作编码!'); exit();
    		}
    		
    		if ($id){//app已存在
    			$app = MmApps::findFirstById($id);
    			if (!$app || !count($app->toArray())){//判断数据是否存在
    				$this->err('应用不存在!'); exit();
    			}
    		}else {
    			$app = new MmApps();
    			
    			$app->addtime = time();
    		}
    		
    		$app->pid = $pid;
    		$app->name = $name;
    		$app->ename = $ename;
    		$app->path = $path;
    		$app->sort = $sort;
    		$app->icon = $icon;
    		$app->remark = $remark;
    		
    		if ($app->save()){
    			if ($pid > 0){
    				$aoc = $app->MmAppOpcode;
    				if (!$aoc || !count($aoc->toArray())) $aoc = new MmAppOpcode();
    				$aoc->oids = $oids; $aoc->aid = $app->id; $aoc->save();
    			}
    			$this->msg('success');
    		}else $this->err('操作失败!');
    	}else $this->err('请求方式错误!');
    }
    
    /**
     * 删除功能
     */
    public function appDelAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    		
    		if(!$id){ $this->err('数据错误!'); exit(); }
    		
    		$app = MmApps::findFirstById($id);
    		
    		if ($app) {
    			if ($app->delete()) $this->msg('success');
    			else $this->err('操作失败!');
    		}else $this->err('数据不存在!');
    	}else $this->err('请求方式错误!');
    }
    
	/**
	 * 获取所有操作码
	 */
    public function allOpcodeAction(){
    	$conditions = array('conditions'=>"status!=?1",'bind'=>array(1=>'S0'),'order'=>'sort asc');
    	$opcodes = MmOpcode::getOpcodes($conditions);
    	
    	if (gettype($opcodes) == 'object') $opcodes = $opcodes->toArray();
    	else $opcodes = array();
    	
    	$count = MmOpcode::getCount('MmOpcode', $conditions);
    	
    	echo json_encode(array("code"=>0,"msg"=>"加载成功!","count"=>$count,"data"=>$opcodes));
    }
    
    /**
     * 操作码操作
     */
    public function opcodeEditAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    		$name = isset($_POST['name']) ? $_POST['name'] : '';
    		$code = isset($_POST['code']) ? $_POST['code'] : '';
    		$sort = isset($_POST['sort']) ? $_POST['sort'] : 0;
    		
    		if(!$name || !$code || empty($code)){
    			$this->err('数据错误!'); exit();
    		}
    		
    		$opcode = MmOpcode::findFirstById($id);
    		
    		if (!$opcode || !count($opcode->toArray())) $opcode = new MmOpcode();
    		
    		$opcode->name = $name;
    		$opcode->code = $code;
    		$opcode->sort = $sort;
    		
    		if ($opcode->save()) $this->msg('success');
    		else $this->err('操作失败!');
    	}else $this->err('请求方式错误!');
    }
    
    /**
     * 操作码删除
     */
    public function opcodeDelAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    		
    		if(!$id){
    			$this->err('数据错误!'); exit();
    		}
    		
    		$opcode = MmOpcode::findFirstById($id);
    		
    		if ($opcode) {
    			if ($opcode->delete()) $this->msg('success');
    		}else $this->err('数据不存在!');
    	}else $this->err('请求方式错误!');
    }
    
    
    /**
     * 获取所有一级菜单
     */
    protected function stairMenu(){
    	$sms = MmApps::stairMenu();
    	
    	$smArr = array();
    	
    	if (gettype($sms) == 'object') $smArr = $sms->toArray();
    	
    	return $smArr;
    }
    
    /**
     * 所有操作码
     * @return number
     */
    protected function allOpcode(){
    	$opcodes = MmOpcode::getOpcodes(array(
    			'conditions'=> "status!=?1",
    			'bind'		=> array(1=>'S0'),
    			'order'		=> 'sort asc'
    	));
    	
    	return $opcodes->toArray();
    }
    
    /**
     * 获取功能详情
     */
    protected function appDetail($id=0){
    	$appArr = array(
    			'id'=>'', 'pid'=>'', 'name'=>'', 'ename'=>'','path'=>'',
    			'icon'=>'', 'sort'=>0, 'remark'=>'', 'status'=>'', 'oids'=>array()
    	);
    	
    	$app = MmApps::appDetail($id);
    	
    	if (gettype($app) == 'object') {
    		$appArr = $app->toArray();
    		$oids = $app->MmAppOpcode;
    		if ($oids) $appArr['oids'] = explode(',', trim($oids->oids, ','));
    		else $appArr['oids'] = array();
    	}
    	
    	return $appArr;
    }
    
    /**
     * 获取操作码详情
     */
    protected function opcodeDetail($id=0){
    	$odArr = array('id'=>'', 'name'=>'', 'code'=>'', 'sort'=>'', 'status'=>'');
    	
    	$od = MmOpcode::opcodeDetail($id);
    	
    	if (gettype($od) == 'object') $odArr = $od->toArray();
    	
    	return $odArr;
    }
    
}

