<?php

/**
 * 产品参数
 * @author xiao
 *
 */
class ProductAttrController extends AdminBase{

    public function indexAction(){

    }

    /**
     * 所有属性列表
     */
    public function proAttrPageAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/static/h-ui.admin/style.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js")
	    	 ->addJs("js/static/h-ui.admin/H-ui.admin.js")
	    	 ->addJs("lib/datatables/1.10.0/jquery.dataTables.min.js");
    	
    	$this->view->proAttrs = $this->proAttrs();
    	
    	$this->view->pick("admin/product/proAttr");
    }
    /**
     * 获取属性信息
     */
    private function proAttrs(){
    	$sid = $this->session->get('sid');
    	$attrs = ProductAttr::find(array(
    			'conditions'=> "sid=?1 and status!=?2",
    			'bind'		=> array(1=>$sid, 2=>'S0'),
    			'order'		=> "sort desc"
    	));
    	
    	$attrArr = array();
    	if ($attrs) $attrArr = $attrs->toArray();
    	
    	return $attrArr;
    }
    
    /**
     * 产品属性编辑
     */
    public function proAttrAddPageAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/static/h-ui.admin/style.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/squire-raw.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js")
	    	 ->addJs("js/static/h-ui.admin/H-ui.admin.js")
	    	 ->addJs("plugins/xheditor/xheditor-1.2.2.min.js")
	    	 ->addJs("plugins/xheditor/xheditor_lang/zh-cn.js")
	    	 ->addJs("lib/My97DatePicker/4.8/WdatePicker.js")
	    	 ->addJs("lib/datatables/1.10.0/jquery.dataTables.min.js");
    	
	    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	    $this->view->attrInfo = $this->proAttrInfoAction($id);
    	$this->view->pick("admin/product/proAttrAdd");
    }
    /**
     * 获取产品属性详情
     */
    private function proAttrInfoAction($id){
    	$info = array(
    			'id'=>'', 'name'=>'', 'type'=>'', 'pro_id'=>'0',
    			'sort'=>'', 'status'=>'', 'audit_result'=>'', 'values'=>array()
    	);
    	
    	$attr = ProductAttr::findFirstById($id);
    	if ($attr){
    		$info = $attr->toArray();
    		$values = $attr->ProductAttrValue;
    		
    		//$info['values'] = explode(',', $attr->values);
    		$info['values'] = $values->toArray();
    	}
    	
    	return $info;
    }
    
    /**
     * 选择产品页面
     */
    public function chooseProPageAction(){
    	$this->assets
    	->addCss("css/main.css")
    	->addJs("lib/jquery/1.9.1/jquery.min.js");
    	
    	$choosed = isset($_GET['proId']) ? intval($_GET['proId']) : '';
    	
    	$this->view->prolists = json_encode(self::shopProListAction(), true);
    	$this->view->choosed = $choosed;
    	
    	$this->view->pick("admin/groupBooking/choosePro");
    }
    /**
     * 获取店铺商品列表
     */
    private function shopProListAction(){
    	$proArr = array(); $num = 0;
    	$shopId = $this->session->get('sid');
    	
    	$conditions = array(
    			'conditions'=> "shop_id=?1 and del=?2",
    			'bind'		=> array(1=>$shopId, 2=>0)
    	);
    	$count = Product::find($conditions);
    	
    	$pros = Product::find($conditions);
    	
    	if ($pros) $proArr = $pros->toArray();
    	
    	return $proArr;
    }
    /**
     * 保存产品属性
     */
    public function saveProAttrAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    		$name = isset($_POST['name']) ? $_POST['name'] : '';
    		$type = isset($_POST['type']) ? $_POST['type'] : 'T1';
    		$proId = isset($_POST['pro_id']) ? intval($_POST['pro_id']) : 0;
    		$values = isset($_POST['vals']) ? json_decode($_POST['vals'], true) : array();
    		$sort = isset($_POST['sort']) ? intval($_POST['sort']) : 0;
    		$delItems = isset($_POST['delItems']) ? json_decode($_POST['delItems'], true) : array();
    		
    		if (!$name || !$type || ($type=='T2'&&!$proId) || !count($values)){
    			echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    			exit();
    		}
    		$valStr = '';
    		foreach ($values as $k=>$v){
    			$valStr .= $v['name'].',';
    		}
    		
    		$sid = $this->session->get('sid');
    		if ($id){
    			$attr = ProductAttr::findFirstById($id);
    			if (!$attr || !count($attr) || $attr->sid!=$sid){
    				echo json_encode(array('status'=>0, 'msg'=>'产品属性不存在'));
    				exit();
    			}
    		}else {
    			$attr = new ProductAttr();
    			$attr->sid = $sid;
    			$attr->audit_result = 'R0';
    			$attr->status = 'S1';
    			$attr->name = $name;
    		}
    		$attr->type = $type;
    		$attr->pro_id = $proId;
    		$attr->values = trim($valStr, ',');
    		$attr->sort = $sort;
    		
    		if ($attr->save()) {
    			self::delAttrValues($delItems);//删除属性值
    			self::saveAttrValues($values, $attr->id);//保存属性值
    			echo json_encode(array('status'=>1, 'msg'=>'success'));
    		}
    		else echo json_encode(array('status'=>0, 'msg'=>'操作失败'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }
    /**
     * 删除属性值
     */
    private function delAttrValues($datas){
    	if ($datas && count($datas)){
    		foreach ($datas as $k=>$v){
    			$val = ProductAttrValue::findFirstById($v['id']);
    			if ($val && $val->pid==$v['pid']) $val->delete();
    		}
    		
    		//删除产品中sku
    	}
    }
    /**
     * 保存属性值
     */
    private function saveAttrValues($datas, $pid){
    	foreach ($datas as $k=>$v){
    		if ($v['id']){
    			$val = ProductAttrValue::findFirstById($v['id']);
    			if (!$val || !($val->pid==$pid)) break;
    		}else $val = new ProductAttrValue();
    		$val->name = $v['name'];
    		$val->pid = $pid;
    		$val->pname = $v['pname'];
    		$val->save();
    	}
    }
    
    
}

