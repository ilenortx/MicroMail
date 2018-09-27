<?php

/**
 * 活动定时任务
 * @author xiao
 *
 */
class ActivityTask extends TaskBase{
	
	public function mainAction() {
		$this->sections = 'activity';
		
		if ($this->taskVerify()){
			self::CutPrice();//砍价活动
			self::GroupBooking();//团购活动
			self::Promotion();//限时促销
			
			$this->reLetime(time());
			echo 'success';
		}
	}
	
	//----------
	// 砍价活动
	//----------
	private function CutPrice(){
		$time = time();
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
	}

	//----------
	// 团购
	//----------
	private function GroupBooking(){
		$time = time();
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
			$gblids = trim($gblids, ',');
			$gbb = new GroupBookingBase();
			$gbb->gbRefunc($gblids);
		}
	}
	
	//----------
	// 限时促销
	//----------
	private function Promotion(){
		$time = time();
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