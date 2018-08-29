<?php

/**
 * 用户(admin-user和user)
 * @author xiao
 *
 */
class AdminUsersController extends UserBaseController{
	
	/**
	 * 验证是否登陆或session有效
	 */
	public function initialize(){
		if (!$this->session->has("uid") || $this->session->get("uid")==""){
			header("Location: ../AdminLogin/index");
		}
	}
	
    public function indexAction(){

    }
    
    /**
     * 管理员用户列表
     */
    public function adminUserListAction(){
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
	    
	    $this->view->userLists = $this->usersListAction();
	    	 
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
	 * 单个修改管理员状态
	 */
	public function setAdminUserStatusAction(){
		$uid = $this->request->getPost("uid");
		$status= $this->request->getPost("status");
		
		echo json_encode($this->doUserStatusAction("au", $uid, $status));
	}
    
    
}

