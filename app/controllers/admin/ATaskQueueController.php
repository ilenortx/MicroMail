<?php

/**
 * 后台任务管理
 * @author xiao
 *
 */
class ATaskQueueController extends AdminBase{

    public function indexAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/layui/layui.css")
	    	 ->addCss("css/pages/admin/public.css")
	    	 ->addCss("css/pages/admin/taskQueue/tqmanage.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layui/layui.js")
	    	 ->addJs("js/pages/admin/pageOpe.js")
	    	 ->addJs("js/pages/admin/taskQueue/tqmanage.js");
    	
    	$this->view->pick("admin/taskQueue/tqmanage");
    }
    
    /**
     * 回收站
     */
    public function tqRecycleBinAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/layui/layui.css")
	    	 ->addCss("css/pages/admin/public.css")
	    	 ->addCss("css/pages/admin/taskQueue/tqRecycleBin.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layui/layui.js")
	    	 ->addJs("js/pages/admin/pageOpe.js")
	    	 ->addJs("js/pages/admin/taskQueue/tqRecycleBin.js");
    	
    	$this->view->pick("admin/taskQueue/tqRecycleBin");
    }
    
    
    
    /**
     * 获取任务列表
     */
    public function getTqlsAction(){
    	//获取页面参数
    	$page = (isset($_GET['page'])&&intval($_GET['page'])) ? intval($_GET['page']) : 0;
    	$limit = (isset($_GET['limit'])&&intval($_GET['limit'])) ? intval($_GET['limit']) : 0;
    	
    	$tqls = TaskQueue::getUnDelTqList($this->session->get('sid'));
    	
    	foreach ($tqls as $k=>$v){
    		$tqls[$k]['operate'] = "";
    		if ($v['status'] != 'S2'){
    			$tqls[$k]['operate'] = "<a class=\"layui-btn layui-btn-danger layui-btn-xs\" lay-event=\"del\"><i class=\"layui-icon\">&#xe640;</i> 删除</a>";
    		}
    		
    		if ($v['ttype']=='T2'){
    			$tqls[$k]['operate'] .= "<a class=\"layui-btn layui-btn-xs\"><i class=\"layui-icon\">&#xe641;</i> 下载</a>";
    		}
    	}
    	
    	$this->tableData($tqls, 0, '加载成功!', array('page'=>$page, 'limit'=>$limit));
    }
    
    /**
     * 删除任务
     */
    public function delTqsAction(){
    	if ($this->request->isPost()){
    		$ids = isset($_POST['ids']) ? trim($_POST['ids'], ',') : '';
    		if (empty($ids)) $this->err('数据错误');
    		
    		$sid = $this->session->get('sid');
    		
    		$result = TaskQueue::delTaskQueues($sid, $ids, 'S0');
    		if ($result== 'SUCCESS')$this->msg('success');
    		else if ($result == 'DATAERR') $this->err('数据错误');
    		else $this->err('操作失败');
    	}else $this->err('请求方式错误');
    }
    
    /**
     * 获取任务回收站
     */
    public function tqrbListAction(){
    	//获取页面参数
    	$page = (isset($_GET['page'])&&intval($_GET['page'])) ? intval($_GET['page']) : 0;
    	$limit = (isset($_GET['limit'])&&intval($_GET['limit'])) ? intval($_GET['limit']) : 0;
    	
    	$tqls = TaskQueue::getDelTqList($this->session->get('sid'));
    	
    	$this->tableData($tqls, 0, '加载成功!', array('page'=>$page, 'limit'=>$limit));
    }
    
    /**
     * 删除任务
     */
    public function deligTqsAction(){
    	if ($this->request->isPost()){
    		$ids = isset($_POST['ids']) ? trim($_POST['ids'], ',') : '';
    		if (empty($ids)) $this->err('数据错误');
    		
    		$sid = $this->session->get('sid');
    		
    		$result = TaskQueue::delTaskQueues($sid, $ids, 'del');
    		if ($result== 'SUCCESS')$this->msg('success');
    		else if ($result == 'DATAERR') $this->err('数据错误');
    		else $this->err('操作失败');
    	}else $this->err('请求方式错误');
    }
    
    /**
     * 还原
     */
    public function restoreTqsAction(){
    	if ($this->request->isPost()){
    		$ids = isset($_POST['ids']) ? trim($_POST['ids'], ',') : '';
    		if (empty($ids)) $this->err('数据错误');
    		
    		$sid = $this->session->get('sid');
    		
    		$result = TaskQueue::restoreTqs($sid, $ids);
    		if ($result== 'SUCCESS')$this->msg('success');
    		else if ($result == 'DATAERR') $this->err('数据错误');
    		else $this->err('操作失败');
    	}else $this->err('请求方式错误');
    }

}

