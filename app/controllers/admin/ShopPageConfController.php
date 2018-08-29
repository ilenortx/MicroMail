<?php

/**
 * 店铺页面配置
 * @author xiao
 *
 */
class ShopPageConfController extends AdminBase{

	/**
	 * 热卖推荐
	 */
	public function hotselltjPageAction(){
		$this->assets
			 ->addCss("css/static/h-ui/H-ui.min.css")
			 ->addCss("css/static/h-ui.admin/H-ui.admin.css")
			 ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
			 ->addCss("css/static/h-ui.admin/style.css")
			 ->addJs("lib/jquery/1.9.1/jquery.min.js")
			 ->addJs("lib/layer/layer.js")
			 ->addJs("js/static/h-ui/H-ui.min.js")
			 ->addJs("js/static/h-ui.admin/H-ui.admin.js")
			 ->addJs("lib/laypage/1.2/laypage.js");
		
		
		$this->view->hstconf = $this->aaconfInfo($this->session->get("sid"));
		$this->view->pick("admin/shopPageConf/hotselltj");
	}
	/**
	 * 获取信息
	 */
	public function aaconfInfo($sid){
		$info = array(
				'id'=>'', 'shop_id'=>'', 'zphoto'=>'', 'zproid'=>'',
				'rtphoto'=>'', 'rtproid'=>'', 'rbphoto'=>'', 'rbproid'=>'',
		);
		
		$aai = SyHotsellTj::findFirstByShopId($sid);
		if ($aai && count($aai)) {
			$info = $aai->toArray();
		}
		
		return $info;
	}
	
	/**
	 * 编辑热卖推荐
	 */
	public function hstEditAction(){
		if ($this->request->isPost()){
			$id = isset($_POST['id']) ? intval($_POST['id']) : '';
			$zproid = isset($_POST['zproid']) ? $_POST['zproid'] : '';
			$rtproid = isset($_POST['rtproid']) ? $_POST['rtproid'] : '';
			$rbproid = isset($_POST['rbproid']) ? $_POST['rbproid'] : '';
			
			if (!$zproid || !$rtproid || !$rbproid){
				echo json_encode(array('status'=>0, 'err'=>'数据错误')); exit();
			}
			
			if (!$id && (empty($_FILES["photo_l"]["tmp_name"])||
				empty($_FILES["photo_rt"]["tmp_name"])||empty($_FILES["photo_rb"]["tmp_name"]))) {
				echo json_encode(array('status'=>0, 'err'=>'请上传相关图片')); exit();
			}
			if ($id){
				$hst = SyHotsellTj::findFirstById($id);
				if (!$hst|| !count($hst)){
					echo json_encode(array('status'=>0, 'err'=>'数据异常')); exit();
				}
			}else{
				$hst= new SyHotsellTj();
			}
			
			//上传图片
			if (!empty($_FILES["photo_l"]["tmp_name"])){
				if ($id && !empty($aai->zphoto)){
					$img_url = UPLOAD_FILE.$aai->zphoto;
					if(file_exists($img_url)) { @unlink($img_url); }
				}
				$info = $this->upload_images($_FILES["photo_l"], "syhst/".date('Ymd').'/', array('jpg','png','jpeg','gif'));
				if(!is_array($info)) {
					echo json_encode(array('status'=>0, 'err'=>'图片上传失败')); exit();
				}else $hst->zphoto = $info['savepath'].$info['savename'];
			}
			if (!empty($_FILES["photo_rt"]["tmp_name"])){
				if ($id && !empty($aai->zphoto)){
					$img_url = UPLOAD_FILE.$hst->rtphoto;
					if(file_exists($img_url)) { @unlink($img_url); }
				}
				$info = $this->upload_images($_FILES["photo_rt"], "syhst/".date('Ymd').'/', array('jpg','png','jpeg','gif'));
				if(!is_array($info)) {
					$img_url = UPLOAD_FILE.$hst->zphoto;
					if(file_exists($img_url)) { @unlink($img_url); }
					echo json_encode(array('status'=>0, 'err'=>'图片上传失败')); exit();
				}else $hst->rtphoto = $info['savepath'].$info['savename'];
			}
			if (!empty($_FILES["photo_rb"]["tmp_name"])){
				if ($id && !empty($hst->zphoto)){
					$img_url = UPLOAD_FILE.$hst->rbphoto;
					if(file_exists($img_url)) { @unlink($img_url); }
				}
				$info = $this->upload_images($_FILES["photo_rb"], "syhst/".date('Ymd').'/', array('jpg','png','jpeg','gif'));
				if(!is_array($info)) {
					$img_url = UPLOAD_FILE.$hst->zphoto;
					if(file_exists($img_url)) { @unlink($img_url); }
					$img_url = UPLOAD_FILE.$hst->rtphoto;
					if(file_exists($img_url)) { @unlink($img_url); }
					echo json_encode(array('status'=>0, 'err'=>'图片上传失败')); exit();
				}else $hst->rbphoto = $info['savepath'].$info['savename'];
			}
			
			$hst->shop_id = $this->session->get('sid');
			$hst->zproid = $zproid;
			$hst->rtproid = $rtproid;
			$hst->rbproid = $rbproid;
			
			if ($hst->save()) echo json_encode(array('status'=>1, 'msg'=>'success', 'id'=>$hst->id));
			else echo json_encode(array('status'=>0, 'err'=>'操作失败')); exit();
					
		}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误')); exit();
	}
	
}

