<?php

/**
 * 疑难问题
 * @author xiao
 *
 */
class ServiceCenterController extends AdminBase{

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

	    $scs = ServiceCenter::find(array(
	    		'conditions'=> "id>0",
	    		'order'		=> "status desc"
	    ));
	    $scArr = $scs ? $scs->toArray() : array();
	    $this->view->scArr = $scArr;
    	
    	$this->view->pick("admin/serviceCenter/index");
    }
    
    public function editPageAction(){
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
    	
    	$this->view->scInfo = $this->getDetailAction();
    	
    	$this->view->pick("admin/serviceCenter/edit");
    }
    
    /**
     * 获取疑难详情
     */
    public function getDetailAction(){
    	$scId = (isset($_GET['scid'])&&intval($_GET['scid'])) ? intval($_GET['scid']) : 0;
    	
    	$scInfo = array('name'=>'','content'=>'', 'status'=>'', 'id'=>'');
    	if ($scId){
    		$sc = ServiceCenter::findFirstById($scId);
    		if ($sc) $scInfo = $sc->toArray();
    	}
    	
    	return $scInfo;
    }

    /**
     * 修改状态
     */
    public function setStatusAction(){
    	if ($this->request->isPost()){
    		$id = (isset($_POST['id'])&&intval($_POST['id'])) ? intval($_POST['id']) : 0;
    		$status = isset($_POST['id']) ? $_POST['id'] : 'S0';
    		
    		if (!$id || !$status){
    			echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    			exit();
    		}
    		
    		$sc = ServiceCenter::findFirstById($id);
    		
    		if ($sc){
    			$sc->status = $status;
    			if ($sc->save()){
    				echo json_encode(array('status'=>1, 'msg'=>'success'));
    			}else echo json_encode(array('status'=>0, 'msg'=>'操作失败'));
    		}else echo json_encode(array('status'=>0, 'msg'=>'记录不存在'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }
    
    /**
     * 保存信息
     */
    public function saveScAction(){
    	if ($this->request->isPost()){
    		$id = isset($_POST['id'])&&intval($_POST['id']) ? intval($_POST['id']) : '';
    		$name = isset($_POST['name']) ? $_POST['name'] : '';
    		$content= isset($_POST['content']) ? $_POST['content'] : '';
    		
    		if (!$name || !$content){
    			echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
    			exit();
    		}
    		
    		if ($id) $sc = ServiceCenter::findFirstById($id);
    		else {
    			$sc = new ServiceCenter();
    			$sc->status = 'S1';
    		}
    		
    		$sc->name = $name;
    		$sc->content = $content;
    		
    		if ($sc->save()){
    			echo json_encode(array('status'=>1, 'msg'=>'success', 'id'=>$sc->id));
    		}else echo json_encode(array('status'=>0, 'msg'=>'操作失败'));
    	}else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }
    
}

