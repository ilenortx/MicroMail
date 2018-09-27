<?php

/**
 * 定时任务
 * @author xiao
 *
 */
class TimedTask{
	
	private static $ttpath = APP_PATH.'/controllers/timedTask/config.ini';
	
	/**
	 * 获取所有定时任务
	 */
	public static function allTimedTask(){
		$tts = IniFileOpe::getIniFile(self::$ttpath);
		
		if ($tts) return $tts;
		else return array();
	}
	
	/**
	 * 更新任务信息
	 */
	public static function updateTimeTask($datas, $sections=''){
		return IniFileOpe::reinitFile(self::$ttpath, $datas, $sections);
	}
	
	/**
	 * 修改规则
	 */
	public static function reRuleSections(){
		
	}
	
	/**
	 * 修改是否启用
	 */
	public static function reStatusSections(){
		
	}
	
	/**
	 * 修改最后一次执行时间
	 */
	public static function reLetimeSections(){
		
	}
	
	/**
	 * 获取任务信息
	 */
	public static function timedTaskInfo($sections){
		$ttinfo = IniFileOpe::getIniFile(self::$ttpath, $sections);
		
		return $ttinfo;
	}
	
}