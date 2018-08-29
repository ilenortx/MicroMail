<?php

use Phalcon\Mvc\Router\Group;

class ActivityBase extends ControllerBase{
	
	/**
	 * 验证活动是否有效(单个验证)
	 */
	public function verifyAIV($hdId, $hdType){
		$hdStatus = 'S0';
		if ($hdType == '1'){
			$ps = Promotion::findFirstById($hdId);
			if ($ps){
				if ($ps->stime>time() && $ps->status!='S1'){//未开始
					$ps->status = 'S1'; $ps->save();
				}else if ($ps->etime<time() || $ps->status=='S3'){//结束
					if ($ps->status!='S3'){$ps->status = 'S3'; $ps->save();}
					
					$pro = Product::find("hd_id=$hdId and hd_type='3'");//商品活动
					if ($pro){
						foreach ($pro as $k){
							$k->hd_id = 0; $k->hd_type = '0'; $k->save();
						}
					}
				}
				$hdStatus = $ps->status;
			}
		}else if ($hdType == '2'){
			$gb = GroupBooking::findFirstById($hdId);
			if ($gb){
				if ($gb->stime>time() && $gb->status!='S1'){//未开始
					$gb->status = 'S1'; $gb->save();
				}else if ($gb->etime<time() || $gb->status=='S3'){//结束
					if ($gb->status!='S3'){$gb->status = 'S3'; $gb->save();}
					
					$gbl = GroupBookingList::find("gb_id=$hdId and (status='S2' or status='S1')");
					if ($gbl){
						$gblids= '';
						foreach ($gbl as $k){
							$gblids.= $k->id.',';
							$k->status = 'S3'; $k->save();
						}
						$gblids = trim($gblids, ',');
						$this->gbRefunc($gblids);
					}
					//退款，修改
					
					$pro = Product::find("hd_id=$hdId and hd_type='3'");//商品活动
					if ($pro){
						foreach ($pro as $k){
							$k->hd_id = 0; $k->hd_type = '0'; $k->save();
						}
					}
				}
				
				$hdStatus = $gb->status;
			}
		}else if ($hdType == '3'){//砍价
			$cp = CutPriceSprites::findFirstById($hdId);
			if ($cp){
				if ($cp->stime>time() && $cp->status!='S1'){//未开始
					$cp->status = 'S1'; $cp->save();
				}else if ($cp->etime<time() || $cp->status=='S3'){//结束
					if ($cp->status!='S3'){$cp->status = 'S3'; $cp->save();}
					
					$ucp = CutPriceSpritesList::find("cp_id=$hdId");//用户砍价
					if ($ucp){
						foreach ($ucp as $k){
							if ($k->cp_result == '1'){
								$k->status = 'S2'; $k->cp_result = '2'; $k->save();
							}
						}
					}
					
					$pro = Product::find("hd_id=$hdId and hd_type='3'");//商品活动
					if ($pro){
						foreach ($pro as $k){
							$k->hd_id = 0; $k->hd_type = '0'; $k->save();
						}
					}
				}
				
				$hdStatus = $cp->status;
			}
		}
		
		return $hdStatus; //S0删除 S1未开始 S2进行中 S3结束
	}
	
	/**
	 * 验证团购是否有效
	 */
	public function verifyGBL($gblid){
		$gbl = GroupBookingList::findFirstById($gblid);
		if ($gbl && count($gbl)){
			if ($gbl->etime<time() && ($gbl->status=='S1'||$gbl->status=='S2')){
				$gbl->status = 'S4'; $gbl->save();
				return 'S4';
			}
			return $gbl->status;
		}else return 'S0';
	}
	
	/**
	 * 获取用户是否参与活动(参与未结束)
	 */
	public function userIJA($uid, $hdId, $hdtype='1'){
		$result = array();
		if ($hdtype=='1'){//抢购
			
		}else if ($hdtype=='2'){//团购
			$ugb = GroupBookingList::findFirst("uid=$uid and gb_id=$hdId and status in('S1','S2')");
			if (!$ugb|| !count($ugb->toArray())) $result = false;
			else $result = $ugb->toArray();
		}else if ($hdtype=='3'){//砍价
			$ucp = CutPriceSpritesList::findFirst("uid=$uid and cp_id=$hdId and status='S1' and cp_result='1'");
			if (!$ucp || !count($ucp->toArray())) $result = false;
			else $result = $ucp->toArray();
		}
		
		return $result;
	}
	
	/**
	 * 获取团购
	 */
	public function allGroupBooking($num=3, $limit=0){
		$gbpArr = array();
		$gbs = GroupBooking::find(array(
				'conditions'=> "status=?1",
				'bind'		=> array(1=>'S2'),
				'limit'		=> array('number'=>$num, 'limit'=>$limit),
				'order'		=> "stime desc"
		));
		if ($gbs){
			foreach ($gbs as $k=>$v){
				$pro = $v->Product;
				if ($pro && count($pro)){
					$gb = $v->toArray();
					$gb['proInfo'] = array(
							'id'=>$gb['id'],'name'=>$pro->name,'photo_x'=>$pro->photo_x,
							'price_yh'=>$pro->price_yh
					);
				}
				array_push($gbpArr, $gb);
			}
		}
		
		return $gbpArr;
	}
	
	/**
	 * 获取团购信息
	 */
	public function groupBooking($gbid){
		$gbiArr = array(); $gblArr = array();
		$gbi = GroupBooking::findFirstById($gbid);
		if ($gbi){
			$gbiArr = $gbi->toArray();
			$gbl = $gbi->GroupBookingList;
			foreach ($gbl as $k=>$v){
				if ($v->status == 'S2'){//判断拼团是否正在进行中
					$user = $v->User;
					if ($user && count($user)){
						$gblArr[$k] = $v->toArray();
						$gblArr[$k]['mannum'] = $gbiArr['mannum'];
						$gblArr[$k]['ungbnums'] = $gbiArr['mannum']-$v->mans;
						$gblArr[$k]['uname'] = $user->uname;
						$gblArr[$k]['uphoto'] = $user->photo;
					}
				}
			}
		}
		
		return array($gbiArr, $gblArr);
	}
	
	/**
	 * 团购信息
	 */
	public function gbInfo($gbid){
		$gbiArr = array();
		$gbi = GroupBooking::findFirstById($gbid);
		if ($gbi) {
			$gbiArr = $gbi->toArray();
			
			if ($gbiArr['status']!='S2'){
				$msg = $gbiArr['status']=='S1'?'成团中':($gbiArr['status']=='S3'?'活动结束':($gbiArr['status']=='S4'?'成团失败':'成团完成'));
				echo json_encode(array('status'=>0, 'msg'=>$msg)); exit();
			}
		}
		
		return $gbiArr;
	}
	public function gblInfo($gblid){
		$gbl = GroupBookingList::findFirstById($gblid);
		
		$gblArr = array();
		if ($gbl) $gblArr = $gbl->toArray();
		return $gblArr;
	}
	
	
	/**
	 * 新增团购
	 */
	public function addGb($gbid, $uid, $proId){
		$gbi = GroupBooking::findFirstById($gbid);
		if ($gbi && count($gbi)){
			$etime = (time()+($gbi->gbtime*3600))<$gbi->etime ? time()+($gbi->gbtime*3600) : $gbi->etime;
			$gbl = new GroupBookingList();
			$gbl->gb_id = $gbid;
			$gbl->pro_id = $proId;
			$gbl->uid = $uid;
			$gbl->stime = time();
			$gbl->etime = $etime;
			$gbl->mans = 0;
			$gbl->status = 'S1';
			
			$gbl->save();
			
			return $gbl->id;
		}else {
			echo json_encode(array('status'=>0, 'msg'=>'数据异常'));
			exit();
		}
		
	}
	
	/**
	 * 加入团购
	 */
	public function joinGb($oid, $gblId, $uid){
		$gbl = GroupBookingList::findFirstById($gblId);
		if ($gbl){
			$mans = $gbl->mans ? intval($gbl->mans) : 0;
			$gbl->mans = $mans+1;
			$gbl->save();//修改拼团人数
			
			$gbm = new GroupBookingMans();
			$gbm->order_id = $oid;
			$gbm->gb_id = $gbl->gb_id;
			$gbm->gbl_id = $gblId;
			$gbm->uid = $uid;
			$gbm->time = time();
			$gbm->type = $gbl->uid==$uid ? '1' : '2';
			$gbm->save();
			
			GroupBookingBase::gblIsSuccess($gblId);
		}
	}
	
	/**
	 * 修改拼团人数
	 */
	public function reGbMan($gblid=0){
		$gbl = GroupBookingList::findFirstById($gblid);
		
		if ($gbl){
			if ($gbl->status == 'S2'){
				$gbl->mans = $gbi->mans+1;
				$gbl->save();
				
				$gbi = GroupBooking::findFirstById($gbl->gb_id);
				$gbnum = intval($gbi->gbnum)?intval($gbi->gbnum):0;
				$gbi->gbnum = $gbnum+1;
				$gbi->save();
			}
		}
	}
	
	/**
	 * 活动订单生成成功
	 */
	public function hdOrderSuc($hdType=1, $hdId=0, $uid=0){
		if ($hdType==1){//促销
			
		}else if ($hdType==3){//团购
			$gbl = GroupBookingList::findFirstById($hdId);
			if ($gbl && count($gbl) && $gbl->uid==$uid){
				$gbl->status = 'S2'; $gbl->save();
			}
		}else if ($hdType==4){//砍价
			$cpl = CutPriceSpritesList::findFirstById($hdId);
			if ($cpl) { $cpl->cp_result = '4'; $cpl->save(); }
		}
	}
	
	/**
	 * 获取团购是否过期
	 */
	public function gblIsPd($gblid){
		$gbl = GroupBookingList::findFirstById($gblid);
		
		if ($gbl){
			if ($gbl->etime<time()){
				echo json_encode(array('status'=>0, '团购失败'));
				exit();
			}
			if ($gbl->status == 'S5'){
				echo json_encode(array('status'=>0, '团购成功'));
				exit();
			}
		}
	}
	
	/**
	 * 团购退款
	 */
	public function gbRefunc($gblids=''){
		if ($gblids){
			$orders = Order::find("order_type=3 and hd_id in ($gblids)");
			if ($orders){
				$wr = new WxRefund();
				foreach ($orders as $k=>$v){
					if ($v->status=='20' && $v->back!='2' && $v->type='weixin'){//已付款
						$wr->refund(array('totalFee'=>$v->price_h*100, 'refundFee'=>$v->price_h*100), $v->order);
					}
					$v->back = 2; $v->save();
				}
			}
		}
	}
	
	//----------
	//获取参团人员
	//----------
	public function getGbMans($gblid){
		//参团列表
		$mans = GroupBookingMans::find(array(
				'conditions'=> "gbl_id=?1",
				'bind'		=> array(1=>$gblid)
		));
		
		$gbmArr = array();
		if ($mans){
			foreach ($mans as $k=>$v){
				$user = $v->User;
				if ($user) array_push($gbmArr, array('uid'=>$user->id, 'uphoto'=>$user->photo, 'type'=>$v->type));
			}
		}
		
		return $gbmArr;
	}


	
	/**
	 * 获取今日秒杀
	 */
	public function allPromotion($shopId='all', $num=3, $limit=0){
		$pArr = array(); $time = time();
		$condition = array(
				'conditions'=> "status=?1 and stime<?2",
				'bind'		=> array(1=>'S2', 2=>$time),
				'limit'		=> array('number'=>$num, 'limit'=>$limit),
				'order'		=> "stime desc"
		);
		if ($shopId!='all' && intval($shopId)>0){
			$condition['conditions'] .= " adn shop_id=?3";
			$condition['bind'][3] = $shopId;
		}
		$ps = Promotion::find($condition);
		if ($ps){
			foreach ($ps as $k=>$v){
				$pro = $v->Product;
				if ($pro && count($pro)){
					$pi = $v->toArray();
					$pi['proInfo'] = array(
							'id'=>$pro->id,'name'=>$pro->name,'photo_x'=>$pro->photo_x,
							'price_yh'=>$pro->price_yh
					);
				}
				array_push($pArr, $pi);
			}
		}
		
		return $pArr;
	}
	
	/**
	 * 获取秒杀详情
	 */
	public function promotion($id=0){
		$pi = Promotion::findFirstById($id);
		$pArr = array();
		
		if ($pi) $pArr = $pi->toArray();
		
		return $pArr;
	}
	
	
	//----------
	//砍价
	//----------
	/**
	 * 获取砍价详情
	 */
	public function cutPriceDetail($id){
		
	}
	/**
	 * 获取店铺所有砍价
	 */
	public function cutPrices($sid='all', $status='S2'){
		$conditions = "";
		if ($sid != 'all'){ $conditions .= "shop_id=$sid"; }
		if ($status != 'all'){
			if (strlen($conditions)) $conditions .= " and status='$status'";
			else $conditions .= "status='$status'";
		}
		
		$cps = CutPriceSprites::find($conditions);
		$cpArr = array();
		if ($cps){
			foreach ($cps as $k=>$v){
				$cpArr[$v->id] = $v;
			}
		}
		
		
		return $cpArr;
	}
	
}