<?php

/**
 * 团购
 * @author xiao
 *
 */
class GroupBookingBase extends ControllerBase{
	
	//-------------
	//	团购信息
	//-------------
	/**
	 * 判断团购活动是否结束
	 * @param unknown $gbid GroupBooking id
	 * @return string S3结束  NEXIST不存在 OPEFILE操作失败
	 */
	public function gbIsOver($gbid){
		$gb = GroupBooking::findFirst($gbid);
		if($gb){
			if ($gb->status == 'S3') return true;//判断状态是否为结束状态
			if ($gb->etime<=time() && $gb->status!='S0'){//判断是否过时
				$gb->status = 'S3';
				if ($gb->save()) return 'S3';//修改状态为结束
				else return 'OPEFILE';//保存失败
			}else return $gb->status;
		}else 'NEXIST';
	}
	
	//-------------
	//	参团信息
	//-------------
	/**
	 * 获取已参团人数
	 * @param number $gblid GroupBookingList id
	 * @return number
	 */
	public static function jgbMans($gblid){
		return GroupBookingMans::count("gbl_id=$gblid");
	}
	
	/**
	 * 验证开团是否结束，结束修改状态
	 * @param unknown $gblid  GroupBookingList id
	 * @return boolean true true失败 false没失败 NEXIST不存在 OPEFILE操作失败
	 */
	public static function gblIsFile($gblid){
		$gbl = GroupBookingList::findFirst($gblid);
		
		if ($gbl){
			if ($gbl->status == 'S4') return true;//判断状态是否为结束状态
			if ($gbl->etime<=time() && ($gbl->status=='S1'||$gbl->status=='S2')){
				$gbl->status = 'S4';
				if ($gbl->save()) return 'S4';
				else return 'OPEFILE';
			}else return $gbl->status;
		}else 'NEXIST';//不存在
	}
	
	/**
	 * 判断团是否完成，完成并修改状态
	 * @param unknown $gblid GroupBookingList id
	 * @return string 状态 S0删除 S1未付款 S2进行中 S3活动结束 S4成团失败 S5成团成功
	 */
	public static function gblIsSuccess($gblid){
		$gbl = GroupBookingList::findFirst($gblid);
		
		if ($gbl){
			$gb = $gbl->GroupBooking;//获取团购活动信息
			if ($gb->status=='S3' || $gb->etime<time()){//团购活动结束
				//修改团购活动信息
				if ($gb->status=='S1' || $gb->status=='S2') { $gb->status=='S3'; $gb->save(); }
				//修改参团信息
				if ($gbl->status=='S1' || $gbl->status=='S2') { $gbl->status=='S3'; $gbl->save(); }
				
				return 'S3';//活动结束
			}
			
			if ($gbl->status!='S4' && self::gblIsFile($gblid)=='S4') return 'S4';//成团失败
			if ($gbl->status == 'S5') return 'S5';//已完成
			
			if ($gbl->status == 'S2'){//判断拼团是否进行中
				$jgbm = self::jgbMans($gblid);//获取参团人数
				if ($gb->mannum == $jgbm){
					$gbl->status = 'S5';
					if ($gbl->save()) return 'S5';
					else return 'OPEFILE';//操作失败
				}else return $gbl->status;
			}else return $gbl->status;
		}else return 'NEXIST';//不存在
	}
	
	/**
	 * 最后一人参团
	 * @param unknown $gblid $gblid GroupBookingList id
	 * @return string
	 */
	public static function isLmJgb($gblid){
		$gbl = GroupBookingList::findFirst($gblid);
		if ($gbl){
			if ($gbl->status == 'S2'){
				$gb = $gbl->GroupBooking;
				
				$jgbm = self::jgbMans($gblid);//获取参团人数
				if (($gb->mannum-1) == $jgbm){
					$gbl->status = 'S5';
					if ($gbl->save()) return 'S5';
					else return 'OPEFILE';
				}else return $gbl->status;
			}else return $gbl->status;
		}else return 'NEXIST';
	}
	
	
	
	//-------------
	// 团购退款
	//-------------
	public function gbRefunc($gblids=''){
		if ($gblids){
			//查询订单
			$orders = Order::find("order_type=3 and hd_id in ($gblids)");
			if ($orders){
				$wr = new WxRefund();
				foreach ($orders as $k=>$v){
					if ($v->status=='20' && $v->back=='0' && $v->type=='weixin'){//已付款
						//添加退款记录
						$rrResult = RefundRecord::addRefund(array(
								'order'=>$v->order_sn,'tamount'=>$v->price_h,'ramount'=>$v->price_h,
								'reason'=>'团购失败退款', 'vipid'=>$v->uid
						));
						
						$result = $wr->refund(array('totalFee'=>($v->total_fee)*100, 'refundFee'=>($v->total_fee)*100), $v->order_sn);
						if ($result['return_code']=='SUCCESS' && $result['result_code']=='SUCCESS'){
							//退款成功，修改退款状态
							$rrResult->status = 'S2';
							$rrResult->save();
							
							$v->back = '2'; $v->save();//修改订单状态
						}else {
							$rrResult->delete();
						}
					}
				}
			}
		}
	}
	
}