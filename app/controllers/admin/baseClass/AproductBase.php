<?php

/**
 * 产品基类
 * @author xiao
 *
 */
class AproductBase extends AdminBase{
	
	public function proList($sid='all', $tj='all', $sort=false){
		$conditions = array( 'conditions'=> "del!=1" );
		if ($sid != 'all') $conditions['conditions'] .= " and shop_id=$sid";
		if ($tj != 'all') $conditions['conditions'] .= " and type=$tj";
		if ($sort) $conditions['order'] = $sort;
		
		$pros = Product::find($conditions);
		$proArr = array();
		
		if ($pros) $proArr = $pros->toArray();
		
		return $proArr;
	}
	
}