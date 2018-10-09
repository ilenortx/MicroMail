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
	    	 ->addCss("css/static/h-ui.admin/style.css");
	    $this->assets
	    	 ->collection('js')
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js")
	    	 ->addJs("js/static/h-ui.admin/H-ui.admin.js")
	    	 ->addJs("lib/jquery.contextmenu/jquery.contextmenu.r2.js");
		
    	$this->view->scType = $this->session->get('scType');
    	$this->view->pick("admin/index");
    }
    
    /**
     * 加载我的桌面
     */
    public function loadHomeAction(){
    	$this->assets
	    	 ->collection('css1')
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css");
    	$this->assets
	    	 ->collection('css2')
	    	 ->addCss("css/static/h-ui.admin/style.css");
    	$this->assets
	    	 ->collection('js')
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js");
    	
	    $this->view->year = date("Y", time());
    	$this->view->pick("admin/welcome");
    }

}

