<?php

class GuanggaoController extends AdminBase{

	/**
	 * 广告首页
	 */
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
    	
	    $this->view->advlist = $this->advListAction();
    	
    	$this->view->pick("admin/guanggao/advlist");
    }
    
    /**
     * 新增广告页面
     */
    public function addPageAction(){
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
	    
	    $this->view->adinfo = $this->adInfoAction();
    	
    	$this->view->pick("admin/guanggao/add");
    }
    
    /**
     * 广告编辑
     */
    public function advEidtPageAction(){
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
    	
    	$this->view->adinfo = $this->adInfoAction();
    	
    	$this->view->pick("admin/guanggao/adv_edit");
    }
    
    /**
     * 公告首页
     */
    public function noticePageAction(){
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
    	
	    $this->view->noticelist = $this->noticeListAction();
    	
    	$this->view->pick("admin/guanggao/noticelist");
    }
    
    /**
     * 新增公告页面
     */
    public function addNoticePageAction(){
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
    	
	    $notice_id = isset($_GET['notice_id']) ? intval($_GET['notice_id']) : '';
	    $this->view->noticeInfo = $this->noticeInfoAction();
    	
    	$this->view->pick("admin/guanggao/addNotice");
    }
    
    /**
     * 公告设置页面
     */
    public function noticeConfigPageAction(){
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
    	
	    $nc = NoticeConfig::findFirst();
	    $ncInfo = ($nc&&count($nc->toArray())) ? $nc->toArray() : array('bgcolor'=>'','color'=>'','speed'=>'','direction'=>'');
    	$this->view->ncInfo = $ncInfo;
    	
    	$this->view->pick("admin/guanggao/noticeConfig");
    }
    
    
    /**
     * 新增广告
     */
    public function addAdvAction(){
    	if ($this->request->isPost()){
    		if (isset($_POST['adv_id']) && intval($_POST['adv_id'])){
    			$addAdv = Guanggao::findFirstById(intval($_POST['adv_id']));
    		}else {
    			$addAdv = new Guanggao();
    			$addAdv->addtime = time();
    		}
    		
    		$addAdv->name = $_POST['name'];
    		$addAdv->sort = $_POST['sort'];
    		$addAdv->type = $_POST['type'];
    		$addAdv->action = $_POST['action'];
    		$addAdv->position = $_POST['position'];
    		
    		//上传广告图片
    		if (!empty($_FILES["file"]["tmp_name"])) {
    			//文件上传
    			$info = $this->upload_images($_FILES["file"],'adv/'.date('Ymd').'/', array('jpg','png','jpeg'));
    			if(!is_array($info)) {// 上传错误提示错误信息
    				$this->error($info);
    			}else{// 上传成功 获取上传文件信息
    				if (isset($_POST['adv_id']) && intval($_POST['adv_id'])) { //删除原有图片
    					$check_url = $addAdv->photo;
    					$url = UPLOAD_FILE.$check_url;
    					if (file_exists($url) && $check_url) {
    						@unlink($url);
    					}
    				}
    				
    				$addAdv->photo = $info['savepath'].$info['savename'];
    			}
    		}
    		
    		$result = $addAdv->save();
    		
    		if ($result){
    			if (isset($_POST['adv_id']) && intval($_POST['adv_id']))
    				echo "<!doctype html><html lang='en'><head><meta charset='UTF-8'></head><body style='background-color:#fff'><div style='width:200px;height:100px;background:#000;border:1px solid #f3f3f3;border-radius:5px;position:absolute;left:50%;top:50%;margin:-50px -100px;'><div style='width:100%;height:50px;color:#fff;font-size:16px;line-height:40px;padding-left:30px;'>添加成功!</div><button id='btn' style='width:70px;height:30px;background:#000;color:#fff;font-size:16px;margin:5px 65px;border:1px solid #f3f3f3;border-radius:5px;'>确定</button></div></body></html><script>function jump(){ window.location.href='../Guanggao/advEidtPage?adv_id={$_POST['adv_id']}'; }window.setTimeout('jump()', 1000);var i=5;var btn = document.getElementById('btn'); btn.onclick = function(){ jump(); } </script>";
    			else
    				echo "<!doctype html><html lang='en'><head><meta charset='UTF-8'></head><body style='background-color:rgba(0,0,0,0.5)'><div style='width:200px;height:100px;background:#000;border:1px solid #f3f3f3;border-radius:5px;position:absolute;left:50%;top:50%;margin:-50px -100px;'><div style='width:100%;height:50px;color:#fff;font-size:16px;line-height:40px;padding-left:30px;'>添加成功!</div><button id='btn' style='width:70px;height:30px;background:#000;color:#fff;font-size:16px;margin:5px 65px;border:1px solid #f3f3f3;border-radius:5px;'>确定</button></div></body></html><script>function jump(){ window.location.href='../Guanggao/addPage'; }window.setTimeout('jump()', 1000);var i=5;var btn = document.getElementById('btn'); btn.onclick = function(){ jump(); } </script>";
    		}
    		else throw new \Exception('操作失败.');
    	}
    }

    /**
     * 删除广告
     */
    public function advDelAction(){
    	if ($this->request->isPost()){
    		$advId = isset($_POST['adv_id']) ? intval($this->request->getPost('adv_id')) : '';
    		
    		if ($advId){
    			$adv = Guanggao::findFirstById($advId);
    			
    			if ($adv){
    				$check_url = $adv->photo;
    				$url = UPLOAD_FILE.$check_url;
    				if (file_exists($url) && $check_url) {
    					@unlink($url);
    				}
    				
    				if ($adv->delete()) echo json_encode(array('status'=>1, 'msg'=>'success'));
    				else echo json_encode(array('status'=>0, 'msg'=>'删除失败!'));
    			}else echo json_encode(array('status'=>0, 'msg'=>'数据错误!'));
    		}else echo json_encode(array('status'=>0, 'msg'=>'数据错误!'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误!'));
    }
    
    /**
     * 获取广告信息
     */
    public function adInfoAction(){
    	$adinfo = array(
    			'id'=>'', 'name'=>'', 'photo'=>'', 'addtime'=>'', 'sort'=>'',
    			'type'=>'', 'action'=>'', 'position'=>''
    	);
    	
    	if (isset($_GET['adv_id']) && intval($_GET['adv_id'])){
    		$adv_id = intval($_GET['adv_id']);
    		
    		$adv_info = Guanggao::findFirstById($adv_id);
    		if (!$adv_info) {
    			$this->error('没有找到相关信息.');
    			exit();
    		}
    		
    		$adinfo = $adv_info->toArray();
    		$adinfo['photo'] = '../files/uploadFiles/'.$adinfo['photo'];
    	}
    	
    	return $adinfo;
    }

    /**
     * 获取广告列表
     */
    public function advListAction(){
    	
    	$list = Guanggao::find();
    	$adarr = array();
    	
    	if($list) $adarr = $list->toArray();
    	
    	foreach ($adarr as $k=>$v){
    		$adarr[$k]['photo'] = '../files/uploadFiles/'.$v['photo'];
    	}
    	
    	return $adarr;
    	
    }
    
    /**
     * 获取公告列表
     */
    public function noticeListAction(){
    	$list = Notice::find("status='S1'");
    	
    	$noticeArr = array();
    	if ($list) $noticeArr = $list->toArray();
    	
    	for ($i=0; $i<count($noticeArr); ++$i){
    		$noticeArr[$i]['addtime'] = date('Y-m-d H:i:s', $noticeArr[$i]['addtime']);
    	}
    	
    	return $noticeArr;
    }
    
    /**
     * 公告信息
     */
    public function noticeInfoAction(){
    	$noticeinfo= array(
    			'id'=>'', 'title'=>'', 'content'=>'', 'addtime'=>'', 'position'=>''
    	);
    	
    	if (isset($_GET['notice_id']) && intval($_GET['notice_id'])){
    		$notice_id = intval($_GET['notice_id']);
    		
    		$notice_info = Notice::findFirstById($notice_id);
    		if (!$notice_info) {
    			$this->error('没有找到相关信息.');
    			exit();
    		}
    		
    		$noticeinfo = $notice_info->toArray();
    	}
    	
    	return $noticeinfo;
    }
    
    public function addNoticeAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['notice_id']) ? intval($_POST['notice_id']) : false;
    		$title = isset($_POST['title']) ? $_POST['title'] : '';
    		$content = isset($_POST['content']) ? $_POST['content'] : '';
    		
    		if (!$title || !$content){
    			echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    			exit();
    		}
    		
    		if ($id){
    			$notice = Notice::findFirstById($id);
    			if (!$notice || !count($notice->toArray())){
    				echo json_encode(array('status'=>0, 'msg'=>'公告不存在'));
    				exit();
    			}
    		}else {
    			$notice = new Notice();
    			$notice->addtime = time();
    			$notice->status = 'S1';
    		}
    		
    		$notice->title = $title;
    		$notice->content = $content;
    		
    		if ($notice->save()){
    			if ($id) echo "<!doctype html><html lang='en'><head><meta charset='UTF-8'></head><body style='background-color:#fff'><div style='width:200px;height:100px;background:#000;border:1px solid #f3f3f3;border-radius:5px;position:absolute;left:50%;top:50%;margin:-50px -100px;'><div style='width:100%;height:50px;color:#fff;font-size:16px;line-height:40px;padding-left:30px;'>修改成功!</div><button id='btn' style='width:70px;height:30px;background:#000;color:#fff;font-size:16px;margin:5px 65px;border:1px solid #f3f3f3;border-radius:5px;'>确定</button></div></body></html><script>function jump(){ window.location.href='../Guanggao/noticePage'; }window.setTimeout('jump()', 1000);var i=5;var btn = document.getElementById('btn'); btn.onclick = function(){ jump(); } </script>";
    			else echo "<!doctype html><html lang='en'><head><meta charset='UTF-8'></head><body style='background-color:#fff'><div style='width:200px;height:100px;background:#000;border:1px solid #f3f3f3;border-radius:5px;position:absolute;left:50%;top:50%;margin:-50px -100px;'><div style='width:100%;height:50px;color:#fff;font-size:16px;line-height:40px;padding-left:30px;'>添加成功!</div><button id='btn' style='width:70px;height:30px;background:#000;color:#fff;font-size:16px;margin:5px 65px;border:1px solid #f3f3f3;border-radius:5px;'>确定</button></div></body></html><script>function jump(){ window.location.href='../Guanggao/addNoticePage?notice_id={$id}'; }window.setTimeout('jump()', 1000);var i=5;var btn = document.getElementById('btn'); btn.onclick = function(){ jump(); } </script>";
    		}else echo json_encode(array('status'=>0, 'msg'=>'操作失败'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }
    
    /**
     * 删除公告
     */
    public function noticeDelAction(){
    	if ($this->request->isPost()){
    		$noticeId = isset($_POST['notice_id']) ? intval($this->request->getPost('notice_id')) : '';
    		
    		if ($noticeId){
    			$notice = Notice::findFirstById($noticeId);
    			
    			if ($notice){
    				if ($notice->delete()) echo json_encode(array('status'=>1, 'msg'=>'success'));
    				else echo json_encode(array('status'=>0, 'msg'=>'删除失败!'));
    			}else echo json_encode(array('status'=>0, 'msg'=>'数据错误!'));
    		}else echo json_encode(array('status'=>0, 'msg'=>'数据错误!'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误!'));
    }
    
    /**
     * 公告设置
     */
    public function noticeSetAction(){
    	if ($this->request->isPost()){
    		$bgcolor = isset($_POST['bgcolor']) ? $_POST['bgcolor'] : '';
    		$color = isset($_POST['color']) ? $_POST['color'] : '';
    		$direction= isset($_POST['direction']) ? intval($_POST['direction']) : '';
    		$speed= isset($_POST['speed']) ? intval($_POST['speed']) : '';
    		
    		if ($bgcolor && $color && $direction && $speed){
    			$nc = NoticeConfig::findFirst("id=1");
    			if (!$nc || !count($nc->toArray())) $nc = new NoticeConfig();
    			$nc->bgcolor = $bgcolor;
    			$nc->color = $color;
    			$nc->speed = $speed;
    			$nc->direction = $direction;
    			
    			if ($nc->save()){
    				echo json_encode(array('status'=>1, 'msg'=>'success'));
    			}else echo json_encode(array('status'=>0, 'msg'=>'保存失败'));
    		}else echo json_encode(array('status'=>0, 'msg'=>'参数错误'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }
    
}

