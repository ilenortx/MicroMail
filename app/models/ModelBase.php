<?php

/**
 * 模型基类
 * @author xiao
 *
 */
class ModelBase extends \Phalcon\Mvc\Model{
	
	/**
	 * 查询总数
	 */
	public static function getCount($model, $conditions=null){
		$count = 0;
		
		if ($conditions && is_array($conditions) && count($conditions)){
			$count = $model::count($conditions);
		}else {
			$count = $model::count();
		}
		
		return $count;
	}
	
	/**
	 * 是否存在条件
	 */
	public static function isConditions($conditions=null){
		if ($conditions && is_array($conditions) && count($conditions)) return true;
		else return false;
	}
	
	/**
	 * model obj对象根据id生成数组
	 * @param unknown $obj
	 * @return array|unknown[]
	 */
	public static function objIdToArr($obj){
		$result = array();
		if (gettype($obj)=='object'){
			$arr = $obj->toArray(); $ads = array();
			foreach ($arr as $k=>$v){ $ads[$v['id']] = $v; }
			$result = $ads;
		}
		
		return $result;
	}
	
}