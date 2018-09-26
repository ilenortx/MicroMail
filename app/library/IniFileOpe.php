<?php

class IniFileOpe extends ControllerBase{
	
	/**
	 * 获得数据
	 * @param unknown $path
	 * @param string $sections
	 * @return array|array|boolean
	 */
	public static function getIniFile($path, $sections='', $processSections=true){
		if (is_file($path)){
			
			if (!empty($sections)){
				$data = parse_ini_file($path, $processSections);
				if (isset($data[$sections])) $data = $data[$sections];
				else return array();
			}else {
				$data = parse_ini_file($path, $processSections);
			}
			
			return $data;
		}else return false;
	}
	
	/**
	 * 保存ini文件
	 * @param unknown $assocArr
	 * @param unknown $path
	 * @param string $hasSections
	 * @return boolean
	 */
	public static function writeIniFile($assocArr, $path, $hasSections=FALSE){
		$content = "";
		
		if ($hasSections){
			foreach ($assocArr as $key=>$elem){
				$content .= "[".$key."]\n";
				foreach ($elem as $key2=>$elem2){
					if($elem2=="") $content .= $key2." = \n";
					else $content .= $key2." = \"".$elem2."\"\n";
				}
				$content .= "\n\n";
			}
		}else{
			foreach ($assocArr as $key=>$elem){
				if(is_array($elem)){
					foreach ($elem as $key2=>$elem2){
						if($elem=="") $content .= $key2." = \n";
						else $content .= $key2." = \"".$elem2."\"\n";
					}
				}
			}
		}
		if (!$handle = fopen($path, 'w')) return false;
		if (!fwrite($handle, $content)) return false;
		fclose($handle);
		return true;
	}  

	public static function reinitFile($path, $datas, $sections=''){
		if (is_file($path)){
			$data = parse_ini_file($path, true);
			$data[$sections] = $datas;
			
			if (self::writeIniFile($data, $path, true)) return true;
			else return false;
		}else return false;
	}
	
}