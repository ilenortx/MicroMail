<?php

/**
 * 拼团
 * @author xiao
 *
 */
class GroupbookingController extends AdminBase{

	public function indexAction(){
		$this->assets
			 ->addCss("css/static/h-ui/H-ui.min.css")
			 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
			 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
			 ->addCss("css/static/h-ui.admin/style.css")
			 ->addCss("css/custom/marketing/public.css")
			 ->addCss("css/custom/marketing/groupBooking.css")
			 ->addJs("lib/jquery/1.9.1/jquery.min.js")
			 ->addJs("lib/layer/layer.js")
			 ->addJs("js/static/h-ui/H-ui.min.js")
			 ->addJs("js/static/h-ui.admin/H-ui.admin.js")
			 ->addJs("lib/My97DatePicker/4.8/WdatePicker.js")
			 ->addJs("lib/datatables/1.10.0/jquery.dataTables.min.js")
			 ->addJs("lib/laypage/1.2/laypage.js");
		
		
		
		$this->view->pick("admin/groupBooking/index");
	}
	
	public function gbeditPageAction(){
		$this->assets
			 ->addCss("css/static/h-ui/H-ui.min.css")
			 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
			 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
			 ->addCss("css/static/h-ui.admin/style.css")
			 ->addJs("lib/jquery/1.9.1/jquery.min.js")
			 ->addJs("lib/layer/layer.js")
			 ->addJs("js/static/h-ui/H-ui.min.js")
			 ->addJs("js/static/h-ui.admin/H-ui.admin.js")
			 ->addJs("lib/My97DatePicker/4.8/WdatePicker.js")
			 ->addJs("lib/datatables/1.10.0/jquery.dataTables.min.js")
			 ->addJs("lib/laypage/1.2/laypage.js");
		
		$gbId = isset($_GET['gbId']) ? intval($_GET['gbId']) : '';
		$type = isset($_GET['type']) ? $_GET['type'] : 'add';
		
		$gbInfo = array(
				'gbname'=>'','pid'=>'','stime'=>'','etime'=>'','mannum'=>''
				,'gbtime'=>'','gbnum'=>'','status'=>'','gbprice'=>'','addtime'=>''
		);
		if ($gbId){
			$shopId = $this->session->get('sid');
			$gb = GroupBooking::findFirstById($gbId);
			
			if ($gb&& $gb->shop_id==$shopId) $gbInfo= $gb->toArray();
			if (count($gbInfo)){
				$gbInfo['stime'] = date('Y-m-d H:i',$gbInfo['stime']);
				$gbInfo['etime'] = date('Y-m-d H:i',$gbInfo['etime']);
			}
		}
		
		$this->view->gbInfo = $gbInfo;
		$this->view->gbId = $gbId;
		$this->view->type = $type;
		
		$this->view->pick("admin/groupBooking/gbedit");
	}
	
	/**
	 * 选择产品页面
	 */
	public function chooseProPageAction(){
		$this->assets
			 ->addCss("css/main.css")
			 ->addJs("lib/jquery/1.9.1/jquery.min.js");
		
		$choosed = isset($_GET['proId']) ? intval($_GET['proId']) : '';
		
		$this->view->prolists = json_encode($this->shopProListAction(), true);
		$this->view->choosed = $choosed;
		
		$this->view->pick("admin/groupBooking/choosePro");
	}
	
	/**
	 * 获取店铺商品列表
	 */
	public function shopProListAction(){
		$proArr = array(); $num = 0;
		$shopId = $this->session->get('sid');
		
		$conditions = array(
				'conditions'=> "shop_id=?1 and del=?2 and hd_type=?3",
				'bind'		=> array(1=>$shopId, 2=>0, 3=>0)
		);
		$count = Product::find($conditions);
		
		$pros = Product::find($conditions);
		
		if ($pros) $proArr = $pros->toArray();
		
		return $proArr;
	}
	
	/**
	 * 获取产品
	 */
	public function getProAction(){
		if ($this->request->isPost()){
			$proId = isset($_POST['proId']) ? $_POST['proId'] : 'false';
			if ($proId == 'false'){
				echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
				exit();
			}
			
			$proArr = array();
			if (strlen($proId)){
				$shopId = $this->session->get('sid');
				$pros = Product::find("shop_id=$shopId and id=$proId");
				
				if ($pros) $proArr = $pros->toArray();
			}
			
			if (count($proArr)) echo json_encode(array('status'=>1, 'pro'=>$proArr[0]));
			else echo json_encode(array('status'=>0, 'pro'=>'产品错误'));
			
		}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
	}
	
	/**
	 * 获取团购列表
	 */
	public function getGBListAction(){
		$shopId = $this->session->get('sid');
		$qtype = isset($_GET['qtype']) ? $_GET['qtype'] : 'all';
		$status = $qtype=='all'?"status!='S0'":($qtype=='S1'?"status='S1'":($qtype=='S2'?"status='S2'":"status='S3'"));
		$gbs = GroupBooking::find("shop_id=$shopId and $status order by addtime desc");
		
		$gbArr = array();
		if ($gbs) $gbArr= $gbs->toArray();
		
		$result = array();
		for($i=0; $i<count($gbArr); ++$i){
			$status = $gbArr[$i]['status']=='S1'?'未开始':($gbArr[$i]['status']=='S2'?'进行中':'已结束');
			array_push($result, array(
					'eidt'	=> '<a href="#" onclick="gbedit(\'团购编辑\',\'../GroupBooking/gbeditPage?gbId='.$gbArr[$i]['id'].'&type=edit\',\'2\',\'770\',\'600\')">编辑</a> | <a href="#" onclick="gbDel('.$gbArr[$i]['id'].')">删除</a>',
					'name'	=> $gbArr[$i]['gbname'],
					'time'	=> date('Y-m-d H:i',$gbArr[$i]['stime']).'至'.date('Y-m-d H:i',$gbArr[$i]['etime']),
					'status'=> $status,
			));
		}
		
		echo json_encode(array('data'=>$result));
	}
	
	/**
	 * 团购编辑
	 */
	public function gbEditAction(){
		if ($this->request->isPost()){
			$gbId = isset($_POST['gbId']) ? intval($_POST['gbId']) : '';
			$name = isset($_POST['name']) ? $_POST['name'] : '';
			$stime = isset($_POST['stime']) ? $_POST['stime'] : '';
			$etime = isset($_POST['etime']) ? $_POST['etime'] : '';
			$mannum = isset($_POST['mannum']) ? intval($_POST['mannum']) : '';
			$gbtime = isset($_POST['gbtime']) ? floatval($_POST['gbtime']) : '';
			$gbnum = isset($_POST['gbnum']) ? intval($_POST['gbnum']) : '';
			$gbprice = isset($_POST['gbprice']) ? floatval($_POST['gbprice']) : '';
			$proId= isset($_POST['proId']) ?  intval($_POST['proId']) : '';
			$type = isset($_POST['type']) ? $_POST['type'] : '';//操作类型
			
			if (!$name || !$mannum || !$gbtime || !$type || !$gbprice){
				echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
				exit();
			}
			if ($type=='add'){
				if (!$proId || !$stime || !$etime){
					echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
					exit();
				}
			}else if (!$gbId){
				echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
				exit();
			}
			$shopId = $this->session->get('sid');
			
			if ($type == 'add'){
				$gb = new GroupBooking();
				$gb->stime = strtotime($stime);
				$gb->etime = strtotime($etime);
				$gb->mannum = $mannum;
				$gb->pid = $proId;
				$gb->gbtime = $gbtime;
				$gb->gbprice = $gbprice;
				$gb->status = 'S1';
				$gb->addtime = time();
				$gb->shop_id = $shopId;
			}else {
				$gb= GroupBooking::findFirstById($gbId);
				
				if ($gb && $gb->etime>time()) $gb->etime = strtotime($etime);
			}
			$gb->gbname = $name;
			$gb->gbnum = $gbnum;
			
			if ($gb->save()) {
				if ($type == 'add'){
					$pro = Product::findFirstById($proId);
					if ($pro){ $pro->hd_type = '2'; $pro->hd_id = $gb->id; $pro->save(); }
				}
				echo json_encode(array('status'=>1, 'msg'=>'success'));
			}
			else json_encode(array('status'=>0, 'msg'=>'操作失败'));
		}else json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
	}
	
	/**
	 * 删除团购活动
	 */
	public function gbDelAction(){
		$gbId= isset($_POST['gbId']) ? intval($_POST['gbId']) : '';
		
		if (!$gbId) {
			echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
			exit();
		}
		
		$gb = GroupBooking::findFirstById($gbId);
		
		if ($gb){
			$shopId = $this->session->get('sid');
			if ($gb->shop_id == $shopId){
				if ($gb->status == 'S2'){
					echo json_encode(array('status'=>0, 'msg'=>'进行中'));
					exit();
				}
				$gb->status = 'S0';
				if ($gb->save()) {
					$pro = Product::findFirstById($pi->pid);
					if ($pro && count($pro)) {
						$pro->hd_type = '0'; $pro->hd_id = 0;
						$pro->save();
					}
					echo json_encode(array('status'=>1, 'msg'=>'success'));
				}
				else echo json_encode(array('status'=>0, 'msg'=>'操作失败'));
			}else echo json_encode(array('status'=>0, 'msg'=>'数据异常'));
		}else echo json_encode(array('status'=>0, 'msg'=>'记录不存在'));
	}
	
}

