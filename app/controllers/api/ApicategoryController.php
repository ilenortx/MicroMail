<?php

/**
 * 分类接口
 * @author xiao
 *
 */
class ApicategoryController extends ApiBase{

    public function indexAction(){
    }
    
    public function pcategorysAction(){
    	$cs = Category::find(array('conditions'=>'tid=?1 and status=?2', 'bind'=>array(1=>1, 2=>'S1'), 'order'=>"sort desc"));
    	if ($cs){
    		$csArr = array();
    		$cs = $cs->toArray();
    		
    		$shopId = (isset($_POST['shop_id'])&&intval($_POST['shop_id'])) ? intval($_POST['shop_id']) : 'all';
    		$pcid = isset($_POST['pcid'])&&intval($_POST['pcid']) ? $_POST['pcid'] : $cs[0]['id'];
    		$ccategoryList = new CategoryController();
    		$ccglist = $ccategoryList->ccategoryListAction($pcid);
    		
    		$pros = array();
    		if (count($ccglist)){
    			$product = new ProductController();
    			$pros = $product->cidToProAction($ccglist[0]['id'], $shopId);
    		}
    		
    		echo json_encode(array('status'=>1, 'pcglist'=>$cs, 'ccglist'=>$ccglist, 'prolist'=>$pros));
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
    			$ccategoryList = new CategoryController();
    			$ccglist = $ccategoryList->ccategoryListAction($pcid);
    			
    			$pros = array();
    			if (count($ccglist)){
    				$product = new ProductController();
    				$pros = $product->cidToProAction($ccglist[0]['id'], $shopId);
    			}
    			
    			echo json_encode(array('status'=>1, 'ccglist'=>$ccglist, 'prolist'=>$pros));
    		}else echo json_encode(array('status'=>0, 'msg'=>'参数错误'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }
    
    /**
     * 二级选项点击获取商品列表
     */
    public function getccgProListAction(){
    	if ($this->request->isPost()){
    		if (isset($_POST['ccid']) && intval($_POST['ccid'])){
    			$ccid = $this->request->getPost('ccid');
    			$shopId = (isset($_POST['shop_id'])&&intval($_POST['shop_id'])) ? intval($_POST['shop_id']) : 'all';
    			$offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
    			
    			$pros = array();
    			$product = new ProductController();
    			$pros = $product->cidToProAction($ccid, $shopId, $offset);
    			
    			echo json_encode(array('status'=>1, 'prolist'=>$pros));
    		}else echo json_encode(array('status'=>0, 'msg'=>'参数错误'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }
    
    /**
     * 初始化分类列表(左右形式)
     */
    public function cgInitAction(){
    	$cg1 = Category::find(array(//一级分类
    			'conditions'=>'tid=?1 and status=?2',
    			'bind'=>array(1=>1, 2=>'S1'),
    			'order'=>"sort desc"
    	));
    	
    	$cgArr = array();
    	if ($cg1){
    		$cgArr = $cg1->toArray();
    		$cgArr[0]['childs'] = $this->reclassify($cgArr[0]['id']);
    		
    		echo json_encode(array('status'=>1, 'cgarr'=>$cgArr));
    	}else echo json_encode(array('status'=>0, 'msg'=>'暂无数据!'));
    }
    /**
     * 根据一级分类id获取子分类
     */
    public function reclassifyAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    		if (!$id){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误!'));
    			exit();
    		}
    		
    		$childs = $this->reclassify($id);
    		echo json_encode(array('status'=>1, 'childs'=>$childs));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误'));
    }
    public function reclassify($id=0){
    	$cgArr = array();
    	if ($id){
    		$cg = Category::find(array(//一级分类
    				'conditions'=>'tid=?1 and status=?2',
    				'bind'=>array(1=>$id, 2=>'S1'),
    				'order'=>"sort desc"
    		));
    		
    		if ($cg) $cgArr = $cg->toArray();
    	}
    	
    	return $cgArr;
    }
    public function loadProsAction(){
    	if ($this->request->isPost()){
    		$cgid = isset($_POST['cgid']) ? intval($_POST['cgid']) : 0;
    		$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    		$sort = isset($_POST['sort']) ? intval($_POST['sort']) : 0;
    		$shopId = isset($_POST['shopId']) ? ($_POST['shopId']=='all'?$_POST['shopId'] : intval($_POST['shopId'])) : 0;
    		if (!$cgid || !$shopId){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误!'));
    			exit();
    		}
    		
    		$conditions = array(
    				'conditions'=> "del=0 and is_down=0 and cid=$cgid",
    				'order'		=> "sort desc",
    				'limit'		=> array('number'=>12, 'offset'=>$offset*12),
    				'columns'	=> "id,name,price,price_yh,photo_x,is_show,is_hot,num"
    		);
    		if ($sort == 0) $conditions['order'] = "sort desc";
    		else if ($sort == 1) $conditions['order'] = "addtime desc";
    		else if ($sort == 2) $conditions['order'] = "price_yh asc";
    		else if ($sort == 3) $conditions['order'] = "price_yh desc";
    		else if ($sort == 4) $conditions['order'] = "shiyong desc";
    		
    		$pros = Product::find($conditions);
    		$proArr = array();
    		if ($pros) $proArr = $pros->toArray();
    		
    		echo json_encode(array('status'=>1, 'pros'=>$proArr));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误'));
    }
}

