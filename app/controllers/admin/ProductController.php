<?php

/**
 * 商品管理
 * @author xiao
 *
 */
class ProductController extends AdminBase{

    public function indexAction(){

    }

    /**
     * 商品列表页面
     */
    public function plPageAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/layui/layui.css")
	    	 ->addCss("css/pages/admin/public.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/jquery/jquery.cookie.js")
	    	 ->addJs("lib/layui/layui.js")
	    	 ->addJs("js/pages/admin/pageOpe.js")
	    	 ->addJs("js/pages/admin/product/plpage.js");

    	/* $products = array();
    	$plist = Product::find(array(
    			'conditions'=>'del!=?1 and shop_id=?2',
    			'bind'=>array(1=>1, 2=>$this->session->get('sid'))
    	));
    	if ($plist) $products = $plist->toArray();
    	$this->view->products = $products; */
	    $this->view->isDown = isset($_GET['isDown']) ? $_GET['isDown'] : 0;


    	$this->view->pick("admin/product/productList");
    }

    /**
     * 商品增加页面
     */
    public function paPageAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/static/h-ui.admin/style.css")
             ->addCss("css/layui/layui.css")
	    	 ->addCss("css/sku/sku_style.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/squire-raw.js")
	    	 ->addJs("lib/layer/layer.js")
             ->addJs("lib/layui/layui.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js")
	    	 ->addJs("js/static/h-ui.admin/H-ui.admin.js")
	    	 ->addJs("plugins/xheditor/xheditor-1.2.2.min.js")
	    	 ->addJs("plugins/xheditor/xheditor_lang/zh-cn.js")
	    	 ->addJs("lib/My97DatePicker/4.8/WdatePicker.js")
	    	 ->addJs("lib/datatables/1.10.0/jquery.dataTables.min.js")
	    	 ->addJs("js/sku/createSkuTable.js")
	    	 ->addJs("js/sku/customSku.js");

	    $list2 = $this->categoryAction(1);	//获取二级分类
	    $this->view->list2 = $list2;
	    $list3Array = array();
	    foreach ($list2 as $k=>$v){
	    	$list3Array[$v['id']] = $this->categoryAction($v['id']);
	    }
	    $this->view->list3 = json_encode($list3Array);

	    //获取所有品牌
	    $brand = new BrandController();
	    $brandArr = $brand->brandListAction();
	    $this->view->brand = $brandArr;

	    //产品说明列表
	    $prosns = $this->prosnList('shopid', $this->session->get('sid'));
	    $this->view->prosns = $prosns;

	    $pid = isset($_GET['pid']) ? $_GET['pid'] : '';
	    $pifno = $this->proInfoAction($pid);
        $pifno[0]['parm'] = json_decode($pifno[0]['parm'], true);

	    $this->view->proInfo = $pifno[0];
	    $this->view->attrs = self::getProAttr($pid);
	    $this->view->skus = json_encode(self::getProSku($pid));
	    $this->view->catetwo = $pifno[1];
	    $this->view->pid = $pid;
	    $this->view->cxlist = self::procxlistAction();
        $this->view->parmData = $pifno[2];
	    $this->view->pick("admin/product/productAdd");
    }

    /**
     * 商品excel导入页面
     */
    public function peiPageAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/static/h-ui.admin/style.css")
	    	 ->addCss("css/pages/admin/product/proExcelImport.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js")
	    	 ->addJs("js/static/h-ui.admin/H-ui.admin.js")
	    	 ->addJs("js/pages/admin/pageOpe.js")
	    	 ->addJs("js/pages/admin/product/proExcelImport.js");

    	$this->view->pick("admin/product/proExcelImport");
    }

    /**
     * 获取产品信息
     */
    public function proInfoAction($pid){
    	$proArr = array(
    			'id'=>'', 'name'=>'', 'intro'=>'', 'cateid'=>'', 'cid'=>'', 'brand_id'=>'',
    			'company'=>'', 'price'=>'', 'price_yh'=>'', 'price_jf'=>'', 'pro_number'=>'',
    			'num'=>'', 'photo_x'=>'', 'photo_d'=>'', 'content'=>'', 'renqi'=>'', 'sort'=>'','is_show'=>0,
    			'is_hot'=>0, 'photo_string'=>'', 'tid'=>'', 'video'=>'', 'procxid'=>'', 'tjpro'=>'',
    			'photo_tjx'=>'', 'photo_tj'=>'', 'snids'=>array()
    	);
    	$catetwo = '';
        $new_array = array();

    	$pro = Product::findFirstById($pid);
    	if ($pro) {
    		$proArr = $pro->toArray();
    		$proArr['photo_string'] = explode(',', trim($proArr['photo_string'], ','));
    		$cg = $pro->category;
    		if ($cg) {
    			$proArr['tid'] = $cg->tid;
    			$ct = Category::find("tid={$cg->tid}");
    			if ($ct) $catetwo = $ct->toArray();

                $cat_info = $cg->toArray();
                if($cat_info['parm_id'] > 0){
                    $this->getProParms($cg, $new_array);
                }

    		}else $proArr['tid'] = 0;
    		$proArr['snids'] = explode(',', trim($proArr['snids'], ','));
    	}

    	return array($proArr, $catetwo, $new_array);
    }

    /**
     * 获取商品列表
     */
    public function proListAction(){
    	//获取页面参数
    	$page = (isset($_GET['page'])&&intval($_GET['page'])) ? intval($_GET['page']) : 0;
    	$limit = (isset($_GET['limit'])&&intval($_GET['limit'])) ? intval($_GET['limit']) : 0;
    	$isDown = (isset($_GET['isDown'])) ? intval($_GET['isDown']) : 0;

    	/* $pl = new AproductBase();
    	$proArr = $pl->proList($this->session->get('sid')); */
    	$sid = $this->session->get('sid');
    	$proArr = Product::proList(array('conditions'=>"shop_id=$sid and is_down=$isDown and del=0"));

    	foreach ($proArr as $k=>$v){
    		$proArr[$k]['attrs'] = "";
    		if ($v['is_show']==1) $proArr[$k]['attrs'] .= "<p id=\"new_{$v['id']}\"><a class=\"label blue\" onclick=\"pro_new({$v['id']},0)\">新品上市</p>";
    		else $proArr[$k]['attrs'] .= "<p id=\"new_{$v['id']}\"><a class=\"label err\" onclick=\"pro_new({$v['id']},1);\">非新品</a></p>";

    		if ($v['is_hot']==1) $proArr[$k]['attrs'] .= "<p id=\"hot_{$v['id']}\"><a class=\"label succ\" onclick=\"pro_hot({$v['id']},0)\">热卖商品</p>";
    		else $proArr[$k]['attrs'] .= "<p id=\"hot_{$v['id']}\"><a class=\"label err\" onclick=\"pro_hot({$v['id']},1)\">非热卖</p>";

    		$proArr[$k]['operate'] = "";
    		if ($v['stype']==1){
    			$proArr[$k]['operate'] .= "<a style=\"text-decoration:none\" lay-event=\"tjset\" tjstatus='0' href=\"javascript:;\" title=\"取消推荐\"><i class=\"Hui-iconfont\">&#xe631;</i></a>";
    		}else {
    			$proArr[$k]['operate'] .= "<a style=\"text-decoration:none\" lay-event=\"tjset\" tjstatus='1' href=\"javascript:;\" title=\"推荐\"><i class=\"Hui-iconfont\">&#xe615;</i></a>";
    		}
    		/* $proArr[$k]['operate'] .= "
				<a title=\"编辑\" href=\"../Product/paPage?pid={$v['id']}\" class=\"ml-5\" style=\"text-decoration:none\"><i class=\"Hui-iconfont\">&#xe6df;</i></a>
				<a title=\"删除\" href=\"javascript:;\" onclick=\"existProDel({$v['id']},this)\" class=\"ml-5\" style=\"text-decoration:none\"><i class=\"Hui-iconfont\">&#xe6e2;</i></a>
			"; */
    		$proArr[$k]['operate'] .= "
	    		<a title=\"编辑\" onclick=\"openEditFull('产品编辑', '../Product/paPage?pid={$v['id']}')\" class=\"ml-5\" style=\"text-decoration:none\"><i class=\"Hui-iconfont\">&#xe6df;</i></a>
	    		<a title=\"删除\" href=\"javascript:;\" onclick=\"existProDel({$v['id']},this)\" class=\"ml-5\" style=\"text-decoration:none\"><i class=\"Hui-iconfont\">&#xe6e2;</i></a>
    		";
    		
    		$proArr[$k]['photo_x'] = '<img src="../files/uploadFiles/'.$v['photo_x'].'" width="80px" height="80px" />';
    		if ($v['stype']==1) $proArr[$k]['stype'] = '<label style="color:green;">推荐</label>';
    		else $proArr[$k]['stype'] = '';

    	}

    	$this->tableData($proArr, 0, '加载成功!', array('page'=>$page, 'limit'=>$limit));
    }


    /**
     * 获取产品属性
     */
    private function getProAttr($pid){
    	$attrArr = array();

    	$sid = $this->session->get('sid');

    	$attrs = ProductAttr::find("sid=$sid");

    	if ($attrs){
    		$attrArr = $attrs->toArray();


    		if ($pid) $proAttrs = ProductAttrs::find("pid=$pid");
    		else $proAttrs = array();
    		$paArr = array();
    		foreach ($proAttrs as $k=>$v){
    			foreach (explode(',', trim($v->values, ',')) as $k){
    				array_push($paArr, $k);
    			}
    		}

    		foreach ($attrs as $k=>$v){
    			$vals = $v->ProductAttrValue;
    			if ($vals){
    				$varr = $vals->toArray();
    				foreach ($varr as $k1=>$v1){
    					if (in_array($v1['id'], $paArr)) $varr[$k1]['checked'] = 1;
    					else $varr[$k1]['checked'] = 0;
    				}

    				$attrArr[$k]['values'] = $varr;
    			}else $attrArr[$k]['values'] = array();
    		}
    	}


    	return $attrArr;
    }
	/**
	 * 产品sku值
	 */
    private function getProSku($pid){
    	$skuJson = array();
    	if ($pid){
    		$sku = ProductSku::find("pid=$pid");
    		foreach ($sku as $k=>$v){
    			$skuJson[$v->skuid] = array('skuPrice'=>$v->price, 'skuStock'=>$v->stock);
    		}
    	}

    	return $skuJson;
    }

    /**
     * 产品分类
     */
    public function categoryAction($tid=0){
    	$category = new CategoryController();
    	$list = $category->ccategoryListAction($tid);

    	return $list;
    }

    /**
     * 新增产品
     */
    public function addProductAction(){
    	if ($this->request->isPost()){
    		try{
    			//如果不是管理员则查询商家会员的店铺ID
    			$id = isset($_POST['pro_id']) ? intval($_POST['pro_id']) : '';
    			$array=array(
    				'name'			=>	$_POST['name'],
    				'intro'			=>	$_POST['intro'],
    				//'shop_id'		=> 	intval($_POST['shop_id']),//所属店铺
    				'cid'			=> 	intval($_POST['cid']),			//产品分类ID
    				'brand_id'		=> 	intval($_POST['brand_id']),//产品品牌ID
    				'pro_number'	=>	$_POST['pro_number'],	//产品编号
    				'sort'			=>	(int)$_POST['sort'],
    				'price'			=>	(float)$_POST['price'],
    				'price_yh'		=>	(float)$_POST['price_yh'],
    				'price_jf'		=>	(float)$_POST['price_jf'],//赠送积分
    				'updatetime'	=>	time(),
    				'num'			=>	(int)$_POST['num'],			//库存
    				'content'		=>	$_POST['content'],
    				'company'		=>	$_POST['company'],  //产品单位
    				'pro_type'		=>	1,
    				'renqi' 		=> 	intval($_POST['renqi']),
    				'is_hot'		=>	intval($_POST['is_hot']),//是否热卖
    				'is_show'		=>	intval($_POST['is_show']),//是否新品
    				//'is_sale'		=>	intval($_POST['is_sale']),//是否折扣
    				'procxid'		=>	intval($_POST['procxid']),//是否折扣
    				'tjpro'			=>	trim($_POST['tjpro'],','),//是否折扣
    				'snids'			=>	isset($_POST['snids'])? join(',', $_POST['snids']):'',//产品说明
                    'parm'          =>  isset($_POST['parm'])? json_encode((object)$_POST['parm'], true):'',//商品参数
    			);

    			//判断产品详情页图片是否有设置宽度，去掉重复的100%
    			if(strpos($array['content'], 'width="100%"')){
    				$array['content'] = str_replace(' width="100%"', '', $array['content']);
    			}
    			//为img标签添加一个width
    			$array['content'] = str_replace('alt=""', 'alt="" width="100%"', $array['content']);
    			$array['content'] = preg_replace("/style=.+?['|\"]/i",'',$array['content']);
    			//上传产品小图
    			if (!empty($_FILES["photo_x"]["tmp_name"])) {
    				$info = $this->upload_images($_FILES["photo_x"], "product/".date('Ymd').'/', array('jpg','png','jpeg','gif'));
    				if(!is_array($info)) {
    					$this->error($info);
    					exit();
    				}else{
    					$array['photo_x'] = $info['savepath'].$info['savename'];
    					$xt = Product::findFirstById($id);
    					if ($id && $xt && $xt->photo_x) {
    						$xt = $xt->toArray();
    						$img_url = UPLOAD_FILE.$xt['photo_x'];
    						if(file_exists($img_url)) { @unlink($img_url); }
    					}
    				}
    			}

    			//上传产品大图
    			if (!empty($_FILES["photo_d"]["tmp_name"])) {
    				$info = $this->upload_images($_FILES["photo_d"], "product/".date('Ymd'), array('jpg','png','jpeg','gif'));
    				if(!is_array($info)) {// 上传错误提示错误信息
    					$this->error($info);
    					exit();
    				}else{// 上传成功 获取上传文件信息
    					$array['photo_d'] = $info['savepath'].$info['savename'];
    					$dt = Product::findFirstById($id);
    					if ($id && $dt && $dt->photo_d) {
    						$dt = $dt->toArray();
    						$img_url2 = UPLOAD_FILE.$dt['photo_d'];
    						if(file_exists($img_url2)) { @unlink($img_url2); }
    					}
    				}
    			}

    			//上传产品推荐小图
    			if (!empty($_FILES["photo_tjx"]["tmp_name"])) {
    				$info = $this->upload_images($_FILES["photo_tjx"], "product/".date('Ymd'), array('jpg','png','jpeg','gif'));
    				if(!is_array($info)) {// 上传错误提示错误信息
    					$this->error($info);exit();
    				}else{// 上传成功 获取上传文件信息
    					$array['photo_tjx'] = $info['savepath'].$info['savename'];
    					if ($id){
    						$tj = Product::findFirstById($id);
    						if ($tj && $tj->photo_tjx) {
    							$tj = $tj->toArray();
    							$img_url2 = UPLOAD_FILE.$tj['photo_tjx'];
    							if(file_exists($img_url2)) { @unlink($img_url2); }
    						}
    					}
    				}
    			}
    			//上传产品推荐图
    			if (!empty($_FILES["photo_tj"]["tmp_name"])) {
    				$info = $this->upload_images($_FILES["photo_tj"], "product/".date('Ymd'), array('jpg','png','jpeg','gif'));
    				if(!is_array($info)) {// 上传错误提示错误信息
    					$this->error($info);exit();
    				}else{// 上传成功 获取上传文件信息
    					$array['photo_tj'] = $info['savepath'].$info['savename'];
    					if ($id){
    						$tj = Product::findFirstById($id);
    						if ($tj && $tj->photo_tj) {
    							$tj = $tj->toArray();
    							$img_url2 = UPLOAD_FILE.$tj['photo_tj'];
    							if(file_exists($img_url2)) { @unlink($img_url2); }
    						}
    					}
    				}
    			}

    			//上传小视频
    			if (!empty($_FILES["video"]["tmp_name"])) {
    				if(!is_dir(UPLOAD_FILE.'product/video/')){ @mkdir(UPLOAD_FILE.'product/video/', 0777); }
    				$info = $this->uploadFile($_FILES["video"], "product/video/".date('Ymd'), array('rm','rmvb','mp4'));
    				if(!is_array($info)) {// 上传错误提示错误信息
    					$this->error($info);
    					exit();
    				}else{// 上传成功 获取上传文件信息
    					$array['video'] = $info['savepath'].$info['savename'];
    					$video = Product::findFirstById($id);
    					if ($id && $video && $video->video) {
    						$video = $video->toArray();
    						$img_url2 = UPLOAD_FILE.$dt['video'];
    						if(file_exists($img_url2)) {
    							@unlink($img_url2);
    						}
    					}
    				}
    			}

    			//多张商品轮播图上传
    			$up_arr = array();
    			if (!empty($_FILES["files"]["tmp_name"])) {
    				foreach ($_FILES["files"]['name'] as $k => $val) {
    					$up_arr[$k]['name'] = $val;
    				}

    				foreach ($_FILES["files"]['type'] as $k => $val) {
    					$up_arr[$k]['type'] = $val;
    				}

    				foreach ($_FILES["files"]['tmp_name'] as $k => $val) {
    					$up_arr[$k]['tmp_name'] = $val;
    				}

    				foreach ($_FILES["files"]['error'] as $k => $val) {
    					$up_arr[$k]['error'] = $val;
    				}

    				foreach ($_FILES["files"]['size'] as $k => $val) {
    					$up_arr[$k]['size'] = $val;
    				}
    			}
    			if ($up_arr) {
    				$res=array();
    				$adv_str = '';
    				foreach ($up_arr as $key => $value) {
    					$res = $this->upload_images($value,"product/".date('Ymd').'/',array('jpg','png','jpeg','gif'));
    					if(is_array($res)) {
    						// 上传成功 获取上传文件信息保存数据库
    						$adv_str .= ','.$res['savepath'].$res['savename'];
    					}
    				}
    				$array['photo_string'] = $adv_str;
    			}

    			$sql = false;
    			//执行添加
    			if(intval($id)>0){
    				$product = Product::findFirstById($id);

    				$product->photo_x = isset($array['photo_x'])?$array['photo_x']:$product->photo_x;
    				$product->photo_d = isset($array['photo_d'])?$array['photo_d']:$product->photo_d;
    				$product->photo_string = isset($array['photo_string'])?$product->photo_string.$array['photo_string']:$product->photo_string;

    			}else{
    				$product = new Product();
    				$product->addtime = time();
    				$product->photo_x = isset($array['photo_x'])?$array['photo_x']:'';
    				$product->photo_d = isset($array['photo_d'])?$array['photo_d']:'';
    				$product->photo_string = isset($array['photo_string'])?$array['photo_string']:'';
    			}
    			$product->name= $array['name'];
    			$product->intro= $array['intro'];
    			$product->shop_id= $this->session->get('sid');
    			$product->cid= $array['cid'];
    			$product->brand_id= $array['brand_id'];
    			$product->pro_number= $array['pro_number'];
    			if (isset($array['video'])&&!empty($array['video'])) $product->video = $array['video'];
    			if (isset($array['photo_tjx'])&&!empty($array['photo_tjx'])) $product->photo_tjx= $array['photo_tjx'];
    			if (isset($array['photo_tj'])&&!empty($array['photo_tj'])) $product->photo_tj= $array['photo_tj'];
    			$product->sort= "";
    			$product->price= $array['price'];
    			$product->price_yh= $array['price_yh'];
    			$product->price_jf= $array['price_jf'];
    			$product->updatetime= $array['updatetime'];
    			$product->num= $array['num'];
    			$product->content= $array['content'];
    			$product->company= $array['company'];
    			$product->pro_type= $array['pro_type'];
    			$product->renqi= $array['renqi'];
    			$product->is_hot= $array['is_hot'];
    			$product->is_show= $array['is_show'];
    			$product->is_sale= "";
    			$product->procxid= $array['procxid'];
    			$product->tjpro = $array['tjpro'];
    			$product->snids = $array['snids'];
    			$product->sort = $array['sort'];
                $product->parm = $array['parm'];

    			$sql = $product->save();

    			//规格操作
    			if($sql){
    				$psku = isset($_POST['sku']) ? json_decode($_POST['sku'], true) : '';
    				$proAttrs = isset($_POST['proAttrs']) ? json_decode($_POST['proAttrs'], true) : '';

    				$sku = new SkuBase();
    				$sku->reProSku($product->id, $psku);//修改sku
    				$sku->reProAttrs($product->id, $proAttrs);//修改产品属性

    				if ($id){
    					//echo "<script>window.location.href='../Product/plPage'; </script>";
    					//echo "<script>layer.msg('保存成功!', { icon: 6, time: 1000 });window.parent.reloadProList();</script>";
    					$this->msg('succsss');
    				}else{
    					//echo "<!doctype html><html lang='en'><head><meta charset='UTF-8'></head><body style='background-color:rgba(0,0,0,0.5)'><div style='width:200px;height:100px;background:#000;border:1px solid #f3f3f3;border-radius:5px;position:absolute;left:50%;top:50%;margin:-50px -100px;'><div style='width:100%;height:50px;color:#fff;font-size:16px;line-height:40px;padding-left:30px;'>添加成功!</div><button id='btn' style='width:70px;height:30px;background:#000;color:#fff;font-size:16px;margin:5px 65px;border:1px solid #f3f3f3;border-radius:5px;'>确定</button></div></body></html><script>function jump(){ window.location.href='../Product/paPage'; }window.setTimeout('jump()', 1000);var i=5;var btn = document.getElementById('btn'); btn.onclick = function(){ jump(); } </script>";
    					$this->msg('succsss');
    				}
    			}else{
    				//echo "<!doctype html><html lang='en'><head><meta charset='UTF-8'></head><body style='background-color:rgba(0,0,0,0.5)'><div style='width:200px;height:100px;background:#000;border:1px solid #f3f3f3;border-radius:5px;position:absolute;left:50%;top:50%;margin:-50px -100px;'><div style='width:100%;height:50px;color:#fff;font-size:16px;line-height:40px;padding-left:30px;'>操作失败!</div><button id='btn' style='width:70px;height:30px;background:#000;color:#fff;font-size:16px;margin:5px 65px;border:1px solid #f3f3f3;border-radius:5px;'>确定</button></div></body></html><script>function jump(){ window.location.href='../Product/paPage?pid={$id}'; }window.setTimeout('jump()', 1000);var i=5;var btn = document.getElementById('btn'); btn.onclick = function(){ jump(); } </script>";
    				$this->err('操作失败!');
    			}

    		}catch(\Exception $e){
    			echo "<script>alert('".$e->getMessage()."');</script>";
    		}
    	}

    }

    /**
     * 新品设置
     */
    public function proNewAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['pro_id']) ? $this->request->getPost('pro_id') : '';
    		$type = isset($_POST['type']) ? $this->request->getPost('type') : '';

    		if ($id && $type>=0){
    			$pro = Product::findFirstById($id);
    			if ($pro){
    				$pro->is_show= $type;
    				if ($pro->save()) echo json_encode(array('status'=>1, 'mag'=>'success'));
    				else echo json_encode(array('status'=>1, 'mag'=>'保存错误!'));
    			}else echo json_encode(array('status'=>1, 'mag'=>'产品不存在!'));
    		}else echo json_encode(array('status'=>1, 'mag'=>'数据错误!'));
    	}else echo json_encode(array('status'=>1, 'mag'=>'通信方法错误!'));
    }

    /**
     * 热销设置
     */
    public function proHotAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['pro_id']) ? $this->request->getPost('pro_id') : '';
    		$type = isset($_POST['type']) ? $this->request->getPost('type') : '';

    		if ($id && $type>=0){
    			$pro = Product::findFirstById($id);
    			if ($pro){
    				$pro->is_hot = $type;
    				if ($pro->save()) echo json_encode(array('status'=>1, 'mag'=>'success'));
    				else echo json_encode(array('status'=>1, 'mag'=>'操作错误!'));
    			}else echo json_encode(array('status'=>1, 'mag'=>'产品不存在!'));
    		}else echo json_encode(array('status'=>1, 'mag'=>'数据错误!'));
    	}else echo json_encode(array('status'=>1, 'mag'=>'通信方法错误!'));
    }

    /**
     * 推荐设置
     */
    public function proTjAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? $this->request->getPost('id') : '';
    		$type = isset($_POST['type']) ? $this->request->getPost('type') : '';

    		if ($this->session->get('scType') == 'ST0'){
    			if ($id && $type>=0){
    				$pro = Product::findFirstById($id);
    				if ($pro){
    					$pro->type = $type;
    					if ($pro->save()) echo json_encode(array('status'=>1, 'mag'=>'success'));
    					else echo json_encode(array('status'=>1, 'mag'=>'操作错误!'));
    				}else echo json_encode(array('status'=>0, 'mag'=>'产品不存在!'));
    			}else echo json_encode(array('status'=>0, 'mag'=>'数据错误!'));
    		}else echo json_encode(array('status'=>0, 'mag'=>'没有权限!'));
    	}else echo json_encode(array('status'=>0, 'mag'=>'通信方法错误!'));
    }
    public function proTj1Action(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? $this->request->getPost('id') : '';
    		$type = isset($_POST['type']) ? $this->request->getPost('type') : '';

    		if ($id && $type>=0){
    			$pro = Product::findFirstById($id);
    			if ($pro){
    				$pro->stype = $type;
    				if ($pro->save()) echo json_encode(array('status'=>1, 'mag'=>'success'));
    				else echo json_encode(array('status'=>0, 'mag'=>'操作错误!'));
    			}else echo json_encode(array('status'=>0, 'mag'=>'产品不存在!'));
    		}else echo json_encode(array('status'=>0, 'mag'=>'数据错误!'));
    	}else echo json_encode(array('status'=>0, 'mag'=>'通信方法错误!'));
    }

    /**
     * 删除产品
     */
    public function proDelAction(){
    	if ($this->request->isPost()){
    		$ids = isset($_POST['ids']) ? $this->request->getPost('ids') : '';
    		if ($ids){
    			$result = Product::proDel(trim($ids, ','), $this->session->get('sid'));
    			if ($result == 'SUCCESS') $this->msg('SUCCESS');
    			else if ($result == 'DATAERR') $this->err('数据错误');
    			else if ($result == 'OPEFILE') $this->err('操作失败');
    			else if ($result == 'DATAEXCEPTION') $this->err('数据异常');
    		}else echo json_encode(array('status'=>1, 'mag'=>'数据错误!'));
    	}else echo json_encode(array('status'=>1, 'mag'=>'通信方法错误!'));
    }

    /**
     * 根据分类id(cid)获取商品
     */
    public function cidToProAction($cid=1, $shopId='all',$offset=0, $number=12){
    	$proArr = array();
    	if ($cid){
    		$conditions = array(
    				'conditions'=> 'cid=?1 and del=?2 and is_down=?3',
    				'bind'		=> array(1=>$cid, 2=>0, 3=>0),
    				'limit'		=> array("number"=>$number, "offset"=>$offset*$number)
    		);
    		if ($shopId!='all' && intval($shopId)){
    			$conditions['conditions'] .= " and shop_id=?4";
    			$conditions['bind'][4] = $shopId;
    		}

    		$pros = Product::find($conditions);

    		if ($pros) $proArr= $pros->toArray();
    	}
    	return $proArr;
    }

    /**
     * 根据一级分类id获取产品
     */
    public function getOCProsAction($ocid, $shopId='all', $hdType='0', $offset=false){
    	$cs = Category::find(array(
    			'conditions'=> "tid=?1 and status=?2",
    			'bind'		=> array(1=>$ocid, 2=>'S1')
    	));

    	$proArr = array();
    	if ($cs){
    		$csids = '';
    		foreach ($cs as $k=>$v){
    			$csids .= $v->id.',';
    		}
    		$csids = trim($csids, ',');

    		$conditions = "cid in ($csids) and hd_type='$hdType'";

    		if ($shopId!='all' && intval($shopId)){
    			$conditions .= " and shop_id=$shopId";
    		}

    		if ($offset || $offset>=0){
    			$s = $offset*10;
    			$conditions .= " limit $s,10";
    		}

    		$pros = Product::find($conditions);

    		if ($pros) {
    			if ($hdType == '2'){
    				foreach ($pros as $k=>$v){
    					$proArr[$k] = $v->toArray();
    					$ab = new ActivityBase();
    					$proArr[$k]['gbprice'] = $ab->gbInfo($v->hd_id)['gbprice'];
    				}
    			}else if ($hdType == '3'){
    				$ab = new ActivityBase();
    				$cps = $ab->cutPrices($shopId, 'S2');
    				foreach ($pros as $k=>$v){
    					if (isset($cps[$v->hd_id])){
    						$proArr[$k] = $v->toArray();
    						$proArr[$k]['cpprice'] = $cps[$v->hd_id]->low_price;
    					}
    				}
    			}else {
    				$proArr = $pros->toArray();
    			}
    		}
    	}

    	return $proArr;
    }

    /**
     * 应用获取商品列表
     */
    public function appPrlListAction(){

    }

    /**
     * 获取店铺商品列表
     */
    public function shopProListAction($shopId){
    	$proArr = array();
    	$pros = Product::find(array(
    			'conditions'=> "shop_id=?1 and del=?2",
    			'bind'		=> array(1=>$shopId, 2=>0)
    	));

    	if ($pros) $proArr = $pros->toArray();
    	return $proArr;
    }

    /**
     * 删除图片
     */
    public function delImgAction(){
    	if ($this->request->isPost()){
    		$img = (isset($_POST['img_url'])&&!empty($_POST['img_url'])) ? $_POST['img_url'] : '';
    		$pid = isset($_POST['pro_id']) ? intval($_POST['pro_id']) : '';

    		if (!$img || !$pid){
    			echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    			exit();
    		}

    		$pro = Product::findFirstById($pid);
    		if ($pro) {
    			$pro->photo_string = str_replace(','.$img, '', $pro->photo_string);
    			if ($pro->save()){
    				$url = UPLOAD_FILE.$img;
    				if (file_exists($url)) { //删除文件中得图片
    					@unlink($url);
    				}

    				echo json_encode(array('status'=>1, 'msg'=>'success'));
    			}else echo json_encode(array('status'=>0, 'msg'=>'删除失败!'));
    		}else echo json_encode(array('status'=>0, 'msg'=>'产品不存在!'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求错误!'));
    }

    /**
     * 删除小视频
     */
    public function delVideoAction(){
    	if ($this->request->isPost()){
    		$video = (isset($_POST['video_url'])&&!empty($_POST['video_url'])) ? $_POST['video_url'] : '';
    		$pid = isset($_POST['pro_id']) ? intval($_POST['pro_id']) : '';

    		if (!$video|| !$pid){
    			echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    			exit();
    		}

    		$pro = Product::findFirstById($pid);
    		if ($pro) {
    			$pro->video = '';
    			if ($pro->save()){
    				$url = UPLOAD_FILE.$video;
    				if (file_exists($url)) { //删除文件中得图片
    					@unlink($url);
    				}

    				echo json_encode(array('status'=>1, 'msg'=>'success'));
    			}else echo json_encode(array('status'=>0, 'msg'=>'删除失败!'));
    		}else echo json_encode(array('status'=>0, 'msg'=>'产品不存在!'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求错误!'));
    }



    /**
     * 商品促销页面
     */
    public function proCxPageAction(){
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

    	$products = array();
    	$pclist = ProductCx::find(array(
    			'conditions'=>'status=?1 and shop_id=?2',
    			'bind'=>array(1=>'S1', 2=>$this->session->get('sid'))
    	));
    	if ($pclist) $pcs = $pclist->toArray();
    	$this->view->pcs = $pcs;


    	$this->view->pick("admin/product/productCx");
    }

    /**
     * 产品属性编辑
     */
    public function proCxAddPageAction(){
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
    	$this->view->cxInfo = $this->proCxDeail($id);
    	$this->view->pick("admin/product/proCxAdd");
    }
    /**
     * 获取产品促销详情
     */
    private function proCxDeail($id){
    	$info = array( 'id'=>'', 'name'=>'', 'photo'=>'', 'adphoto'=>'', 'proids'=>'', 'sstyle'=>'S1', 'pros'=>array() );

    	$csx = ProductCx::findFirstById($id);
    	if ($csx){
    		$info = $csx->toArray();
    		$proids = intval($csx->proids);
    		if ($proids){
    			$pros = Product::find(array(
    					'conditions'=> "id in($proids)",
    					'columns'	=> 'id,photo_tj'
    			));
    			if ($pros) $info['pros'] = $pros->toArray();
    		}else {
    			$info['pros'] = array();
    		}
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

    	$choosed = isset($_GET['proIds']) ? trim($_GET['proIds'], ',') : '';

    	$this->view->prolists = json_encode($this->shopProListAction($this->session->get('sid')), true);
    	$this->view->choosed = $choosed?trim($choosed,','):'';

    	$this->view->pick("admin/cutPriceSprites/choosePro");
    }
    /**
     * 编辑产品促销
     */
    public function saveProCxAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    		$name = isset($_POST['name']) ? $_POST['name'] : '';
    		$proids = isset($_POST['proids']) ? trim($_POST['proids']) : '';
    		$sstyle = isset($_POST['sstyle']) ? $_POST['sstyle'] : '';

    		if (!$name || !$proids || !$sstyle){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误'));exit();
    		}

    		if ($id){
    			$pc = ProductCx::findFirstById($id);
    			if ($pc && count($pc)){
    				if ($pc->shop_id != $this->session->get("sid")){
    					echo json_encode(array('status'=>0, 'err'=>'权限不够'));exit();
    				}
    			}else {
    				echo json_encode(array('status'=>0, 'err'=>'不存在'));exit();
    			}
    		}else {
    			$pc = new ProductCx();
    			$pc->shop_id = $this->session->get("sid");
    		}

    		if (!empty($_FILES["photo"]["tmp_name"])) {
    			if ($id && !empty($pc->photo)){
    				$img_url = UPLOAD_FILE.$pc->photo;
    				if(file_exists($img_url)) { @unlink($img_url); }
    			}

    			$info = $this->upload_images($_FILES["photo"], "productCx/".date('Ymd').'/', array('jpg','png','jpeg','gif'));
    			if(!is_array($info)) {
    				$this->error($info);exit();
    			}else $pc->photo = $info['savepath'].$info['savename'];
    		}
    		if (!empty($_FILES["adphoto"]["tmp_name"])) {
    			if ($id && !empty($pc->adphoto)){
    				$img_url = UPLOAD_FILE.$pc->adphoto;
    				if(file_exists($img_url)) { @unlink($img_url); }
    			}

    			$info = $this->upload_images($_FILES["adphoto"], "productCx/".date('Ymd').'/', array('jpg','png','jpeg','gif'));
    			if(!is_array($info)) {
    				$this->error($info);exit();
    			}else $pc->adphoto= $info['savepath'].$info['savename'];
    		}
    		$pc->name = $name;
    		$pc->proids = $proids;
    		$pc->sstyle = $sstyle;

    		if ($pc->save()) echo json_encode(array('status'=>1, 'msg'=>'success'));
    		else echo json_encode(array('status'=>0, 'err'=>'操作失败'));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误'));
    }

    /**
     * 删除产品促销
     */
    public function delProCxAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    		if (!$id){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误')); exit();
    		}

    		$pc = ProductCx::findFirstById($id);
    		if ($pc && count($pc)){
    			if ($pc->shop_id != $this->session->get("sid")){
    				echo json_encode(array('status'=>0, 'err'=>'权限不够'));exit();
    			}
    			$pc->status = 'S0';
    			if ($pc->save()) echo json_encode(array('status'=>1, 'msg'=>'success'));
    			else echo json_encode(array('status'=>0, 'err'=>'操作失败'));
    		}else {
    			echo json_encode(array('status'=>0, 'err'=>'不存在'));exit();
    		}
    	}
    }

    /**
     * 获取促销产品列表
     */
    public function procxlistAction(){
    	$cxlist = ProductCx::find(array(
    			'conditions'=> "status=?1 and shop_id=?2",
    			'bind'		=> array(1=>'s1', 2=>$this->session->get('sid'))
    	));
    	$cxArr = array();
    	if ($cxlist) $cxArr = $cxlist->toArray();

    	return $cxArr;
    }

    /**
     * 产品服务说明页面
     */
    public function prosnPageAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/static/h-ui.admin/style.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js")
	    	 ->addJs("js/static/h-ui.admin/H-ui.admin.js")
	    	 ->addJs("lib/datatables/1.10.0/jquery.dataTables.min.js")
	    	 ->addJs("lib/laypage/1.2/laypage.js");

    	$this->view->pick("admin/product/prosn");
    }
    /**
     * 添加产品服务说明页面
     */
    public function prosnAddPageAction(){
    	$this->assets
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
	    	 ->addCss("css/static/h-ui.admin/style.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js")
	    	 ->addJs("js/static/h-ui.admin/H-ui.admin.js")
	    	 ->addJs("lib/datatables/1.10.0/jquery.dataTables.min.js")
	    	 ->addJs("lib/laypage/1.2/laypage.js");

	    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	    $sninfo = array('id'=>'','title'=>'','descript'=>'','sort'=>'0');
	    if ($id){
	    	$sn = ServiceNote::findFirstById($id);
	    	if ($sn) $sninfo = $sn->toArray();
	    }
	    $this->view->sninfo= $sninfo;
    	$this->view->pick("admin/product/prosnAdd");
    }
    /**
     * 获取产品服务说明列表
     */
    public function prosnListAction(){
    	$shopId = $this->session->get('sid');
    	$sns = ServiceNote::find("shop_id=$shopId and status='S1' order by sort desc");

    	$snArr = array();
    	if ($sns) $snArr= $sns->toArray();

    	$result = array();
    	for($i=0; $i<count($snArr); ++$i){
    		array_push($result, array(
    				'edit'		=> '<a href="#" onclick="prosnAdd(\'添加服务说明\',\'../Product/prosnAddPage?id='.$snArr[$i]['id'].'\',\'600\',\'350\')">编辑</a> | <a href="#" onclick="prosnDel(this,'.$snArr[$i]['id'].')">删除</a>',
    				'title'		=> $snArr[$i]['title'],
    				'descript'	=> $snArr[$i]['descript'],
    				'status'	=> $snArr[$i]['status']
    		));
    	}

    	echo json_encode(array('data'=>$result));
    }
    public function prosnList($type='pro', $data){
    	if ($type == 'shopid'){
    		$sns = ServiceNote::find("shop_id=$data and status='S1' order by sort desc");
    	}else {
    		$sns = ServiceNote::find("id in($data) and status='S1' order by sort desc");
    	}

    	$snArr = array();
    	if ($sns) $snArr= $sns->toArray();

    	return $snArr;
    }
    /**
     * 编辑产品服务说明
     */
    public function saveProsnAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    		$title = isset($_POST['title']) ? $_POST['title'] : '';
    		$descript = isset($_POST['descript']) ? $_POST['descript'] : '';
    		$sort = isset($_POST['sort']) ? intval($_POST['sort']) : 0;

    		if (!$title || !$descript){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误'));exit();
    		}

    		if ($id){
    			$sn = ServiceNote::findFirstById($id);
    			if ($sn&& count($sn)){
    				if ($sn->shop_id != $this->session->get("sid")){
    					echo json_encode(array('status'=>0, 'err'=>'权限不够'));exit();
    				}
    			}else {
    				echo json_encode(array('status'=>0, 'err'=>'不存在'));exit();
    			}
    		}else {
    			$sn= new ServiceNote();
    			$sn->shop_id = $this->session->get("sid");
    		}

    		$sn->title = $title;
    		$sn->descript = $descript;
    		$sn->sort = $sort;

    		if ($sn->save()) echo json_encode(array('status'=>1, 'msg'=>'success'));
    		else echo json_encode(array('status'=>0, 'err'=>'操作失败'));
    	}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误'));
    }
    /**
     * 删除产品服务说明
     */
    public function delProsnAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    		if (!$id){
    			echo json_encode(array('status'=>0, 'err'=>'数据错误')); exit();
    		}

    		$sn = ServiceNote::findFirstById($id);
    		if ($sn&& count($sn)){
    			if ($sn->shop_id != $this->session->get("sid")){
    				echo json_encode(array('status'=>0, 'err'=>'权限不够'));exit();
    			}
    			$sn->status = 'S0';
    			if ($sn->save()) echo json_encode(array('status'=>1, 'msg'=>'success'));
    			else echo json_encode(array('status'=>0, 'err'=>'操作失败'));
    		}else {
    			echo json_encode(array('status'=>0, 'err'=>'不存在'));exit();
    		}
    	}
    }

    /**
     * 后台异步获取商品参数格式
     * @return [json]
     */
    public function ajaxGetParmsAction(){
        if($this->request->isPost()){
            $cat_id = (isset($_POST['cid']) && $_POST['cid'])? $_POST['cid']:0;
            if($cat_id){
                $cg = Category::findFirstById($cat_id);
                if($cg->parm_id > 0){
                    $new_array = array();
                    $this->getProParms($cg, $new_array);
                    echo json_encode(array('status'=>1, 'data'=>$new_array, 'msg'=>'success'));exit();
                }else{
                    echo json_encode(array('status'=>1, 'data'=>array(),'msg'=>'success'));exit();
                }
            }else{
                echo json_encode(array('status'=>0, 'msg'=>'参数错误'));exit();
            }
        }else{
            echo json_encode(array('status'=>0, 'msg'=>'请求方法错误!'));exit();
        }
    }

    /**
     * 获取商品参数格式
     * @param  [mix] $cg         [商品分类结果集]
     * @param  [array] &$new_array [结果]
     * @return [null]
     */
    public function getProParms($cg, &$new_array){
        $parm_data = $cg->ProductParm->toArray();

        if($parm_data['disabled'] == 0){
            $parm_value_data = ProductParmValue::find("id in ({$parm_data['vid']})")->toArray();

            $parm_value_keys = array_column($parm_value_data, 'id');
            $parm_data['vid'] = explode(',', $parm_data['vid']);
            foreach ($parm_data['vid'] as $k => $v) {
                $key = array_search($v, $parm_value_keys);
                if($parm_value_data[$key]['type']=='select'){
                    $parm_value_data[$key]['value'] = json_decode($parm_value_data[$key]['value']);
                }
                array_push($new_array, $parm_value_data[$key]);
            }
        }
    }

    /**
     * 商品上下架
     */
    public function soldOutInAction(){
    	if ($this->request->isPost()){
    		$ids = isset($_POST['ids']) ? trim($_POST['ids'], ',') : '';
    		$status = isset($_POST['status']) ? intval($_POST['status']) : 0;
    		$status = $status==0 ? 1 : 0;
    		$result = Product::soldOutIn($ids, $this->session->get('sid'), $status);


    		if ($result == 'SUCCESS') $this->msg('success');
    		else if($result == 'DATAERR') $this->err('数据错误');
    		else if($result == 'OPEFILE') $this->err('操作失败');
    		else if($result == 'DATAEXCEPTION') $this->err('数据异常');
    	}else $this->err('请求方式错误');
    }


    //----------
    // 导入产品
    //----------
    /**
     * 上传excel文件
     */
    public function subProExcelAction(){
    	if ($this->request->isPost()){
    		$eftype = isset($_POST['eftype']) ? $_POST['eftype'] : '1';

    		$filePath = 'improt_pro/'.date('Ymd');

    		//上传excel文件
    		$pei = new FileUpload($this->request, UPLOAD_FILE.$filePath, array('cvs','xls','xlsx'), 5*1024*1024);
    		$pei->uploadfile();
    		$seiName = '';
    		if(!$pei->errState()){
    			$seiName = $filePath.'/'.$pei->getFileNames()['efile'];
    		}else{ $this->err($pei->errInfo()); exit(); }//文件上传失败

    		$result = TaskQueue::addTaskQueue(array(
    				'sid'=>$this->session->get('sid'), 'admin'=>$this->session->get('uid'),
    				'name'=>'产品导入', 'params'=>$seiName, 'ttype'=>'T1',
    				'remark'=>date('Y-m-d').'导入商品', 'level'=>8,
    		));
    		if ($result == true) $this->msg('success');
    		else if ($result=='DATAERR') $this->err('数据异常');
    		else if ($result=='OPEFILE') $this->err('操作失败');
    	}else $this->err('请求方式错误');
    }
}

