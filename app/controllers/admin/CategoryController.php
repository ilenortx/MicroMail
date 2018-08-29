<?php

/**
 * 分类管理
 * @author xiao
 *
 */
class CategoryController extends AdminBase{

    public function indexAction(){

    }
    
    /**
     * 分类列表
     */
    public function cgLPageAction(){
    	$this->assets
	    	 ->collection('css1')
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css");
    	$this->assets
	    	 ->collection('css2')
	    	 ->addCss("css/static/h-ui.admin/style.css");
    	$this->assets
	    	 ->collection('js1')
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js")
	    	 ->addJs("js/static/h-ui.admin/H-ui.admin.js");
	    $this->assets
	    	 ->collection('js2')
	    	 ->addJs("lib/My97DatePicker/4.8/WdatePicker.js")
	    	 ->addJs("lib/datatables/1.10.0/jquery.dataTables.min.js")
	    	 ->addJs("lib/laypage/1.2/laypage.js");
    	
	    $this->view->categoryLists = $this->categoryListAction();
    	
    	$this->view->pick("admin/product/category");
    }
    
    /**
     * 新增分类
     */
    public function cgAPageAction(){
    	$this->assets
	    	 ->collection('css1')
	    	 ->addCss("css/static/h-ui/H-ui.min.css")
	    	 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
	    	 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css");
	    $this->assets
	    	 ->collection('css2')
	    	 ->addCss("css/static/h-ui.admin/style.css");
	    $this->assets
	    	 ->collection('js1')
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("lib/layer/layer.js")
	    	 ->addJs("js/static/h-ui/H-ui.min.js")
	    	 ->addJs("js/static/h-ui.admin/H-ui.admin.js");
	    $this->assets
	    	 ->collection('js2')
	    	 ->addJs("lib/My97DatePicker/4.8/WdatePicker.js")
	    	 ->addJs("lib/datatables/1.10.0/jquery.dataTables.min.js")
	    	 ->addJs("lib/laypage/1.2/laypage.js");
    	
	    $cgid = isset($_GET['cgid']) ? intval($_GET['cgid']) : 0;
	    
	    $this->view->cginfo = $this->cgInfoAction($cgid);
	    $this->view->categoryLists = $this->categoryListAction();
	    $this->view->edit = (isset($_GET['edit'])&&$_GET['edit']) ? true : false;
	    $this->view->imgPath = "../files/uploadFiles/";
    	
    	$this->view->pick("admin/product/add_category");
    }
    
    /**
     * 获取子级分类
     */
    public function ccategoryListAction($tid=0, $status='S1'){
    	$lists = array();
    	if ($status == 'all'){
    		$list = Category::find(array('conditions'=>'tid=?1', 'bind'=>array(1=>$tid), 'order'=>"sort desc"));
    	}else{
    		$list = Category::find(array('conditions'=>'tid=?1 and status=?2', 'bind'=>array(1=>$tid, 2=>$status), 'order'=>"sort desc"));
    	}
    	
    	
    	if ($list){
    		$lists = $list->toArray();
    	}
    	
    	return $lists;
    }
    
    /**
     * 获取子级分类(自定义)
     */
    public function ccategoryListAutoAction($arr=''){
    	$lists = array();
    	if (!empty($arr)) $list = Category::find($arr);
    	else $list = Category::find();
    	
    	
    	if ($list){
    		$lists = $list->toArray();
    	}
    	
    	return $lists;
    }
    
    /**
     * 获取所有分类，分级
     */
    public function categoryListAction(){
    	$clists = array();
    	$list = Category::find(array('conditions'=>'tid=?1 and status!=?2', 'bind'=>array(1=>0, 2=>'S0'), 'order'=>"sort desc"));
    	if ($list) {
    		$list = $list->toArray();
    		foreach ($list as $k1 => $v1) {
    			$list[$k1]['list2'] = array();
    			$list2 = Category::find(array('conditions'=>'tid=?1 and status!=?2', 'bind'=>array(1=>$v1['id'], 2=>'S0')));
    			if ($list2){
    				$list[$k1]['list2'] = $list2->toArray();
    				foreach ($list[$k1]['list2'] as $k2 => $v2) {
    					$list[$k1]['list3'] = array();
    					$list3 = Category::find(array('conditions'=>'tid=?1 and status!=?2', 'bind'=>array(1=>$v2['id'], 2=>'S0'), 'order'=>"sort desc"));
    					if ($list3){
    						$list[$k1]['list2'][$k2]['list3'] = $list3->toArray();
    					}
    				}
    			}
    		}
    		$clists = $list;
    	}
    	
    	return $clists;
    }
    
    /**
     * 获取所有分类
     */
    public function getCategorysAction(){
    	$cgs = array(); $categorys = array();
    	$list = Category::find();
    	if ($list) $cgs= $list->toArray();
    	
    	for ($i=0; $i<count($cgs); ++$i){
    		$categorys[$cgs[$i]['id']] = $cgs[$i];
    	}
    	
    	return $categorys;
    }
    
    /**
     * 获取所有分类(父类包含子类)
     */
    public function getCategorys1Action(){
    	$cgs = array(); $categorys = array();
    	$list = Category::find(array('conditions'=>'tid=?1', 'bind'=>array(1=>1), 'order'=>"sort desc"));
    	if ($list) $cgs= $list->toArray();
    	
    	for ($i=0; $i<count($cgs); ++$i){
    		$ccglist = $this->ccategoryListAction($cgs[$i]['id'], 'all');
    		$ccgs = array();
    		for ($j=0; $j<count($ccglist); ++$j){
    			$ccgs[$ccglist[$j]['id']] = $ccglist[$j];
    		}
    		$cgs[$i]['child'] = $ccgs;
    		$categorys[$cgs[$i]['id']] = $cgs[$i];
    	}
    	
    	return $categorys;
    }
    
    /**
     * 获取所有推荐
     */
    public function getcategorysTjAction(){
    	$cgs = array(); $categorys = array();
    	$list = Category::find(array('conditions'=>'tid=?1 and bz_2=?2 and status=?3', 'bind'=>array(1=>1, 2=>1, 3=>'S1'), 'order'=>"sort desc"));
    	if ($list) $cgs= $list->toArray();
    	
    	for ($i=0; $i<count($cgs); ++$i){
    		$ccglist = $this->ccategoryListAutoAction(array('conditions'=>'tid=?1 and bz_2=?2 and status=?3', 'bind'=>array(1=>$cgs[$i]['id'], 2=>1, 3=>'S1')));
    		$ccgs = array();
    		for ($j=0; $j<count($ccglist); ++$j){
    			$ccgs[$ccglist[$j]['id']] = $ccglist[$j];
    		}
    		$cgs[$i]['child'] = $ccgs;
    		$categorys[$cgs[$i]['id']] = $cgs[$i];
    	}
    	
    	return $categorys;
    }

    /**
     * 删除分类
     */
    public function deleteCategoryAction(){
    	$id = $this->request->getPost('id');
    	if (Category::findFirstById($id)->delete()) echo json_encode(array('status'=>1, 'msg'=>'操作成功!'));
    	else echo json_encode(array('status'=>0, 'msg'=>'操作失败!'));
    }
    
    /**
     * 推荐设置
     */
    public function setBz2Action(){
    	$id = $this->request->getPost('id');
    	$bz = $this->request->getPost('bz');
    	
    	$category = Category::findFirstById($id);
    	if ($category){
    		$category->bz_2= $bz;
    		if ($category->save()) echo json_encode(array('status'=>1, 'msg'=>'操作成功!'));
    		else echo json_encode(array('status'=>0, 'msg'=>'操作失败!'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'操作失败!'));
    }
    
    /**
     * 获取分类信息
     */
    public function cgInfoAction($cgid){
    	$cgi = Category::findFirstById($cgid);
    	
    	$cgiArr = array(
    			'id'=>'','tid'=>'','name'=>'', 'bz_1'=>'','concent'=>'','sort'=>''
    	);
    	if ($cgi) $cgiArr = $cgi->toArray();
    	
    	return $cgiArr;
    }
    
    /**
     * 保存分类
     */
    public function saveAction(){
    	if ($this->request->isPost()){
    		$cid = (isset($_POST['cid'])&&intval($_POST['cid'])) ? intval($_POST['cid']) : 0;
    		if ($cid) $cg = Category::findFirstById($cid);
    		else {
    			$cg = new Category();
    			$cg->addtime = time();
    		}
    		
    		$cg->tid = intval($_POST['tid']);
    		$cg->name = $_POST['name'];
    		$cg->concent = $_POST['concent'];
    		$cg->sort = $_POST['sort'];
    		
    		//上传广告图片
    		if (!empty($_FILES["file"]["tmp_name"])) {
    			//文件上传
    			$info = $this->upload_images($_FILES["file"],'category/'.date('Ymd').'/', array('jpg','png','jpeg'));
    			if(!is_array($info)) {// 上传错误提示错误信息
    				$this->error($info);
    			}else{// 上传成功 获取上传文件信息
    				if (isset($_POST['cid']) && intval($_POST['cid'])) { //删除原有图片
    					$check_url = $cg->bz_1;
    					$url = UPLOAD_FILE.$check_url;
    					if (file_exists($url) && $check_url) {
    						@unlink($url);
    					}
    				}
    				
    				$cg->bz_1 = $info['savepath'].$info['savename'];
    			}
    		}
    		
    		if ($cg->save()){
    			if ($cid) echo "<script> window.location.href='../Category/cgLPage'; </script>";
    			else echo "<!doctype html><html lang='en'><head><meta charset='UTF-8'></head><body style='background-color:#fff'><div style='width:200px;height:100px;background:#000;border:1px solid #f3f3f3;border-radius:5px;position:absolute;left:50%;top:50%;margin:-50px -100px;'><div style='width:100%;height:50px;color:#fff;font-size:16px;line-height:40px;padding-left:30px;'>添加成功!</div><button id='btn' style='width:70px;height:30px;background:#000;color:#fff;font-size:16px;margin:5px 65px;border:1px solid #f3f3f3;border-radius:5px;'>确定</button></div></body></html><script>function jump(){ window.location.href='../Category/cgAPage'; }window.setTimeout('jump()', 1000);var i=5;var btn = document.getElementById('btn'); btn.onclick = function(){ jump(); } </script>";
    		}else {
    			echo "<!doctype html><html lang='en'><head><meta charset='UTF-8'></head><body style='background-color:#fff'><div style='width:200px;height:100px;background:#000;border:1px solid #f3f3f3;border-radius:5px;position:absolute;left:50%;top:50%;margin:-50px -100px;'><div style='width:100%;height:50px;color:#fff;font-size:16px;line-height:40px;padding-left:30px;'>添加成功!</div><button id='btn' style='width:70px;height:30px;background:#000;color:#fff;font-size:16px;margin:5px 65px;border:1px solid #f3f3f3;border-radius:5px;'>确定</button></div></body></html><script>function jump(){ window.location.href='../Category/cgLPage?cid={$cid}'; }window.setTimeout('jump()', 1000);var i=5;var btn = document.getElementById('btn'); btn.onclick = function(){ jump(); } </script>";
    		}
    			
    	}
    	
    	
    	
    }
    
}

