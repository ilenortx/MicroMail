<?php

/**
 * 文件上传 可多文件上传
 * @author xiao
 *
 */
class FileUpload extends File{
	
	private $request;				// request控制器对象
	private $fileRealpath = array();// 上传成功后文件真实路径
	private $fileNames = array();	// 上传文件名
	
	
	public function __construct($request, $filePath, $fileType, $fileSize){
		$this->request  = $request;
		$this->filePath = $filePath;
		$this->fileSize = $fileSize;
		$this->fileType = $fileType;
	}
	
	/**
	 * 获取文件真实保存路径
	 * @return array
	 */
	public function getFileRealPath(){
		return $this->fileRealpath;
	}
	
	/**
	 * 获取文件名
	 */
	public function getFileNames(){
		return $this->fileNames;
	}
	
	/**
	 * 执行上传文件
	 * @return bool
	 */
	public function uploadfile(){
		// 检测是否有上传文件
		if ($this->request->hasFiles() == true) {
			// 获取上传文件的相关信息
			foreach ($this->request->getUploadedFiles() as $file) {
				if ($file->getSize()>0){
					$this->file = $file;
					// 检查文件大小
					$this->checkSize();
					// 检查文件类型
					$this->checkType();
					// 移动文件到指定目录
					$this->move();
				}
			}
		}else{
			$this->errorState = true;
			$this->errorInfo = '暂无上传文件';
		}
	}
	
	/**
	 * 移动文件
	 * @return bool
	 */
	private function move(){
		if(!$this->errorState){
			// 检查并创建目录
			$this->checkDir();
			// 目录路径
			$filepath = trim($this->filePath , '/') . '/';
			// 生成文件名称
			$filename = $this->setFileName();
			// 移动文件
			if(!$this->file->moveTo($filepath . $filename)){
				$this->errorState = true;
				$this->errorInfo = '上传文件失败';
			}else{
				$this->fileRealpath[] = $filepath . $filename;
				$this->fileNames[] = $filename;
			}
		}
	}
	
	/**
	 * 生成文件名规则
	 * @return string
	 */
	/* private function setFileName(){
		return date('YmdHis') . uniqid() . '.' . $this->file->getExtension();
	} */
	
	/**
	 * 检查并创建目录
	 * @return bool
	 */
	/* private function checkDir(){
		if(!$this->errorState){
			if(!is_dir($this->filePath)){
				if($this->auto_mkdir){
					if(!$this->mkdir($this->filePath)){
						$this->errorState = true;
						$this->errorInfo[] = '目录创建失败';
					}
				}else{
					$this->errorState = true;
					$this->errorInfo[] = '上传目录不存在';
				}
			}
		}
	} */
	
	/**
	 * 检测上传文件的大小
	 * @return bool
	 */
	/* private function checkSize(){
		if(!$this->errorState){
			if($this->file->getSize() > $this->fileSize){
				$this->errorState = true;
				$this->errorInfo[] = '上传文件过大';
			}
		}
	} */
	
	/**
	 * 递归创建目录
	 * @param $dir
	 * @return bool
	 */
	/* private function mkdir($dir){
		if(!is_dir($dir)){
			if(!$this->mkdir(dirname($dir))){
				return false;
			}
			if(!mkdir($dir,0777)){
				return false;
			}
		}
		return true;
	} */
	
	/**
	 * 检查上传文件类型
	 * @return bool
	 */
	/* private function checkType(){
		if(!$this->errorState){
			if(is_array($this->fileType)){
				if(!in_array($this->file->getExtension() , array_map('strtolower' , $this->fileType))){
					$this->errorState = true;
					$this->errorInfo[] = '文件类型错误';
				}
			}else if(is_string($this->fileType)){
				if(strtolower($this->file->getExtension()) != strtolower($this->fileType)){
					$this->errorState = true;
					$this->errorInfo[] = '文件类型错误';
				}
			}else{
				$this->errorState = true;
				$this->errorInfo[] = '文件类型错误';
			}
		}
	} */
	
}