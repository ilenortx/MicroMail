<?php

class TaskBase extends \Phalcon\CLI\Task{
	
	protected $sections;
	protected $timedTask;
	
	protected function taskVerify(){
		//获取活动定时任务
		$task = TimedTask::timedTaskInfo($this->sections);
		$this->timedTask = $task;
		
		//定时任务检测
		if (is_array($task) && isset($task['status']) && $task['status']=='S1') return true;
		else return false;
	}
	
	//修改任务时间
	protected function reLetime($time=''){
		$this->timedTask['letime'] = $time;
		
		$this->updataTaskInfo();
	}
	//更新任务信息
	protected function updataTaskInfo(){
		return TimedTask::updateTimeTask($this->timedTask, $this->sections);
	}
	
}