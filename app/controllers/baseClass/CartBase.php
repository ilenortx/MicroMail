<?php

/**
 * 购物车
 * @author xiao
 *
 */
class CartBase extends ApiBase {
	
	public $cartList = array();
	public $skuidArr = array();
	
	/**
	 * 获取购物车记录
	 */
	public function cartList($type='cids', $params=null){
		if ($type == 'cids'){//购物车id，多个用逗号隔开
			$cids = isset($params['cids'])?trim($params['cids'], ','):'';
			
			if ($cids){
				$carts = ShoppingChar::find(array(
						'conditions'	=> "id in ($cids)"
				));
				
				if (isset($params['columns'])) $carts['columns'] = $params['columns'];
				if (isset($params['order'])) $carts['order'] = $params['order'];
				if (isset($params['limit'])) $carts['limit'] = $params['limit'];
				
				if ($carts){ $this->cartList = $carts->toArray(); }
			}
		}else if ($type == 'uid'){
			
		}
	}
	
	/**
	 * 购物列表库存验证
	 */
	public function clStockVerify(){
		$skuCond = ''; $proidCond = '';
		foreach ($this->cartList as $k=>$v){
			if (!empty($v['skuid'])){//sku库存
				if (empty($skuCond)) $skuCond= "(skuid='{$v['skuid']}' and pid={$v['pid']})";
				else  $skuCond.= "( and skuid='{$v['skuid']}' and pid={$v['pid']})";
			}else {//商品库存
				$proidCond .= $v['pid'].',';
			}
		}
		$skus = array();
		if ($skuCond){
			$skus = SkuBase::getSku(array('conditions'=>$skuCond));
			if (is_array($skus)) $this->skuidArr = $skus;
		}
		
		$pros = array();
		if ($proidCond){//获取产品
			$proidCond = trim($proidCond,',');
			$pros = ProductBase::getPro(array('conditions'=>"id in ($proidCond)"));
		}
		
		if (is_array($skus) && is_array($pros)){
			$productSkuidStock = array();
			foreach ($this->cartList as $k=>$v){
				if (!empty($v['skuid'])){
					$sindex = $v['pid'].'-'.$v['skuid'];
					if (!isset($skus[$sindex]) || 
							intval($v['num'])>$skus[$sindex]['stock']){
						$productSkuidStock[$v['id']] = array(
								'cid'=>$v['id'], 'pid'=>$v['pid'],
								'cstock'=>$v['num'], 'rstock'=>!isset($skus[$sindex])?0:skus[$sindex]['stock']
						);
					}
				}else {
					if (!isset($pros[$v['pid']]) || $v['num']>$pros[$v['pid']]['num']){
						$productSkuidStock[$v['id']] = array(
								'cid'=>$v['id'], 'pid'=>$v['pid'],
								'cstock'=>$v['num'], 'rstock'=>!isset($pros[$v['pid']])?0:$pros[$v['pid']]['num']
						);
					}
				}
			}
			return $productSkuidStock;
		}else return false;
	}
	
	/**
	 * 验证购物车数据列表是否是单个店铺
	 */
	public function isSingleShop(){
		$cid = 0;
		foreach ($this->cartList as $k=>$v){
			if ($v['id']!=$cid && $cid!=0) return false;
			else $cid = $v['id'];
		}
		
		return true;
	}
	
	/**
	 * 获取购物车sku
	 */
	public function cartSkuid(){
		$skuCond = '';
		foreach ($this->cartList as $k=>$v){
			if (!empty($v['skuid'])){//sku库存
				if (empty($skuCond)) $skuCond= "(skuid='{$v['skuid']}' and pid={$v['pid']})";
				else  $skuCond.= "( and skuid='{$v['skuid']}' and pid={$v['pid']})";
			}
		}
		if ($skuCond){
			$skus = SkuBase::getSku(array('conditions'=>$skuCond));
			if (is_array($skus)) $this->skuidArr = $skus;
		}
	}
	
}