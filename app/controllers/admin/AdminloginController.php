<?php

/**
 * 用户登陆
 * @author xiao
 *
 */
class AdminloginController extends AdminBase{
	
    public function indexAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.login.css")
	    	 ->addCss("css/static/h-ui.admin/style.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/jquery/jquery.form.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js");
    	
	    $this->view->pick("admin/login");
    }
    
    /**
     * 登陆
     */
    public function loginAction(){
    	if ($this->request->isPost()){//判断是否是post数据
    		$name = $this->request->getPost("name");
    		$pwd = $this->request->getPost("pwd");
    		
    		$user = Adminuser::findFirstByName($name);
    		if ($user){
    			$user = $user->toArray();
    			if ($user['pwd'] == md5($pwd)){
    				$this->session->set("uid", $user['id']);
    				$this->session->set("sid", $user['sid']);
    				$shop = Shangchang::findFirstById($user['sid']);
    				$this->session->set("scType", $shop->sc_type);
    				
    				echo json_encode(array('status'=>1, 'msg'=>"success"));
    			}else echo json_encode(array('status'=>0, 'msg'=>"密码错误!"));
    		}else echo json_encode(array('status'=>0, 'msg'=>"用户不存在!"));
    	}
    }
    
    /**
     * 退出登陆
     */
    public function logoutAction(){
    	$this->session->destroy();
    	$this->dispatcher->forward(array("controller"=>"Adminlogin", "action"=>"index"));
    }

}

