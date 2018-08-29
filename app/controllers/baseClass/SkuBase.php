<?php

/**
 * sku
 * @author xiao
 *
 */
class SkuBase extends ControllerBase{
	
	/**
	 * 修改产品sku
	 */
	public function reProSku($pid, $sku){
		foreach (ProductSku::find("pid=$pid") as $s=>$v){
			if (isset($sku[$v->skuid])){
				$v->price = $sku[$v->skuid]['skuPrice'];
				$v->stock = $sku[$v->skuid]['skuStock'];
				if ($v->save()) unset($sku[$v->skuid]);
			}else $v->delete();//删除原有记录
		}
		
		foreach ($sku as $k=>$v){
			$SKU = new ProductSku();
			$SKU->skuid = $k;
			$SKU->pid = $pid;
			$SKU->price = $v['skuPrice'];
			$SKU->stock = $v['skuStock'];
			$SKU->addtime = time();
			$SKU->save();
		}
	}
	
	/**
	 * 修改产品属性
	 */
	public function reProAttrs($pid, $ProAttrs){
		foreach (ProductAttrs::find("pid=$pid") as $k=>$v) {
			if (isset($ProAttrs[$v->attr_id])){
				$v->values = trim($ProAttrs[$v->attr_id], ',');
				if ($v->save()) unset($ProAttrs[$v->attr_id]);
			}else $v->delete();//删除原有记录
		}
		
		foreach ($ProAttrs as $k=>$v){
			$pa = new ProductAttrs();
			$pa->pid = $pid;
			$pa->attr_id = $k;
			$pa->values = trim($v, ',');
			$pa->save();
		}
	}
	
	/**
	 * 获取商品sku
	 */
	public function getProAttrs($pid){
		$attrsArr = array();
		//获取所有产品属性
		$proAttrs = ProductAttrs::find("pid=$pid");
		if ($proAttrs && count($proAttrs)){
			$paids = ''; $paidArr = array();
			foreach ($proAttrs as $k=>$v){
				$paids .= $v->attr_id.',';
				$paidArr[$v->attr_id] = explode(',', trim($v->values, ','));
			}
			$paids = trim($paids, ',');
			//获取属性
			$attrArr = array(); $avalArr = array();
			$attrs = ProductAttr::find("id in ($paids) order by sort desc");
			$avals = ProductAttrValue::find("pid in ($paids) order by sort desc");
			
			foreach ($attrs as $k=>$v){
				$attrArr[$v->id] = $v->name;
			}
			foreach ($avals as $k=>$v){
				$avalArr[$v->id] = $v->name;
			}
			
			//获取产品sku
			//$pskus = ProductSku::find("pid=$pid"); $pskuArr = array();
			//$skuArr = array();
			
			foreach ($paidArr as $k=>$v){
				$varr = array();
				foreach ($v as $k1=>$v1){
					array_push($varr, array('id'=>$v1, 'name'=>$avalArr[$v1]));
				}
				$attrsArr[$k]['id'] = $k;
				$attrsArr[$k]['cval'] = 0;
				$attrsArr[$k]['name'] = $attrArr[$k];
				$attrsArr[$k]['values'] = $varr;
			}
		}
		
		return $attrsArr;
	}
	
	/**
	 * 根据sku获取属性值
	 */
	public function skuToAttrs($sku){
		$skus = explode(',', $sku);
		
		$avals = ProductAttrValue::find("id in ($sku)");
		
		$avalArr = array();
		if ($avals) $avalArr = $avals->toArray();
		
		return $avalArr;
	}

	
	/**
	 * 获取sku
	 */
	public static function getSku($param=array()){
		$conditions = array();
		if (isset($param['conditions']) && !empty($param['conditions'])){
			$conditions['conditions'] = $param['conditions'];
		}
		
		if (isset($params['columns']) && !empty($params['columns'])) $carts['columns'] = $params['columns'];
		if (isset($params['order']) && !empty($params['order'])) $carts['order'] = $params['order'];
		if (isset($params['limit'])) $carts['limit'] = $params['limit'];
		
		if (count($conditions)){
			$skus = ProductSku::find($conditions);
		}else $skus = ProductSku::find();
		
		if ($skus) {
			$skuArr = array();
			foreach ($skus as $k=>$v){
				$skuArr[$v->pid.'-'.$v->skuid] = $v->toArray();
			}
			return $skuArr;
		}
		else return false;
	}
	
}