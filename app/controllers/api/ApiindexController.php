<?php

/**
 * 首页数据接口
 * @author xiao
 *
 */
class ApiindexController extends ApiBase{
	
	/**
	 * 广告和公告
	 */
	public function guangaoAction(){
		//轮播图
		$gg = Guanggao::find();
		$adsArr = array(); $noticeArr = array();
		if ($gg) $adsArr= $gg->toArray();
		
		//加载首页顶部公告
		$notice = Notice::find("status='S1' and position=1");
		if ($notice) $noticeArr = $notice->toArray();
		//加载首页广告设置
		$nc = NoticeConfig::findFirst();
		$ncArr = array('bgcolor'=>'red', 'color'=>'#fff', 'speed'=>'2', 'direction'=>'1');
		if ($nc && count($nc->toArray())){
			$ncArr = $nc->toArray();
		}
		
		echo json_encode(array('status'=>1, 'ads'=>$adsArr, 'notice'=>$noticeArr, 'nchead'=>$ncArr));
	}
	private function loadGuangao(){
		//轮播图
		$gg = Guanggao::find();
		$adsArr = array(); $noticeArr = array();
		if ($gg) $adsArr= $gg->toArray();
		
		//加载首页顶部公告
		$notice = Notice::find("status='S1' and position=1");
		if ($notice) $noticeArr = $notice->toArray();
		//加载首页广告设置
		$nc = NoticeConfig::findFirst();
		$ncArr = array('bgcolor'=>'red', 'color'=>'#fff', 'speed'=>'2', 'direction'=>'1');
		if ($nc && count($nc->toArray())){
			$ncArr = $nc->toArray();
		}
		
		return array($adsArr, $noticeArr, $ncArr);//0轮播广告 2通知 3通知样式
	}
	
    public function indexAction(){
    	$shopId = isset($_POST['shop_id']) ? intval($_POST['shop_id']) : 'all';
    	//获取所有分类
		$category = new CategoryController();
		$cglist = $category->getcategorysTjAction();
		
		//分类子id
		$ccgids = array();
		foreach ($cglist as $k1=>$v1){
			foreach ($v1['child'] as $k2=>$v2){
				/* if (!isset($ccgids[$k1])) $ccgids[$k1] = array();
				array_push($ccgids[$k1], $k2); */
				$ccgids[$k2] = $v1;
			}
		}
    	
		//查询商品
    	$glists = Product::find(array(
    			'conditions'	=>	"del=?1 and pro_type=?2 and is_down=?3 and type=?4 and hd_type not in ('1','2')",
    			'bind'			=>	array(1=>0, 2=>1, 3=>0, 4=>1),
    			'order'			=>	"sort desc"
    	));
    	
    	$result = array();//返回结果
    	if ($glists){
    		$glists = $glists->toArray();
    		for ($i=0; $i<count($glists); ++$i){
    			if (isset($ccgids[$glists[$i]['cid']]['id'])){
    				if (!isset($result[$ccgids[$glists[$i]['cid']]['id']])) {
    					$result[$ccgids[$glists[$i]['cid']]['id']] = array(
    							'id'		=> $ccgids[$glists[$i]['cid']]['id'],
    							'container'	=> $ccgids[$glists[$i]['cid']]['name'],
    							'cgicon'	=> $ccgids[$glists[$i]['cid']]['bz_1'],
    							'sort'		=> $ccgids[$glists[$i]['cid']]['sort'],
    							'goods_list'=> array()
    					);
    				}
    				
    				$rl = $result[$ccgids[$glists[$i]['cid']]['id']];
    				
    				if (count($rl['goods_list']) < 6){
    					array_push($rl['goods_list'], array(
    							'id'		=> $glists[$i]['id'],
    							'name'		=> $glists[$i]['name'],
    							'img'		=> $glists[$i]['photo_x'],
    							'price'		=> $glists[$i]['price'],
    							'price_yh'	=> $glists[$i]['price_yh']
    					));
    				}
    				$result[$ccgids[$glists[$i]['cid']]['id']] = $rl;
    			}
    		}
    		
    		$result = $this->arraySort($result, 'sort');
    	}
    	
    	$ab = new ActivityBase();
    	//$gbpArr = $ab->allGroupBooking(4);//团购列表
    	//$skArr = $ab->allPromotion($shopId, 4);//秒杀列表
    	
    	$results['prolist'] = array();
    	foreach ($result as $k){
    		array_push($results['prolist'], $k);
    	}
    	
    	//广告
    	$advs = $this->loadGuangao();
    	//获取活动专区
    	$sid = $shopId=='all' ? 1 : intval($shopId);
    	$aac = new AaconfController();
    	$aaci = $aac->aaconfInfo($sid);
    	
    	//获取分类列表
    	$syflList = self::syflList($sid);
    	
    	echo json_encode(array('status'=>1, 'pros'=>$results, 'aaci'=>$aaci, 'syflList'=>$syflList, /* 'gbps'=>$gbpArr, 'sks'=>$skArr, */ 'ads'=>$advs[0], 'notice'=>$advs[1], 'nchead'=>$advs[2]), true);
    }
    
    /**
     * 获取所有分类类别
     */
    private function syflList($sid){
    	$flArr = array();
    	//热卖推荐
    	$hst = SyHotsellTj::findFirstByShopId($sid);
    	if ($hst && count($hst)){
    		$hst = $hst->toArray();
    		$hst['name'] = '热销推荐';
    		$hst['ctype'] = 'hst';
    		$hst['postatus'] = 1;
    		array_push($flArr, $hst);
    	}
    	
    	//获取所有分类
    	$cgs = Category::find("status='S1' and bz_2='1' order by sort desc");
    	$cgArr = array();
    	
    	if ($cgs){
    		$i = 0;
    		foreach ($cgs as $k=>$v){
    			if ($v->tid==1 && !isset($cgArr[$v->id])){
    				$cgArr[$v->id] = $v->toArray();
    				$cgArr[$v->id]['ctype'] = 'cg';
    				$cgArr[$v->id]['childs'] = array();
    				if ((!$flArr|| !count($flArr)) && $i==0) $cgArr[$v->id]['postatus'] = 1;
    				else $cgArr[$v->id]['postatus'] = 0;
    				
    				++$i;
    			}
    		}
    		foreach ($cgs as $k=>$v){
    			if ($v->tid>1 && isset($cgArr[$v->tid])){
    				array_push($cgArr[$v->tid]['childs'], $v->toArray());
    			}
    		}
    	}
    	
    	foreach ($cgArr as $k){
    		array_push($flArr, $k);
    	}
    	
    	return $flArr;
    }
    
    /**
     * 获取一级分类更多
     */
    public function promoreAction(){
    	if ($this->request->isPost()){
    		if (isset($_POST['cid']) && !empty(intval($_POST['cid']))){
    			$cid = $this->request->getPost('cid');
    			$offset = (isset($_POST['offset'])&&!empty(intval($_POST['offset']))) ? intval($_POST['offset']) : 0;
    			$px = (isset($_POST['px'])&&!empty(intval($_POST['px']))) ? intval($_POST['px']) : 0;
    			
    			$proArr = array();	//返回产品数组
    			//获取cid的子级
    			$category = new CategoryController();
    			$list = $category->ccategoryListAction($cid);
    			if (count($list)){
    				$cstr = '';
    				foreach ($list as $k=>$v){
    					if (end($list) == $v) $cstr .= $v['id'];
    					else $cstr .= $v['id'].',';
    				}
    				
    				$query = array(
    						'conditions'	=> "cid in({$cstr}) and del=?1 and is_down=?2",
    						'bind'			=> array(1=>'0', 2=>'0'),
    						'limit'			=> array("number"=>12, "offset"=>$offset*12)
    				);
    				
    				if ($px == 1) $query['order'] = 'addtime desc';
    				else if ($px == 2) $query['order'] = 'price_yh asc';
    				else if ($px == 3) $query['order'] = 'price_yh desc';
    				else if ($px == 4) $query['order'] = 'shiyong desc';
    				$pros = Product::find($query);
    				
    				if ($pros) $proArr = $pros->toArray();
    			}
    			echo json_encode(array('status'=>1, 'prolist'=>$pros));
    		}else echo json_encode(array('status'=>0, 'msg'=>'参数错误'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }
    
    public function getListAction(){
    	//'del=0 AND pro_type=1 AND is_down=0 AND type=1'
    }
    
    /**
     * 店铺产品
     */
    public function shopProsAction(){
    	if ($this->request->isPost()){
    		$shopId = isset($_POST['shop_id']) ? intval($_POST['shop_id']) : '';
    		//$gdbbOffset = isset($_POST['gdbb_offset']) ? intval($_POST['gdbb_offset']) : 0;
    		if (!$shopId) {
    			echo json_encode(array('status'=>0, 'err'=>'参数错误错误'));
    			exit();
    		}
    		
    		//查询商品
    		$pros = Product::find(array(
    				'conditions'=> "del=?1 and is_down=?2 and shop_id=?3",
    				'bind'		=> array(1=>0, 2=>0, 3=>$shopId),
    				'order'		=> "addtime desc"
    		));
    		
    		$prosXl = Product::find(array(
    				'conditions'=> "del=?1 and is_down=?2 and shop_id=?3",
    				'bind'		=> array(1=>0, 2=>0, 3=>$shopId),
    				'order'		=> "shiyong desc",
    				'limit'		=> 3
    		));
    		
    		//收藏
    		$sc = ProductSc::find(array(
    				'conditions'=> "shop_id=$shopId and status='1'",
    				'group'		=> "pid",
    				'limit'		=> 3,
    				'columns'	=> "count(id) as num, pid"
    		));
    		if ($sc && count($sc->toArray())) {
    			$pids = "";
    			foreach ($sc as $k=>$v){
    				$pids .= $v->pid.',';
    			}
    			
    			$prosSc = Product::find(array(
    					'conditions'=> "del=?1 and is_down=?2 and shop_id=?3 and id in(?4)",
    					'bind'		=> array(1=>0, 2=>0, 3=>$shopId, 4=>trim($pids, ',')),
    					'order'		=> "shiyong desc",
    					'limit'		=> 3
    			));
    		}else $prosSc = $prosXl;
    		
    		
    		$prosArr = array('xlph'=>array(), 'scph'=>array(),'cnxh'=>array(), 'gdbb'=>array());
    		
    		foreach ($pros as $k=>$v){
    			//添加猜你喜欢
    			if ($v->stype == 1){
    				array_push($prosArr['cnxh'], array(
    						'id'		=> $v->id,
    						'name'		=> $v->name,
    						'img'		=> $v->photo_x,
    						'price'		=> $v->price,
    						'price_yh'	=> $v->price_yh
    				));
    			}else if ($v->stype==0 && count($prosArr['gdbb'])<20){
    				array_push($prosArr['gdbb'], array(
    						'id'		=> $v->id,
    						'name'		=> $v->name,
    						'img'		=> $v->photo_x,
    						'price'		=> $v->price,
    						'price_yh'	=> $v->price_yh
    				));
    			}
    		}
    		
    		if ($prosXl) { //销量排行
    			foreach ($prosXl as $k=>$v){
    				array_push($prosArr['xlph'], array(
    						'id'		=> $v->id,
    						'name'		=> $v->name,
    						'img'		=> $v->photo_x,
    						'price'		=> $v->price,
    						'price_yh'	=> $v->price_yh
    				));
    			}
    		}
    		if ($prosSc) { //收藏排行
    			foreach ($prosSc as $k=>$v){
    				array_push($prosArr['scph'], array(
    						'id'		=> $v->id,
    						'name'		=> $v->name,
    						'img'		=> $v->photo_x,
    						'price'		=> $v->price,
    						'price_yh'	=> $v->price_yh
    				));
    			}
    		}
    		
    		//广告
    		$advs = $this->loadGuangao();
    		//获取活动专区
    		$sid = intval($shopId);
    		$aac = new AaconfController();
    		$aaci = $aac->aaconfInfo($sid);
    		
    		//获取分类列表
    		$syflList = self::syflList($sid);
    		
    		//echo json_encode(array('status'=>1, 'pros'=>$prosArr));
    		echo json_encode(array('status'=>1, 'pros'=>$prosArr, 'aaci'=>$aaci, 'syflList'=>$syflList, 'ads'=>$advs[0], 'notice'=>$advs[1], 'nchead'=>$advs[2]));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误!'));
    }
    
    /**
     * 更多店铺宝贝
     */
    public function shopMoreProsAction(){
    	if ($this->request->isPost()){
    		$shopId = isset($_POST['shop_id']) ? intval($_POST['shop_id']) : '';
    		$gdbbOffset = isset($_POST['gdbb_offset']) ? intval($_POST['gdbb_offset']) : 0;
    		if (!$shopId) {
    			echo json_encode(array('status'=>0, 'err'=>'参数错误错误'));
    			exit();
    		}
    		
    		//查询商品
    		$pros = Product::find(array(
    				'conditions'=> "del=?1 and is_down=?2 and shop_id=?3 and type=?4",
    				'bind'		=> array(1=>0, 2=>0, 3=>$shopId, 4=>0),
    				'order'		=> "addtime desc",
    				'limit'		=> array("number"=>20, 'offset'=>$gdbbOffset*20)
    		));
    		
    		$prosArr = array('gdbb'=>array());
    		
    		foreach ($pros as $k=>$v){
    			array_push($prosArr['gdbb'], array(
    					'id'		=> $v->id,
    					'name'		=> $v->name,
    					'img'		=> $v->photo_x,
    					'price'		=> $v->price,
    					'price_yh'	=> $v->price_yh
    			));
    		}
    		
    		echo json_encode(array('status'=>1, 'pros'=>$prosArr));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误!'));
    }

}

