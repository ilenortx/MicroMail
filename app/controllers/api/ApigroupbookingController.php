<?php

/**
 * 团购api接口
 * @author xiao
 *
 */
class ApigroupbookingController extends ApiBase{

	public function gbOrderInfoAction(){
		if ($this->request->isPost()){
			$orderId = isset($_POST['orderId']) ? intval($_POST['orderId']) : 0;

			if (!$orderId){
				echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
				exit();
			}

			$order = Order::findFirstById($orderId);
			if ($order && count($orderId)){
				$order = $order->toArray();
				$order['paytime'] = date('Y-m-d H:i:s', $order['paytime']);

				$pro = OrderProduct::findFirstByOrderId($orderId);
				if ($pro && count($pro)){
					$order['proid'] = $pro->pid;
					$order['proname'] = $pro->name;
					$order['prophoto'] = $pro->photo_x;

					$ab = new ActivityBase();
					$gbmans = $ab->getGbMans($order['hd_id']);
					$gblInfo = $ab->gblInfo($order['hd_id']);
					$gbInfo = $ab->gbInfo($gblInfo['gb_id']);

					echo json_encode(array('status'=>1, 'oinfo'=>$order, 'gblinfo'=>$gblInfo, 'gbinfo'=>$gbInfo, 'gbmans'=>$gbmans));
				}else echo json_encode(array('status'=>0, 'msg'=>'数据异常'));
			}else echo json_encode(array('status'=>0, 'msg'=>'数据异常'));
		}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
	}

	/**
	 * 参团信息
	 */
	public function joinGbInfoAction(){
		if ($this->request->isPost()){
			$gblid = isset($_POST['gblid']) ? intval($_POST['gblid']) : 0;
			$uid = isset($_POST['uid']) ? intval($_POST['uid']) : 0;

			if (!$gblid || !$uid){
				echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
				exit();
			}

			$gbl = GroupBookingList::findFirstById($gblid);
			if ($gbl){
				$pro = $gbl->Product;

				$ab = new ActivityBase();
				$gbmans = $ab->getGbMans($gblid);
				$gblInfo = $ab->gblInfo($gblid);
				$gblInfo['isjoin'] = 0;
				$gbInfo = $ab->gbInfo($gblInfo['gb_id']);
				foreach ($gbmans as $k=>$v){
					if ($v['uid'] == $uid){ $gblInfo['isjoin'] = 1; break; }
				}

				//获取商品所有属性
				$sb = new SkuBase();
				$proAttr = $sb->getProAttrs($pro->id);

				echo json_encode(array('status'=>1, 'gblinfo'=>$gblInfo, 'gbinfo'=>$gbInfo, 'proinfo'=>$pro->toArray(), 'gbmans'=>$gbmans, 'proAttr'=>$proAttr));
			}else echo json_encode(array('status'=>0, 'msg'=>'数据异常'));
		}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
	}

	/**
	 * 获取个人参团列表
	 */
	public function joinGbListAction(){
		if ($this->request->isPost()){
			$uid = isset($_POST['uid']) ? intval($_POST['uid']) : 0;
			$type = isset($_POST['type']) ? intval($_POST['type']) : 1;//1组团 2参团
    		$page = isset($_POST['page']) ? intval($_POST['page']) : 0;

			if(!$uid || !$type){
				echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
				exit();
			}

			$gblist = GroupBookingMans::find(array(
					'conditions'=> "uid=?1 and type=?2",
					'bind'		=> array(1=>$uid, 2=>$type),
					'order'		=> "id desc",
					'limit'		=> array('number'=>10, 'offset'=>$page*10)
			));

			$gbArr = array();
			if ($gblist && count($gblist)){
				foreach ($gblist as $k=>$v){
					$gbl = $v->GroupBookingList;
					$pro = $gbl->Product;
					$gb = $gbl->GroupBooking;
					array_push($gbArr, array(
							'gblid'=>$gbl->id, 'gblstatus'=>$gbl->status, 'proid'=>$gbl->pro_id,
							'proname'=>$pro->name, 'prophoto'=>$pro->photo_x, 'gbprice'=>$gb->gbprice,
							'gbmans'=>$gb->mannum, 'orderId'=>$v->order_id
					));
				}
			}

			echo json_encode(array('status'=>1, 'gblist'=>$gbArr));
		}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
	}

	/**
	 * 获取一级分类
	 */
	public function categorysAction(){
		$cs = Category::find(array('conditions'=>'tid=?1 and status=?2', 'bind'=>array(1=>1, 2=>'S1'), 'order'=>"sort desc"));
		$shopId = (isset($_POST['shop_id'])&&intval($_POST['shop_id'])) ? intval($_POST['shop_id']) : 'all';
		if ($cs){
			$csArr = array();
			$cs = $cs->toArray();

			$pros = array();
			if (count($cs)){
				$product = new ProductController();
				$pros = $product->getOCProsAction($cs[0]['id'], $shopId, '2');
			}

			echo json_encode(array('status'=>1, 'cglist'=>$cs, 'prolist'=>$pros));
		}else echo json_encode(array('status'=>0, 'msg'=>'暂无数据!'));
	}


	/**
	 * 一级选项点击获取商品列表
	 */
	public function getpcgProListAction(){
		if ($this->request->isPost()){
			if (isset($_POST['pcid']) && intval($_POST['pcid'])){
				$pcid = $this->request->getPost('pcid');
				$shopId = (isset($_POST['shop_id'])&&intval($_POST['shop_id'])) ? intval($_POST['shop_id']) : 'all';
				$offset = (isset($_POST['offset'])&&intval($_POST['offset'])) ? intval($_POST['offset']) : 0;

				$product = new ProductController();
				$pros = $product->getOCProsAction($pcid, $shopId, '2', $offset);

				echo json_encode(array('status'=>1, 'prolist'=>$pros));
			}else echo json_encode(array('status'=>0, 'msg'=>'参数错误'));
		}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
	}


}

