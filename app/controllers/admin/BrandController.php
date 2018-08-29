<?php

/**
 * 品牌管理
 * @author xiao
 *
 */
class BrandController extends AdminBase{

    public function indexAction(){
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
    	
	    $this->view->brandLists = $this->brandListAction();
    	
    	$this->view->pick("admin/brand/index");
    }
    
    /**
     * 添加品牌页面
     */
    public function addBrandPageAction(){
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
    	
	    $bid = isset($_GET['bid']) ? intval($_GET['bid']) : '';
	    $this->view->brandInfo = $this->brandInfoAction($bid);
	    $this->view->bid = $bid;
    	
    	$this->view->pick("admin/brand/add");
    }
    
    /**
     * 获取所有品牌
     */
    public function brandListAction(){
    	$brandArr = array();
    	$brands = Brand::find(array(
    			'conditions'=> "shop_id=?1 and status=?2",
    			'bind'		=> array(1=>$this->session->get('sid'), 2=>'S1')
    	));
    	
    	if ($brands) $brandArr = $brands->toArray();
    	
    	return $brandArr;
    }
    
    /**
     * 品牌推荐设置
     */
    public function barndTjAction(){
    	if ($this->request->isPost()){
    		$id = (isset($_POST['id'])&&intval($_POST['id'])) ? intval($_POST['id']) : '';
    		$type = isset($_POST['type']) ? intval($_POST['type']) : 0;
    		
    		if (!$id){
    			echo json_encode(array('status'=>0, 'msg'=>'数据错误!'));
    			exit();
    		}
    		
    		$brand = Brand::findFirstById($id);
    		if ($brand){
    			$brand->type = $type;
    			if ($brand->save()) echo json_encode(array('status'=>1, 'msg'=>'success'));
    			else echo json_encode(array('status'=>0, 'msg'=>'操作失败!'));
    		}else echo json_encode(array('status'=>0, 'msg'=>'品牌不存在!'));
    	}
    }
    
    /**
     * 获取品牌信息
     */
    public function brandInfoAction($bid=0){
    	$binfoArr = array(
    			'id'=>'', 'name'=>'', 'file'=>''
    	);
    	
    	$brand = Brand::findFirstById($bid);
    	
    	if ($brand) $binfoArr = $brand->toArray();
    	return $binfoArr;
    }
    
    /**
     * 保存品牌
     */
    public function saveBrandAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['bid']) ? intval($_POST['bid']) : '';
    		if ($id){
    			$brand = Brand::findFirstById($id);
    		}else {
    			$brand= new Brand();
    			$brand->addtime = time();
    			$brand->status = 'S1';
    			$brand->type = 0;
    		}
    		
    		$brand->name = $_POST['name'];
    		$brand->shop_id = $this->session->get('sid');
    		
    		//上传广告图片
    		if (!empty($_FILES["file"]["tmp_name"])) {
    			//文件上传
    			$info = $this->upload_images($_FILES["file"],'brand/'.date('Ymd').'/', array('jpg','png','jpeg'));
    			if(!is_array($info)) {// 上传错误提示错误信息
    				$this->error($info);
    			}else{// 上传成功 获取上传文件信息
    				if ($id) { //删除原有图片
    					$check_url = $brand->photo;
    					$url = UPLOAD_FILE.$check_url;
    					if (file_exists($url) && $check_url) {
    						@unlink($url);
    					}
    				}
    				
    				$brand->photo = $info['savepath'].$info['savename'];
    			}
    		}
    		
    		$result = $brand->save();
    		
    		if ($result){
    			if ($id){
    				echo "<script> window.location.href='../Brand/index'; </script>";
    			}else{
    				echo "<!doctype html><html lang='en'><head><meta charset='UTF-8'></head><body style='background-color:#fff'><div style='width:200px;height:100px;background:#000;border:1px solid #f3f3f3;border-radius:5px;position:absolute;left:50%;top:50%;margin:-50px -100px;'><div style='width:100%;height:50px;color:#fff;font-size:16px;line-height:40px;padding-left:30px;'>添加成功!</div><button id='btn' style='width:70px;height:30px;background:#000;color:#fff;font-size:16px;margin:5px 65px;border:1px solid #f3f3f3;border-radius:5px;'>确定</button></div></body></html><script>function jump(){ window.location.href='../Brand/addBrandPage?bid={$id}'; }window.setTimeout('jump()', 1000);var i=5;var btn = document.getElementById('btn'); btn.onclick = function(){ jump(); } </script>";
    			}
    		}else {
    			echo "<!doctype html><html lang='en'><head><meta charset='UTF-8'></head><body style='background-color:#fff'><div style='width:200px;height:100px;background:#000;border:1px solid #f3f3f3;border-radius:5px;position:absolute;left:50%;top:50%;margin:-50px -100px;'><div style='width:100%;height:50px;color:#fff;font-size:16px;line-height:40px;padding-left:30px;'>操作成功!</div><button id='btn' style='width:70px;height:30px;background:#000;color:#fff;font-size:16px;margin:5px 65px;border:1px solid #f3f3f3;border-radius:5px;'>确定</button></div></body></html><script>function jump(){ window.location.href='../Brand/addBrandPage?bid={$id}'; }window.setTimeout('jump()', 1000);var i=5;var btn = document.getElementById('btn'); btn.onclick = function(){ jump(); } </script>";
    		}
    	}
    }
    
    /**
     * 删除品牌
     */
    public function delBrandAction(){
    	if ($this->request->isPost()){
    		$bid = isset($_POST['bid']) ? intval($_POST['bid']) : '';
    		
    		if ($bid){
    			$brand = Brand::findFirstById($bid);
    			if ($brand->delete()) echo json_encode(array('status'=>1, 'msg'=>'success'));
    			else echo json_encode(array('status'=>0, 'msg'=>'删除失败!'));
    		}else echo json_encode(array('status'=>0, 'msg'=>'数据错误!'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误!'));
    	
    }

}

