<?php

/**
 * 后台任务管理
 * @author xiao
 *
 */
class ASysManageController extends AdminBase{

	//----------
	// 定时任务
	//----------
	public function timedTaskPageAction(){
		$this->assets
			 ->addCss("css/static/h-ui/H-ui.min.css")
			 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
			 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
			 ->addCss("css/layui/layui.css")
			 ->addCss("css/pages/admin/public.css")
			 //->addCss("css/pages/admin/sysManage/tqmanage.css")
			 ->addJs("lib/jquery/1.9.1/jquery.min.js")
			 ->addJs("lib/layui/layui.js")
			 ->addJs("js/pages/admin/pageOpe.js")
			 ->addJs("js/pages/admin/sysManage/timedTask.js");
		
		$this->view->pick("admin/sysManage/timedTask");
	}
	
	public function timedTasksAction(){
		if ($this->session->get('scType') == 'ST0'){
			$tts = TimedTask::allTimedTask();
			
			foreach ($tts as $k=>$v){
				$tts[$k]['status'] = $v['status']=='S1'?'启用':'停用';
				$tts[$k]['letime'] = !empty($v['letime'])?date('Y-m-d H:i:s', $v['letime']):'';
			}
			
			$this->tableData($tts);
		}else $this->err('数据异常');
	}
	
	/**
	 * 获取定时任务信息
	 */
	public function timedTaskInfoAction(){
		if ($this->request->isPost()){
			$id = isset($_POST['id'])?trim($_POST['id']):'';
			if (!$id) { $this->err('数据错误'); exit(); }
			
			$ttinfo = TimedTask::timedTaskInfo($id);
			
			if ($ttinfo) $this->result(1, 'success', $ttinfo);
			else $this->err('数据异常');
			
		}else $this->err('请求方式错误');
	}
	
	/**
	 * 修改任务信息
	 */
	public function reTimedTaskInfoAction(){
		if ($this->request->isPost()){
			$id = isset($_POST['id'])?trim($_POST['id']):'';
			$rule = isset($_POST['rule'])?trim($_POST['rule']):'';
			$status = isset($_POST['status'])?trim($_POST['status']):'';
			if (!$id || !$rule || !$status) { $this->err('数据错误'); exit(); }
			
			$ttinfo = TimedTask::timedTaskInfo($id);
			
			if ($ttinfo && count($ttinfo)) {
				$ttinfo['rule'] = $rule;
				$ttinfo['status'] = $status;
				
				if (TimedTask::updateTimeTask($ttinfo, $id)) $this->msg('success');
			}else $this->err('数据异常');
		}else $this->err('请求方式错误');
	}
	
	
	//----------
	// 任务列表
	//----------
	public function taskListPageAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/layui/layui.css")
	    	 ->addCss("css/pages/admin/public.css")
	    	 ->addCss("css/pages/admin/sysManage/tqmanage.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layui/layui.js")
	    	 ->addJs("js/pages/admin/pageOpe.js")
	    	 ->addJs("js/pages/admin/sysManage/tqmanage.js");
    	
    	$this->view->pick("admin/sysManage/tqmanage");
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
	    	 ->addCss("css/pages/admin/sysManage/tqRecycleBin.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layui/layui.js")
	    	 ->addJs("js/pages/admin/pageOpe.js")
	    	 ->addJs("js/pages/admin/sysManage/tqRecycleBin.js");
    	
    	$this->view->pick("admin/sysManage/tqRecycleBin");
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

