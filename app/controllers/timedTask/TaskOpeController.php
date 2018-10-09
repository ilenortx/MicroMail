<?php

class TaskopeController extends ControllerBase{
	
	public function executeAction(){
		if ($this->request->isPost()){
			$id = isset($_POST['id']) ? trim($_POST['id']) : '';
			
			if (!$id) { $this->err('数据错误'); exit(); }
			if (TimedTask::runTask($id)) $this->msg('success');
			else $this->err('执行失败');
		}
	}
	
}