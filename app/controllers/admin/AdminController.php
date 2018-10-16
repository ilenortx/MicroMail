<?php

/**
 * 后台首页
 * @author xiao
 *
 */
class AdminController extends AdminBase{
	
	public function initialize(){
		if (!$this->session->has("uid") || $this->session->get("uid")==""){
			header("Location: ../Adminlogin/index");
		}
	}
	
    public function indexAction(){
    	$this->assets
    		 ->collection('css1')
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css");
    	$this->assets
	    	 ->collection('css2')
	    	 ->addCss("css/static/h-ui.admin/style.css")
    		 ->addCss("css/layui/layui.css");
	    $this->assets
	    	 ->collection('js')
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js")
	    	 ->addJs("js/static/h-ui.admin/H-ui.admin.js")
	    	 ->addJs("lib/jquery.contextmenu/jquery.contextmenu.r2.js")
	    	 ->addJs("lib/layui/layui.js")
	    	 ->addJs("js/pages/admin/pageOpe.js");
	    
	    $uid = $this->session->get('uid');
	    $sid = $this->session->get('sid');
	    $mtype = $this->getMtype();
	    $apps = $this->adminApps($uid, $mtype, $sid);
	    $minfo = $this->getMinfo();//获取个人信息
	    $minfo['addtime'] = date('Y-m-d', $minfo['addtime']);
	    	 
	    $this->view->mtype = $mtype;//获取管理员类型
	    $this->view->minfo = $minfo;
	    $this->view->apps = $apps;
	    
    	$this->view->scType = $this->session->get('scType');
    	$this->view->pick("admin/index");
    }
    
    /**
     * 加载我的桌面
     */
    public function loadHomeAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/layui/layui.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js");
    	
	    $this->view->year = date("Y", time());
    	$this->view->pick("admin/welcome");
    }
    
    /**
     * 修改用户信息
     */
    public function reAuinfoAction(){
    	if ($this->request->isPost()){
    		$uname = isset($_POST['uname']) ? trim($_POST['uname']) : '';
    		$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    		$email = isset($_POST['email']) ? trim($_POST['email']) : '';
    		
    		if (!$uname){ $this->err('数据错误!'); exit(); }
    		
    		$result = Adminuser::reAuinfo($this->session->get('uid'), array(
    				'uname'=>$uname, 'phone'=>$phone, 'email'=>$email
    		));
    		if (gettype($result) == 'object') {
    			$this->setMinfo(json_encode($result->toArray(), true));
    			$this->msg('修改成功!');
    		}
    		else if ($result == 'OPEFILE') $this->err('操作失败!');
    		else if ($result == 'DATAEXCEPTION') $this->err('数据异常!');
    		
    	}else $this->err('请求错误!');
    }
    
    /**
     * 修改密码
     */
    public function resetPwdAction(){
    	if ($this->request->isPost()){
    		$opwd = isset($_POST['opwd']) ? trim($_POST['opwd']) : '';
    		$pwd = isset($_POST['pwd']) ? trim($_POST['pwd']) : '';
    		$repwd = isset($_POST['repwd']) ? trim($_POST['repwd']) : '';
    		
    		if (!$opwd || !$pwd || !$repwd){ $this->err('数据错误!'); exit(); }
    		if ($pwd != $repwd){ $this->err('两次密码不一致!'); exit(); }
    		
    		$result = Adminuser::resetPwd($this->session->get('uid'), $opwd, $pwd);
    		if ($result == 'SUCCESS') $this->msg('修改成功!');
    		else if ($result == 'OPEFILE') $this->err('操作失败!');
    		else if ($result == 'OPWD_ERROR') $this->err('旧密码错误!');
    		else if ($result == 'DATAEXCEPTION') $this->err('数据异常!');
    		
    	}else $this->err('请求错误!');
    }

}

