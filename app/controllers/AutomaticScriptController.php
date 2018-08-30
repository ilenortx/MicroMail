<?php

/**
 * 自动执行脚本
 * @author xiao
 *
 */
class AutomaticScriptController extends ControllerBase{

    public function indexAction(){
    	$this->view->disable();
    	
    	//自动收货
    	$this->orderFinishAction();
    	
    	//月统计
    	$this->monthSumAction();
    }
    
    /**
     * 自动收货
     */
    public function orderFinishAction(){
    	//15天之前
    	$time = strtotime('15 day');
    	
    	$orders = Order::find("fhtime>'$time' and status=30 and type='weixin'");
    	
    	if ($orders) {
    		foreach ($orders as $k=>$v){
    			$v->status = 50;
    			$v->save();
    		}
    	}
    }
    
    /**
     * 月统计
     */
    public function monthSumAction(){
    	//月初4天
    	if (date("d", time()) < 20){
    		//查询是否统计过
    		$year = date("Y", time()); $month = date("m", time());
    		$itj = MonthSum::find("year='$year' and month='$month'");
    		
    		if ($itj && count($itj->toArray())){
    			return;
    		}
    		
    		$time = $year.'-'.$month;
    		$ords = Order::find(array(
    				'conditions'=> "status=50 and type='weixin' and FROM_UNIXTIME(finishtime,'%Y-%m')='{$time}'",
    				'columns'	=> "sum(price_h) as amount, shop_id, FROM_UNIXTIME(finishtime,'%Y-%m') as time",
    				'group'		=> "time,shop_id"
    		));
    		
    		if ($ords && count($ords->toArray())){
    			foreach ($ords as $k=>$v){
    				$ms = new MonthSum();
    				$ms->shop_id = $v->shop_id;
    				$ms->year = $year;
    				$ms->month = $month;
    				$ms->amount = $v->amount;
    				$ms->addtime = time();
    				$ms->status = "S0";
    				
    				$ms->save();
    			}
    		}
    	}
    }

    
    /**
     * 活动
     */
    public function asHdAction(){
    	$time = time();
    	//----------
    	// 砍价活动
    	//----------
    	$cp = CutPriceSprites::find("status!='S0' and status!='S3'");
    	if ($cp) {
    		foreach ($cp as $k=>$v){
    			if ($v->stime>$time && $v->status!='S1') { $v->status='S1'; $v->save(); }
    			else if ($v->stime<$time && $v->etime>$time && $v->status!='S2') { $v->status='S2'; $v->save(); }
    			else if ($v->etime<$time && $v->status!='S3') {
    				$v->status='S3'; $v->save();
    				
    				$ucp = CutPriceSpritesList::find("cp_id=$v->id");//用户砍价
    				if ($ucp){
    					foreach ($ucp as $k){
    						if ($k->cp_result == '1'){
    							$k->status = 'S2'; $k->cp_result = '2'; $k->save();
    						}
    					}
    					
    					//退款
    				}
    				
    				$pro = Product::find("hd_id=$v->id and hd_type='3'");//商品活动
    				if ($pro){
    					foreach ($pro as $k){
    						$k->hd_id = 0; $k->hd_type = '0'; $k->save();
    					}
    				}
    			}
    		}
    	}
    	
    	//----------
    	// 团购
    	//----------
    	$gb = GroupBooking::find("status!='S0' and status!='S3'"); $time = time();
    	if ($gb) {
    		foreach ($gb as $k=>$v){
    			if ($v->stime>$time && $v->status!='S1') { $v->status='S1'; $v->save(); }
    			else if ($v->stime<$time && $v->etime>$time && $v->status!='S2') { $v->status='S2'; $v->save(); }
    			else if ($v->etime<$time && $v->status!='S3') {
    				$v->status='S3'; $v->save();
    				
    				$pro = Product::find("hd_id=$v->id and hd_type='2'");//商品活动
    				if ($pro){
    					foreach ($pro as $k){ $k->hd_id = 0; $k->hd_type = '0'; $k->save(); }
    				}
    				
    				$gbm = GroupBookingList::find("gb_id=$v->id"); $gblids= '';
    				if ($gbm){
    					foreach ($gbm as $k=>$v){
    						$v->status = 'S3'; $v->save();
    						$gblids.= $v->id.',';
    					}
    					$gblids= trim($gblids, ',');//获取所有订单退款
    					$gbb = new GroupBookingBase();
    					$gbb->gbRefunc($gblids);
    				}
    			}
    		}
    	}
    	//团购超时退款 
    	$time = time();
    	$gbLot = GroupBookingList::find("etime<$time and status in ('S2','S1')");
    	if ($gbLot){
    		$gblids= '';
    		foreach ($gbLot as $k=>$v){
    			if ($v->status == 'S2'){
    				//$v->status = 'S4'; $v->save();
    				$gblids .= $v->id.',';
    			}
    			$v->status = 'S4'; $v->save();
    		}
    		//获取所有订单退款
    		$gblids= trim($gblids, ',');
    		$gbb = new GroupBookingBase();
    		$gbb->gbRefunc($gblids);
    	}
    	
    	
    	
    	//----------
    	// 限时促销
    	//----------
    	$ps = Promotion::find("status!='S0' and status!='S3'");
    	if ($ps){
    		foreach ($ps as $k=>$v){
    			if ($v->stime>$time && $v->status!='S1') { $v->status='S1'; $v->save(); }
    			else if ($v->stime<$time && $v->etime>$time && $v->status!='S2' && $v->status!='S4') { $v->status='S2'; $v->save(); }
    			else if ($v->etime<$time && $v->status!='S3' && $v->status!='S4') {
    				$v->status='S3'; $v->save();
    				
    				$pro = Product::find("hd_id=$v->id and hd_type='1'");//商品活动
    				if ($pro){
    					foreach ($pro as $k){
    						$k->hd_id = 0; $k->hd_type = '0'; $k->save();
    					}
    				}
    			}
    		}
    	}
    }
    
}

