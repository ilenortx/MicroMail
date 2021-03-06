<?php

/**
 * 定时任务
 * @author xiao
 *
 */
class TimedTask extends ControllerBase{
	
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
	
	
	/**
	 * 执行定时任务
	 */
	public static function runTask($sections){
		$status = 0;
		$tti = self::timedTaskInfo($sections);
		if ($tti && is_array($tti)){
			if (parent::systype() == 'win'){//window系统
				$taskName = ucfirst($sections).'Task';
				exec("schtasks /run /tn $taskName", $out, $status);
			}else {//linux系统
				$taskName = ucfirst($sections);
				exec("php /home/wwwroot/MicroMail/app/cli.php $taskName main", $out, $status);
			}
		}
		
		return $status==0;
	}
	
	public static function endTask($sections){
		$status = 0;
		$tti = self::timedTaskInfo($sections);
		if ($tti && is_array($tti)){
			$taskName = ucfirst($sections).'Task';
			if (parent::systype() == 'win'){//window系统
				exec("schtasks /end /tn $taskName", $out, $status);
			}else {//linux系统
				
			}
		}
		
		return $status==0;
	}
	
}