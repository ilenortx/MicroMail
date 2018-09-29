<?php

/**
 * 商品详情页接口
 * @author xiao
 *
 */
class ApiProductController extends ApiBase{

	/**
	 * 商品详情
	 */
    public function indexAction(){
		if ($this->request->isPost()){
			$proId = intval($this->request->getPost('pro_id'));
			$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
			if ($proId){
				//查询所有收藏
				$sclist = array(); $scpids = array();
				if ($uid){
					$scs = ProductSc::find(array(
							'conditions'=>'uid=?1 and status=?2',
							'bind'=>array(1=>$uid, 2=>1)
					));
					if ($scs) $sclist = $scs->toArray();

					foreach ($sclist as $k=>$v){
						array_push($scpids, $v['pid']);
					}
				}


				$pro = Product::findFirstById($proId);
				if ($pro){
					$pro = $pro->toArray(); $is_sc = 0;
					if ($pro['hd_type'] != '0'){
						$ab = new ActivityBase();
						$as = $ab->verifyAIV($pro['hd_id'], $pro['hd_type']);
						if ($as != 'S2') { $pro['hd_type']='0'; $pro['hd_id']=0; }//活动为未进行中
						$abresult = $ab->userIJA($uid, $pro['hd_id'], $pro['hd_type']);
						$pro['hstatus'] = ($abresult&&count($abresult)) ? ($abresult['status']=='S1'?1:2): 0;

						if ($pro['hd_type']=='2'){
							//$pro['gbInfo'] = $abresult;
							$gbInfo = $ab->groupBooking($pro['hd_id']);
							$pro['gbInfo'] = $gbInfo[0];
							$pro['gbList'] = $gbInfo[1];
							$pro['gbList2'] = count($gbInfo[1])>2? array_slice($gbInfo[1], 0, 2) : $gbInfo[1];
							$pro['hd_price'] = $gbInfo[0]['gbprice'];
						}else if ($pro['hd_type'] == '1'){
							$pinfo = $ab->promotion($pro['hd_id']);
							$pro['skinfo'] = $pinfo;
							$pro['hd_price'] = $pinfo['pprice'];
						}
					}

					if (in_array($pro['id'], $scpids)) $is_sc= 1;
					//图片轮播数组
					$img = explode(',', trim($pro['photo_string'], ','));$b=array();
					$pro['img_arr']=$img;//图片轮播数组

					//获取商品所有属性
					$sb = new SkuBase();
					$proAttr = $sb->getProAttrs($proId);

					//产品推荐
					if (intval($pro['procxid'])){
						$pro['procxid'] = (intval($pro['procxid'])>0) ? $pro['procxid'] : '';
						$pro['procx'] = self::proCx(intval($pro['procxid']));
					}else $pro['procxid'] = (intval($pro['procxid'])>0) ? $pro['procxid'] : '';

					//产品说明
					$sns = array();
					if (!empty($pro['snids'])){
						$psn = new ProductController();
						$sns = $psn->prosnList('pro', $pro['snids']);
					}

                    // 产品参数
                    $new_array = array();
                    $parm_data = Category::find("id={$pro['cid']}");
                    if($parm_data[0]->parm_id > 0){
                        $type_data = $parm_data[0]->ProductParm->toArray();
                        if ($type_data['disabled']==0 && $pro['parm']!='') {
                            $value_data = ProductParmValue::find("id in ({$type_data['vid']})")->toArray();
                            $value_data_keys = array_column($value_data, 'id');

                            $pro['parm'] = json_decode($pro['parm'], true);
                            foreach ($pro['parm'] as $key => $value) {
                                $search_key = array_search($key, $value_data_keys);
                                $append_data = array(
                                    'name'=>$value_data[$search_key]['name'],
                                    'value'=>$value,
                                    'option'=>json_decode($value_data[$search_key]['value'], true),
                                );
                                if($value_data[$search_key]['type']=='select' && isset($append_data['option'][$append_data['value']])){
                                    $append_data['value'] = $append_data['option'][$append_data['value']];
                                }

                                unset($append_data['option']);
                                array_push($new_array, $append_data);
                            }
                        }else{
                            $pro['parm'] = '';
                        }
                    }

					echo json_encode(array('status'=>1, 'pro'=>$pro, 'is_sc'=>$is_sc, 'porAttr'=>$proAttr, 'prosn'=>$sns, 'parm'=>$new_array));
				}else echo json_encode(array('status'=>0,'err'=>'商品不存在或已下架！'));
			}else echo json_encode(array('status'=>0,'err'=>'参数错误！'));
		}else echo json_encode(array('status'=>0,'err'=>'请求方式错误！'));
    }
    /**
     * 产品促销
     */
    private function proCx($cxid){
    	$procx = ProductCx::findFirstById($cxid);
    	$procxArr = array('cxid'=>'','name'=>'','photo'=>'');

    	if ($procx) {
    		$procxArr['cxid'] = intval($procx->id)>0 ? $procx->id : '';
    		$procxArr['name'] = $procx->name;
    		$procxArr['photo'] = $procx->photo;
    	}

    	return $procxArr;
    }

    //***************************
    //  会员商品收藏接口
    //***************************
    public function colAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    		$pid = isset($_POST['pid']) ? intval($_POST['pid']) : '';
    		if (!$uid || !$pid) {
    			echo json_encode(array('status'=>0,'err'=>'系统错误，请稍后再试.'));
    			exit();
    		}

    		//验证产品是否存在
    		$pro = Product::findFirst($pid);

    		if (!$pro){
    			echo json_encode(array('status'=>0,'err'=>'产品不存在'));
    			exit();
    		}

    		$check = ProductSc::findFirst(array(
    				'conditions'=> "uid=?1 and pid=?2",
    				'bind'		=> array(1=>$uid, 2=>$pid)
    		));
    		if ($check) {
    			$checks = $check->toArray();
    			if ($checks['status'] == 1) $res = $check->delete();
    			else {
    				$check->status = '1';
    				$res = $check->save();
    			}
    		}else{
    			$col = new ProductSc();
    			$col->uid = $uid;
    			$col->shop_id = $pro->shop_id;
    			$col->pid = $pid;
    			$col->status = 1;
    			$res = $col->save();
    		}

    		if ($res) {
    			echo json_encode(array('status'=>1));
    			exit();
    		}else{
    			echo json_encode(array('status'=>0,'err'=>'网络错误..'));
    			exit();
    		}
    	}else {
    		echo json_encode(array('status'=>0,'err'=>'请求方式错误.'));
    		exit();
    	}
    }

    /**
     * 获取收藏列表
     */
    public function getColListsAction(){
    	if ($this->request->isPost()){
    		$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    		$uid = isset($_POST['uid']) ? $_POST['uid'] : '';
    		if (!$uid){
    			echo json_encode(array('status'=>0,'err'=>'系统错误，请稍后再试.'));
    			exit();
    		}

    		$collist = array();
    		$cols = ProductSc::find(array(
    				'conditions'=>'uid=?1 and status=?2',
    				'bind'=>array(1=>$uid, 2=>1),
    				'limit'=>array('number' => 12, 'offset' => $offset*12)
    		));
    		if ($cols) $cols= $cols->toArray();
    		foreach ($cols as $k=>$v){
    			$pro = Product::findFirstById($v['pid']);
    			if ($pro) array_push($collist, $pro->toArray());
    		}
    		echo json_encode(array('status'=>1,'cols'=>$collist));
    	}else echo json_encode(array('status'=>0,'err'=>'请求方式错误！'));
    }

    /**
     * 通过sku获取商品信息
     */
    public function skuToProInfoAction(){
    	if ($this->request->isPost()){
    		$sku = isset($_POST['sku']) ? trim($_POST['sku'], ',') : '';
    		$pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;

    		if (!$sku || !$pid) {
    			echo json_encode(array('status'=>0,'err'=>'数据错误'));
    			exit();
    		}

    		$psku = ProductSku::find(array(
    				'conditions'=> "skuid=?1 and pid=?2",
    				'bind'		=> array(1=>$sku, 2=>$pid)
    		));

    		if ($psku && count($psku->toArray())){
    			$psku = $psku->toArray()[0];

    			echo json_encode(array('status'=>1, 'sku'=>array('price'=>$psku['price'], 'stock'=>$psku['stock'])));
    		}else echo json_encode(array('status'=>0,'err'=>'数据异常'));
    	}else echo json_encode(array('status'=>0,'err'=>'请求方式错误'));
    }

    /**
     * 加载产品促销
     */
    public function proCxListAction(){
    	if ($this->request->isPost()){
    		$cxid = isset($_POST['cxid']) ? intval($_POST['cxid']) : 0;
    		$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;

    		if (!$cxid) {
    			echo json_encode(array('status'=>0, 'err'=>'数据错误')); exit();
    		}

    		$procx = ProductCx::findFirstById($cxid);
    		if ($procx && count($procx) && $procx->proids){
    			$ids = trim($procx->proids, ',');
    			$pros = Product::find(array(
    					'conditions'=> "del=0 and is_down=0 and id in($ids)",
    					'columns'	=> "id, photo_tjx, photo_tj",
    					'limit'		=> array('number'=>100, 'offset'=>$offset*100)
    			));

    			if ($pros) echo json_encode(array('status'=>1, 'procx'=>$procx->toArray(), 'cxlist'=>$pros->toArray()));
    			else echo json_encode(array('status'=>0, 'err'=>'数据异常'));
    		}else echo json_encode(array('status'=>0, 'err'=>'数据异常'));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误'));
    }

    /**
     * 加载推荐产品
     */
    public function tjproListAction(){
    	if ($this->request->isPost()){
    		$proId = isset($_POST['pro_id']) ? intval($_POST['pro_id']) : 0;

    		if (!$proId){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误')); exit();
    		}
    		$pro = Product::findFirstById($proId);

    		if ($pro){
    			$tjpro = trim($pro->tjpro, ',');
    			$pros = Product::find(array(
    					'conditions'=> "del=0 and is_down=0 and id in($tjpro)",
    					'columns'	=> "id, photo_x, name, price_yh"
    			));

    			if ($pros) {
    				$proArr = array(); $tempArr = array();
    				$pros = $pros->toArray();
    				foreach ($pros as $k=>$v){
    					array_push($tempArr, $v);
    					if (count($tempArr)==6 || count($pros)==(count($proArr)*6+count($tempArr))){
    						array_push($proArr, $tempArr);
    						$tempArr = array();
    					}
    				}
    				echo json_encode(array('status'=>1, 'tjpros'=>$proArr));
    			}
    			else echo json_encode(array('status'=>0, 'err'=>'数据异常'));
    		}else echo json_encode(array('status'=>0, 'err'=>'数据异常'));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误'));
    }

    /**
     * 获取产品服务说明
     */
    public function prosnListAction(){
    	if ($this->request->isPost()){
    		$proId = isset($_POST['proid']) ? intval($_POST['proid']) : 0;

    		if (!$proId){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误')); exit();
    		}
    		$pro = Product::findFirstById($proId);

    		if ($pro){
    			$snids = trim($pro->snids, ',');
    			if ($snids){
    				$psn = new ProductController();
    				$sns = $psn->prosnList('pro', $snids);
    				echo json_encode(array('status'=>1, 'prosns'=>$sns));
    			}else echo json_encode(array('status'=>0, 'prosns'=>array()));
    		}else echo json_encode(array('status'=>0, 'err'=>'数据异常'));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误'));
    }


}

