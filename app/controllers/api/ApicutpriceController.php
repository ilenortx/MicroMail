<?php

/**
 * 砍价活动接口
 * @author xiao
 *
 */
class ApicutpriceController extends ApiBase{

    public function indexAction() {

    }
    
    /**
     * 获取个人砍价记录
     */
    public function cpListAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    		$page = isset($_POST['page']) ? intval($_POST['page']) : 0;
    		$type = isset($_POST['type']) ? $_POST['type'] : 'T1'; //T1全部 T2进行中 T3已结束
    		
    		if (!$uid){
    			echo json_encode(array('status'=>0, 'err'=>'登陆异常!'));
    			exit();
    		}
    		
    		$status = $type=='T1'?"status!='S0'":($type=='T2'?"status='S1'":"status='S2'");
    		$ucp = CutPriceSpritesList::find(array(
    				'conditions'=> "uid=$uid and $status order by addtime desc",
    				'limit'		=> array('number'=>10, 'offset'=>$page*10)
    		));
    		
    		$ucpArr = array();
    		if ($ucp) {
    			$time = time();
    			foreach ($ucp as $k=>$v){
    				$cp = CutPriceSprites::findFirstById($v->cp_id);
    				
    				if ($cp && $cp->stime<$time){
    					if ($v->status!='S2' && $type!='T3'){
    						$ab = new ActivityBase();//活动判断
    						$as = $ab->verifyAIV($v->cp_id, '3');
    						if ($as == 'S3') { $v->status = 'S2'; $v->cp_result = '2'; $v->save(); }
    					}
    					
    					$pro = Product::findFirstById($v->pro_id);
    					if ($pro){
    						if ($v->status=='S3' && $pro->hd_type=='3'){//活动过期
    							$pro->hd_id = 0; $pro->hd_type = '0'; $pro->save();
    						}
    						
    						$nowPrice = round($pro->price_yh-($pro->price_yh-$cp->low_price)/$cp->friends*$v->cpnum,2);
    						$progress = $v->cpnum>0?$v->cpnum/$cp->friends*100:0;
    						array_push($ucpArr, array(
    							'cpInfo'	=> array(
    								'id'=>$v->id,'stime'=>$cp->stime,'etime'=>$cp->etime,
    								'friends'=>$cp->friends,'shop_id'=>$v->shop_id,
    								'low_price'=>$cp->low_price,'pro_id'=>$v->pro_id,'cpnum'=>$v->cpnum,
    								'now_price'=>$nowPrice,'progress'=>$progress,'cp_result'=>$v->cp_result,
    								'skuid'=>$v->skuid
    							),
    							'proInfo'	=> $pro->toArray(),
    						));
    					}
    				}
    			}
    		}
    		
    		echo json_encode(array('status'=>1, 'ucps'=>$ucpArr));
    	}
    }

    /**
     * 获取砍价详情
     */
    public function cpDetailAction(){
    	if ($this->request->isPost()){
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    		$ucpId = isset($_POST['ucpId']) ? intval($_POST['ucpId']) : '';
    		
    		if (!$uid || !$ucpId){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误'));
    			exit();
    		}
    		
    		$ucp = CutPriceSpritesList::findFirstById($ucpId);
    		if ($ucp){
    			$ab = new ActivityBase();//活动判断
    			$as = $ab->verifyAIV($ucp->cp_id, '3');
    			if ($as == 'S3') { $ucp->status='S2'; $ucp->cp_result='2';}
    			
    			$buyer = User::findFirstById($ucp->uid);//购买者信息
    			$pro = Product::findFirstById($ucp->pro_id);//产品信息
    			$cp = CutPriceSprites::findFirstById($ucp->cp_id);
    			$cpf = CutPriceSpritesFriends::find("cp_id={$ucp->id}");
    			if ($buyer && $pro && $cp && $cpf){
    				$cpResult= 1;
    				if ($ucp->uid==$uid) $dotype = 1;//1自己的砍价 2帮别人砍价
    				else $dotype= 2;
    				
    				echo json_encode(array('status'=>1,'buyer'=>$buyer->toArray(),
    						'pro'=>$pro->toArray(),'ucp'=>$ucp->toArray(),'cp'=>$cp->toArray(),
    						'cpr'=>$cpResult,'cpf'=>$cpf->toArray(),'dotype'=>$dotype));
    			}else echo json_encode(array('status'=>0, 'err'=>'数据异常'));
    		}else echo json_encode(array('status'=>0, 'err'=>'数据异常'));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误'));
    }
    
    /**
     * 好友砍价列表
     */
    public function cpfriendsAction(){
    	if ($this->request->isPost()){
    		$ucpId= isset($_POST['ucpId']) ? intval($_POST['ucpId']) : 0;
    		
    		if (!$ucpId){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误'));
    			exit();
    		}
    		
    		$cpf = CutPriceSpritesFriends::find("cp_id={$ucpId}");
    		
    		echo json_encode(array('status'=>1,'cpf'=>$cpf->toArray()));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误'));
    	
    }

    /**
     * 添加砍价
     */
    public function addCutPriceAction(){
    	if ($this->request->isPost()){
    		$hdId = isset($_POST['hdId']) ? intval($_POST['hdId']) : '';
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    		$proId = isset($_POST['proId']) ? intval($_POST['proId']) : '';
    		$skuid = isset($_POST['skuid']) ? trim($_POST['skuid'], ',') : '';
    		
    		if (!$hdId || !$uid || !$proId){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误'));
    			exit();
    		}
    		
    		$cp = CutPriceSprites::findFirstById($hdId);
    		if ($cp && count($cp)){
    			$ab = new ActivityBase();//活动验证
    			$as = $ab->verifyAIV($hdId, '3');
    			if ($as == 'S0'){
    				echo json_encode(array('status'=>0, 'err'=>'活动结束')); exit();
    			}else if ($as == 'S1'){
    				echo json_encode(array('status'=>0, 'err'=>'活动未开始')); exit();
    			}else if ($as == 'S3'){
    				echo json_encode(array('status'=>0, 'err'=>'活动结束')); exit();
    			}
    			
    			$ucp = CutPriceSpritesList::findFirst(array(
    					"conditions"=> 'cp_id=?1 and uid=?2 and pro_id=?3 and cp_result!=?4',
    					'bind'		=> array(1=>$hdId, 2=>$uid, 3=>$proId, 4=>'3')
    			));
    			if ($ucp && count($ucp)){//已经存在
    				echo json_encode(array('status'=>1, 'ucpId'=>$ucp->id, 'addtype'=>'old'));
    			}else {
    				$ucp = new CutPriceSpritesList();
    				$ucp->cp_id = $hdId;
    				$ucp->shop_id = $cp->shop_id;
    				$ucp->pro_id = $proId;
    				$ucp->uid = $uid;
    				$ucp->cpnum = 1;
    				$ucp->addtime = time();
    				$ucp->status = 'S1';
    				$ucp->cp_result = '1';
    				$ucp->skuid = $skuid;
    				if ($ucp->save()){
    					$user = User::findFirstById($uid);
    					if ($user && count($user)){
    						$cpf = new CutPriceSpritesFriends();
    						$cpf->cp_id = $ucp->id;
    						$cpf->openid = $user->openid;
    						$cpf->fname = $user->uname;
    						$cpf->avatar = $user->photo;
    						$cpf->time = date('Y-m-d H:i:s');
    						$cpf->save();
    					}
    					
    					echo json_encode(array('status'=>1, 'ucpId'=>$ucp->id, 'addtype'=>'new'));
    				}else echo json_encode(array('status'=>0, 'ucpId'=>'砍价失败'));
    			}
    		}else echo json_encode(array('status'=>0, 'ucpId'=>'活动不存在'));
    	}else echo json_encode(array('status'=>0, 'ucpId'=>'请求方式错误'));
    }
    
    /**
     * 帮好友砍价
     */
    public function helpCutPriceAction(){
    	if ($this->request->isPost()){
    		$openid = isset($_POST['openid']) ? $_POST['openid'] : '';
    		$ucpId = isset($_POST['ucpId']) ? intval($_POST['ucpId']) : '';
    		
    		if (!$openid || !$ucpId){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误'));
    			exit();
    		}
    		
    		$ucp = CutPriceSpritesList::findFirstById($ucpId);
    		if ($ucp){
    			$ab = new ActivityBase();//活动判断
    			$as = $ab->verifyAIV($ucp->cp_id, '3');
    			if ($as == 'S3') { $ucp->status='S2'; $ucp->cp_result='2';}
    			
    			$helper = User::findFirstById($ucp->uid);//购买者信息
    			$cp = CutPriceSprites::findFirstById($ucp->cp_id);
    			if ($cp){
    				$fcp = CutPriceSpritesFriends::find();
    				$cpnum = 0;
    				if ($fcp){
    					foreach ($fcp as $k=>$v){
    						if ($v->openid == $openid){
    							echo json_encode(array('status'=>0, 'err'=>'已帮Ta砍价过'));
    							exit();
    						}
    					}
    					$cpnum = count($fcp->toArray());
    				}
    				
    				if ($cp->friends == $cpnum){
    					$ucp->status = 'S2'; $ucp->cp_result = '3'; $ucp->save();
    					echo json_encode(array('status'=>0, 'err'=>'已完成砍价'));
    					exit();
    				}
    					
    				$user = User::findFirstByOpenid($openid);
    				if ($user && count($user)){
    					$fcp = new CutPriceSpritesFriends();
    					$fcp->cp_id = $ucpId;
    					$fcp->openid = $openid;
    					$fcp->fname = $user->uname;
    					$fcp->avatar = $user->photo;
    					$fcp->time = date('Y-m-d H:i:s', time());
    					
    					$ucp = CutPriceSpritesList::findFirstById($ucpId);
    					$ucp->cpnum = $ucp->cpnum+1;
    					if ($cp->friends == $ucp->cpnum){
    						$ucp->status = 'S2'; $ucp->cp_result = '3'; $ucp->save();
    					}
    					
    					if ($fcp->save() && $ucp->save()) echo json_encode(array('status'=>1));
    					else echo json_encode(array('status'=>0, 'err'=>'砍价失败'));
    				}else echo json_encode(array('status'=>0, 'err'=>'用户不存在'));
    			}else echo json_encode(array('status'=>0, 'err'=>'数据异常'));
    		}else echo json_encode(array('status'=>0, 'err'=>'数据异常'));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误'));
    }
    
    //获取access_token
    public function getAccessToken(){
    	$wxConfig= IniFileOpe::getIniFile( WECHAT.'/config.ini', $this->esbEcode().'-xcx');
    	$appid = $wxConfig['appid'];
    	$secret = $wxConfig['secret'];
    	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
    	return $data = $this->curlGet($url);
    }
    
    public function curlGet($url) {
    	$curl = curl_init();
    	curl_setopt($curl, CURLOPT_URL, $url);
    	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    	$data = curl_exec($curl);
    	$err = curl_error($curl);
    	curl_close($curl);
    	return $data;
    }
    //获得二维码
    public function getQrcodeAction() {
    	header('content-type:image/jpg');
    	$uid = 4;
    	$data = array();
    	$data['scene'] = "uid=" . $uid;
    	$data['page'] = "pages/index/index";
    	$data = json_encode($data);
    	$access = json_decode($this->getAccessToken(),true);
    	$access_token= $access['access_token'];
    	$url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $access_token;
    	$da = $this->getHttpArray($url,$data);
    	
    	echo json_encode(array('status'=>1, 'code'=>$da));
    }
    public function getHttpArray($url,$post_data) {
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   //没有这个会自动输出，不用print_r();也会在后面多个1
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    	$output = curl_exec($ch);
    	curl_close($ch);
    	$out = json_decode($output);
    	return $out;
    }
    
    
    /*-------------
     * 更多砍价
     */
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
    			$pros = $product->getOCProsAction($cs[0]['id'], $shopId, '3');
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
    			$pros = $product->getOCProsAction($pcid, $shopId, '3', $offset);
    			
    			echo json_encode(array('status'=>1, 'prolist'=>$pros));
    		}else echo json_encode(array('status'=>0, 'msg'=>'参数错误'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }
    
    
}

