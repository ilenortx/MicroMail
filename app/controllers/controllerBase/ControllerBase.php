<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller{

	/**
	 * 获取config
	 */
	public function getConfig(){
		$config = include APP_PATH . '/config/config.php';
		return $config;
	}

	/**
	 * 二维数组排序
	 * @param array $arr 需要排序的二维数组
	 * @param string $keys 所根据排序的key
	 * @param string $type 排序类型，desc、asc
	 * @return array $new_array 排好序的结果
	 */
	public function arraySort($arr, $keys, $type = 'desc'){
		$key_value = $new_array = array();
		foreach ($arr as $k => $v) {
			$key_value[$k] = $v[$keys];
		}
		if ($type == 'asc') {
			asort($key_value);
		} else {
			arsort($key_value);
		}
		reset($key_value);
		foreach ($key_value as $k => $v) {
			$new_array[$k] = $arr[$k];
		}
		return $new_array;
	}

	/*
	 *
	 * 图片上传的公共方法
	 *  $file 文件数据流 $exts 文件类型 $path 子目录名称
	 */
	public function upload_images($file, $path, $exts){
		include_once APP_PATH.'/library/UploadFile.php';
		$upload = new UploadFile(true, $path, $exts);
		$upload->upload_file($file);

		return $upload->get_msg();
	}

	/**
	 * 文件上传
	 */
	public function uploadFile($file, $path, $exts){
		include_once APP_PATH.'/library/UploadFile.php';
		$upload = new UploadFile(true, $path, $exts);
		$upload->upload_file($file);

		return $upload->get_msg();
	}

	//**************************
	//原作者自己封装的分页功能
	//js写法，直接复制
	//function product_option(page){
	//  window.location.href='?page='+page+'&message='+$("#message").val()
	//}
	//**************************
	public function pageIndex($count,$row_page,$page){
		$pare= $page>0 ? '<a onclick="product_option('.($page-1).');">上一页</a>' : '<span>上一页</span>';
		$next= $row_page-1>$page ?  '<a onclick="product_option('.($page+1).');">下一页</a>' : '<span>下一页</span>';

		$text='<span style="color:#666">
		        共 '.$count.' 条&nbsp;&nbsp;&nbsp;
				总页数:'.$row_page.'&nbsp;&nbsp;&nbsp;
				当前页:'.($page+1).'&nbsp;&nbsp;
			   </span>
			   '.$pare.$next.'&nbsp;&nbsp;
			   <select onchange="product_option(this.value)">';

		for($i=0; $i<$row_page; $i++){
			$page==$i ? $select='selected="selected"' : $select='' ;
			$text.='<option value="'.$i.'" '.$select.'>'.($i+1).'</option>';
		}

		$text.'</select>';
		return $text;
	}

	/**
	 * 发送GET请求的方法
	 * @param string $url URL
	 * @param bool $ssl 是否为https协议
	 * @return string 响应主体Content
	 */
	protected function requestGet($url, $ssl=true) {
		// curl完成
		$curl = curl_init();

		//设置curl选项
		curl_setopt($curl, CURLOPT_URL, $url);//URL
		$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';
		curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);//user_agent，请求代理信息
		curl_setopt($curl, CURLOPT_AUTOREFERER, true);//referer头，请求来源
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间

		//SSL相关
		if ($ssl) {
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁用后cURL将终止从服务端进行验证
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//检查服务器SSL证书中是否存在一个公用名(common name)。
		}
		curl_setopt($curl, CURLOPT_HEADER, false);//是否处理响应头
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//curl_exec()是否返回响应结果

		// 发出请求
		$response = curl_exec($curl);
		if (false === $response) {
			echo '<br>', curl_error($curl), '<br>';
			return false;
		}
		curl_close($curl);
		return $response;
	}

	/**
	 * 发送POST请求的方法
	 * @param string $url URL
	 * @param bool $ssl 是否为https协议
	 * @return string 响应主体Content
	 */
	protected function _requestPost($url, $data, $ssl=true) {
		//curl完成
		$curl = curl_init();
		//设置curl选项
		curl_setopt($curl, CURLOPT_URL, $url);//URL
		$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';
		curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);//user_agent，请求代理信息
		curl_setopt($curl, CURLOPT_AUTOREFERER, true);//referer头，请求来源
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间
		//SSL相关
		if ($ssl) {
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁用后cURL将终止从服务端进行验证
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//检查服务器SSL证书中是否存在一个公用名(common name)。
		}
		// 处理post相关选项
		curl_setopt($curl, CURLOPT_POST, true);// 是否为POST请求
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);// 处理请求数据
		// 处理响应结果
		curl_setopt($curl, CURLOPT_HEADER, false);//是否处理响应头
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//curl_exec()是否返回响应结果

		// 发出请求
		$response = curl_exec($curl);
		if (false === $response) {
			echo '<br>', curl_error($curl), '<br>';
			return false;
		}
		curl_close($curl);
		return $response;
	}


	/**
	 * http请求
	 * @param unknown $url
	 * @param unknown $data
	 * @return mixed
	 */
	protected function httpsRequest($url, $data = null){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if(!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}


	/**
	 * 判断是否单个文件上传
	 * @param string $fName
	 * @return boolean
	 */
	protected function upFileVerify($fName=''){
		if (!empty($_FILES[$fName]["tmp_name"])) return true;
		else return false;
	}

	/**
	 * 重定向跳转
	 */
	protected function redirect($url){
		return $this->response->redirect($url);
	}

	/**
	 * 结果返回
	 * @param number $status
	 * @param string $msg
	 * @param unknown $datas
	 */
	protected function result($status=0, $msg='', $datas=null){
		echo json_encode(array('status'=>$status, 'msg'=>$msg, 'datas'=>$datas));
	}

	/**
	 * 成功返回
	 * @param unknown $datas
	 */
	protected function success($datas=null){

	}

	/**
	 * 错误信息
	 * @param string $err
	 */
	protected function err($err=''){
		echo json_encode(array('status'=>0, 'err'=>$err));
	}

	/**
	 * 消息提示
	 * @param string $msg
	 */
	protected function msg($msg=''){
		echo json_encode(array('status'=>1, 'msg'=>$msg));
	}

	/**
	 * table数据
	 * @param number $code
	 * @param string $msg
	 * @param array $datas
	 * @param string $paging
	 */
	protected function tableData($datas=array(), $code=0, $msg='seccess', $paging=false){
		$tableData = $datas;

		if ($paging && is_array($paging) && isset($paging['page']) && isset($paging['limit'])){
			$tableData = array_slice($datas, ($paging['page']-1)*$paging['limit'], $paging['limit']);
		}

		echo json_encode(array("code"=>$code,"msg"=>$msg,"count"=>count($datas),"data"=>$tableData));
	}
	protected function tableData1($count=0, $datas=array(), $code=0, $msg='seccess'){
		echo json_encode(array("code"=>$code,"msg"=>$msg,"count"=>$count,"data"=>$datas));
	}

	/**
	 * 上传保存base64图片
	 * @param  string $base64
	 * @param  string $path
	 * @param  string $fileName
	 * @return bool
	 */
	public function uploadBase64($base64, $path, $fileName){
		$base64_body = substr(strstr($base64,','),1);
		$img = base64_decode($base64_body);
		$dir_path = UPLOAD_FILE.$path;

		if(!file_exists($dir_path)){
			mkdir($dir_path,0777,true);
		}
		$file_path = $path.'/'.$fileName.'_'.time().".png";
		if(file_put_contents($dir_path.'/'.$fileName.'_'.time().".png", $img)){
			$return_data = array(
				'path'=>$file_path,
				'url'=>$_SERVER['HTTP_ORIGIN'].'/files/uploadFiles/'.$file_path,
			);
			return $return_data;
		}else{
			return false;
		}
	}

	/**
	 * 判断是否是微信浏览器
	 * @return boolean
	 */
	protected function isWeixin() {
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
			return true;
		} return false;
	}
	/**
	 * 判断是否是微信小程序浏览器
	 * @return boolean
	 */
	protected function isWxMiniProgram(){
		if ($this->isWeixin()){
			if (strpos($_SERVER['HTTP_USER_AGENT'], 'miniprogram') !== false) {
				return true;
			} return false;
		}else return false;
	}
	
	/**
	 * 保留两位有效数字
	 */
	protected function numberFormat($num=0, $decimal=2){
		return number_format($num, $decimal);
	}
	
	/**
	 * 服务器系统类型获取
	 */
	protected static function systype(){
		return strtoupper(substr(PHP_OS,0,3))==='WIN'?'win':'linux';
	}
	
}
