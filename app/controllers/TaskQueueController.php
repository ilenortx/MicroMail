<?php

/**
 * 任务管理
 * @author xiao
 *
 */
class TaskQueueController extends ControllerBase{

    public function indexAction(){
		//获取待执行任务
    	$tqs = TaskQueue::getTaskQueue();
		
		if ($tqs){
			foreach ($tqs as $k=>$v){
				$v->dotime = time();
				$v->status = 'S2';
				if ($v->save()){//保存为执行状态
					
					if ($v->ttype = 'T1'){//商品Excel导入
						$result = $this->proExcelImport($v);//执行导入
						if ($result['status'] == 0){//判断返回状态
							$v->status = 'S4'; $v->errs = json_encode($result['errs']);
						}else $v->status = 'S3';
						$v->etime = time(); $v->save();
					}
					
					//......
				}
				
			}
		}
    }

    /**
     * 商品导入
     */
    private function proExcelImport($obj){
    	require_once APP_PATH.'/library/PHPExcel/PHPExcel.php';
    	$errStatus = false; $errInfo = array();
    	
    	$filename = UPLOAD_FILE.$obj->params;
    	if (!file_exists($filename)) return 'FILENOTEXIST';//文件不存在
    	
    	$exts = explode('.', $filename)[count(explode('.', $filename))-1];//获取文件后缀名
    	
    	$PHPExcel = new \PHPExcel();
    	if ($exts == 'xls') {
    		$PHPReader = PHPExcel_IOFactory::createReader('Excel5');
    	} else if ($exts == 'xlsx') {
    		$PHPReader = PHPExcel_IOFactory::createReader('Excel2007');
    	}
    	
    	$PHPExcel = $PHPReader->load($filename);//载入文件
    	//获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
    	$currentSheet = $PHPExcel->getSheet(0);
    	$allColumn = $currentSheet->getHighestColumn();//获取总列数
    	$allRow = $currentSheet->getHighestRow();//获取总行数
    	
    	$startRow = 2;
    	//循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
    	for ($currentRow = $startRow; $currentRow <= $allRow; $currentRow++) {
    		//从哪列开始，A表示第一列
    		for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
    			//数据坐标
    			$address = $currentColumn . $currentRow;
    			//读取到的数据，保存到数组$data中
    			$cell = $currentSheet->getCell($address)->getValue();
    			
    			if ($cell instanceof PHPExcel_RichText) {
    				$cell = $cell->__toString();
    			}
    			if ($currentColumn=='A' && empty($cell)) break;
    			$data[$currentRow - $startRow][$currentColumn] = $cell;
    		}
    	}
    	// 写入数据库操作
    	$ProModel = new Product();
    	foreach($data as $k=>$v) {
    		$time = time();
    		$data = [
    				'name'=>$v['A'], 'brand_id'=>0, 'cid'=>0, 'pro_number'=>$v['D'],
    				'intro'=>$v['E'], 'company'=>$v['F'], 'price'=>$v['G'], 'price_yh'=>$v['H'],
    				'price_jf'=>$v['I'], 'is_down'=>($v['J']&&$v['J']=='Y')?0:1, 'num'=>$v['K'],
    				'renqi'=>$v['L'], 'sort'=>$v['M'], 'is_show'=>($v['N']&&$v['N']=='Y')?1:0, 
    				'is_hot'=>($v['O']&&$v['O']=='Y')?1:0, 
    				'shop_id'=>$obj->sid, 'updatetime'=>$time, 'shiyong'=>0, 'type'=>0, 'stype'=>0,
    				'del'=>0, 'pro_type'=>0, 'addtime'=>$time
    				//'intro'=>$v['P'], 'intro'=>$v['Q'], 'intro'=>$v['R'], 'intro'=>$v['S'], 'intro'=>$v['T']
    		];
    		$clone = clone $ProModel; //克隆一个新对象，使用新对象来调用create()函数
    		$result = $clone->create($data);
    		if (!$result) {
     			$errStatus = true;
     			array_push($errInfo, array('rownum'=>$k, 'err'=>$clone->getMessages()));
    		}
    	}
    	
    	return array('status'=>$errStatus?0:1, 'errs'=>$errInfo);
    }
    
    
    
    /**
     * 立即执行任务
     */
}

