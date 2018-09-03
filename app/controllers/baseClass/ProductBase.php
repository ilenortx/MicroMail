<?php

/**
 * 产品
 * @author xiao
 *
 */
class ProductBase extends ControllerBase {
	
	/**
	 * 获取产品记录
	 */
	public static function getPro($params=null){
		$conditions = array();
		
		if (isset($params['conditions'])) $conditions['conditions'] = $params['conditions'];
		if (isset($params['columns'])) $conditions['columns'] = $params['columns'];
		if (isset($params['order'])) $conditions['order'] = $params['order'];
		if (isset($params['limit'])) $conditions['limit'] = $params['limit'];
		
		if (count($conditions) > 0) $pros = Product::find($conditions);
		else $pros = Product::find();
		
		$proArr = array();
		if ($pros){
			foreach ($pros as $k=>$v){
				$proArr[$v->id] = $v->toArray();
			}
		}
		
		return $proArr;
	}
	
}