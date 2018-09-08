<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class TaskQueue extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=255, nullable=false)
     */
    public $id;
    
    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="sid", type="integer", length=255, nullable=true)
     */
    
    /**
     *
     * @var integer
     * @Column(column="admin", type="integer", length=255, nullable=true)
     */
    public $admin;

    /**
     *
     * @var string
     * @Column(column="ttype", type="string", nullable=true)
     */
    public $ttype;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=64, nullable=true)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="params", type="string", length=255, nullable=true)
     */
    public $params;

    /**
     *
     * @var string
     * @Column(column="remark", type="string", length=255, nullable=true)
     */
    public $remark;

    /**
     *
     * @var string
     * @Column(column="intime", type="string", length=16, nullable=true)
     */
    public $intime;

    /**
     *
     * @var string
     * @Column(column="dotime", type="string", length=16, nullable=true)
     */
    public $dotime;

    /**
     *
     * @var string
     * @Column(column="etime", type="string", length=16, nullable=true)
     */
    public $etime;

    /**
     *
     * @var integer
     * @Column(column="level", type="integer", length=10, nullable=true)
     */
    public $level;
    
    /**
     *
     * @var string
     * @Column(column="errs", type="string", nullable=true)
     */
    public $errs;
    
    /**
     *
     * @var string
     * @Column(column="status", type="string", nullable=true)
     */
    public $status;
    
    /**
     *
     * @var string
     * @Column(column="ostatus", type="string", nullable=true)
     */
    public $ostatus;
    
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("task_queue");
        
//         $this->addBehavior(new SoftDelete(
//         		array( 'field' => 'status', 'value' => 'S0' )
//         ));
        
        $this->hasOne('sid', 'Shangchang', 'id');
        $this->hasOne('admin', 'Adminuser', 'id');
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'task_queue';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TaskQueue[]|TaskQueue|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TaskQueue|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    
    //----------
    // 自定义
    //----------
    public static function addTaskQueue($params){
    	if (!count($params) || !isset($params['sid']) || empty($params['sid']) || 
    			!isset($params['ttype']) || empty($params['ttype'])) return 'DATAERR';//数据错误
    	
    	$tq = new TaskQueue();
    	$tq->sid = isset($params['sid']) ? $params['sid'] : '';
    	$tq->admin = isset($params['admin']) ? $params['admin'] : '';
    	$tq->ttype = isset($params['ttype']) ? $params['ttype'] : '';
    	$tq->name = isset($params['name']) ? $params['name'] : '';
    	$tq->params = isset($params['params']) ? $params['params'] : '';
    	$tq->remark = isset($params['remark']) ? $params['remark'] : '';
    	$tq->intime = time();
    	$tq->level = isset($params['level']) ? $params['level'] : 0;
    	$tq->status = 'S1';
    	
    	if ($tq->save()) return true;
    	else return 'OPEFILE';
    }
    
    /*
     * @todo: 读取任务队列
     * @param：integer $takeNum  获取任务个数
     * @return: array | boolean
     */
    public static function getTaskQueue($takeNum=50){
    	$tqs = TaskQueue::find(array(
    			'conditions'=> "status='S1'",
    			'order'		=> "level desc, intime desc",
    			'limit'		=> $takeNum
    	));
    	
    	return $tqs;
    }
    
    /**
     * 获取未删除任务列表
     */
    public static function getUnDelTqList($sid){
    	if (empty($sid)) return 'DATAERR';
    	
    	$type = array('T1'=>'产品导入', 'T2'=>'产品导出');
    	$status = array('S0'=>'回收站', 'S1'=>'待执行', 'S2'=>'执行中', 'S3'=>'完成', 'S4'=>'错误');
    	
    	$tq = TaskQueue::find(array(
    			'conditions'=> "sid=?1 and status!=?2",
    			'bind'		=> array(1=>$sid, 2=>'S0'),
    			'order'		=> "intime desc"
    	));
    	$tqls = array();
    	if ($tq){
    		foreach ($tq as $k=>$v){
    			$admin = $v->Adminuser;
    			array_push($tqls, array(
    					'id'=>$v->id, 'sid'=>$v->sid, 'ttype'=>$v->ttype, 'tdesc'=>$type[$v->ttype],
    					'name'=>$v->name, 'remark'=>$v->remark, 'intime'=>date('Y-m-d H:i:s', $v->intime),
    					'dotime'=>date('Y-m-d H:i:s', $v->dotime),'etime'=>date('Y-m-d H:i:s', $v->etime),
    					'errs'=>json_encode($v->errs), 'status'=>$v->status, 'sdesc'=>$status[$v->status],
    					'adminid'=>$admin->id, 'admin'=>$admin->uname
    			));
    		}
    	}
    	
    	return $tqls;
    }
    
    /**
     * 删除数据
     */
    public static function delTaskQueues($sid, $ids, $dtype='S0'){
    	if (empty(trim($ids, ',')) || empty($sid)) return 'DATAERR';
    	$ids = trim($ids, ',');
    	
    	$tqs = TaskQueue::find("id in($ids) and sid=$sid and status!='S0'");
    	if ($tqs){
    		foreach ($tqs as $v){
    			if ($v->status != 'S2'){
    				if ($dtype == 'S0'){
    					$v->ostatus = $v->status;
    					$v->status = 'S0';
    					if (!$v->save()) return 'OPEFILE';
    				}else if ($dtype == 'del'){
    					if (!$v->delete()) return 'OPEFILE';
    				}
    			}
    		}
    	}
    	return 'SUCCESS';
    }
    
    /**
     * 获取任务回收站
     */
    public static function getDelTqList($sid){
    	if (empty($sid)) return 'DATAERR';
    	
    	$type = array('T1'=>'产品导入', 'T2'=>'产品导出');
    	
    	$tq = TaskQueue::find(array(
    			'conditions'=> "sid=?1 and status=?2",
    			'bind'		=> array(1=>$sid, 2=>'S0'),
    			'order'		=> "intime desc"
    	));
    	$tqls = array();
    	if ($tq){
    		foreach ($tq as $k=>$v){
    			$admin = $v->Adminuser;
    			array_push($tqls, array(
    					'id'=>$v->id, 'sid'=>$v->sid, 'ttype'=>$v->ttype, 'tdesc'=>$type[$v->ttype],
    					'name'=>$v->name, 'remark'=>$v->remark, 'intime'=>date('Y-m-d H:i:s', $v->intime),
    					'dotime'=>date('Y-m-d H:i:s', $v->dotime),'etime'=>date('Y-m-d H:i:s', $v->etime),
    					'errs'=>json_encode($v->errs), 'status'=>$v->status, 'adminid'=>$admin->id,
    					'admin'=>$admin->uname
    			));
    		}
    	}
    	
    	return $tqls;
    }
    
    /**
     * 还原回收站
     */
    public static function restoreTqs($sid, $ids){
    	if (empty(trim($ids, ',')) || empty($sid)) return 'DATAERR';
    	$ids = trim($ids, ',');
    	
    	$tqs = TaskQueue::find("id in($ids) and sid=$sid and status='S0'");
    	if ($tqs){
    		foreach ($tqs as $v){
    			$v->status = $v->ostatus;
    			if (!$v->save()) return 'OPEFILE';
    		}
    	}
    	return 'SUCCESS';
    }
    
}
