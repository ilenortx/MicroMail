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
    public $isd;
    
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("task_queue");
        
        $this->addBehavior(new SoftDelete(
        		array( 'field' => 'status', 'value' => 'S0' )
        ));
        
        $this->hasOne('sid', 'Shangchang', 'id');
        
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
    
}
