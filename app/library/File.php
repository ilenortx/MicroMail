<?php

/**
 * 文件类封装
 * @author xiao
 *
 */
class File{
	
	protected $auto_mkdir = true;	// 是否自动创建目录
	protected $filePath;			// 文件上传路径
	protected $fileSize;			// 上传文件最大尺寸
	protected $fileType;			// 上传文件的格式限制
	protected $file;				// file文件对象
	protected $errorInfo;			// 错误信息
	protected $errorState = false;	// 错误状态,默认无错误
	
	/**
	 * 生成文件名规则
	 * @return string
	 */
	protected function setFileName(){
		return date('YmdHis') . uniqid() . '.' . $this->file->getExtension();
	}
	
	/**
	 * 检查并创建目录
	 * @return bool
	 */
	protected function checkDir(){
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
	}
	
	/**
	 * 检测上传文件的大小
	 * @return bool
	 */
	protected function checkSize(){
		if(!$this->errorState){
			if($this->file->getSize() > $this->fileSize){
				$this->errorState = true;
				$this->errorInfo[] = '上传文件过大';
			}
		}
	}
	
	/**
	 * 递归创建目录
	 * @param $dir
	 * @return bool
	 */
	protected function mkdir($dir){
		if(!is_dir($dir)){
			if(!$this->mkdir(dirname($dir))){
				return false;
			}
			if(!mkdir($dir, 0777)){
				return false;
			}
		}
		return true;
	}
	
	/**
	 * 检查上传文件类型
	 * @return bool
	 */
	protected function checkType(){
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
	}
	
	/**
	 * 返回错误信息
	 * @return mixed
	 */
	public function errInfo(){
		return $this->errorInfo;
	}
	
	/**
	 * 返回错误状态
	 * @return bool
	 */
	public function errState(){
		return $this->errorState;
	}
	
	
}