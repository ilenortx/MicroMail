<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class MmApps extends ModelBase
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
     * @Column(column="pid", type="integer", length=255, nullable=true)
     */
    public $pid;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=16, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="ename", type="string", length=26, nullable=true)
     */
    public $ename;

    /**
     *
     * @var string
     * @Column(column="path", type="string", length=255, nullable=true)
     */
    public $path;

    /**
     *
     * @var string
     * @Column(column="icon", type="string", length=16, nullable=true)
     */
    public $icon;

    /**
     *
     * @var string
     * @Column(column="addtime", type="string", length=13, nullable=true)
     */
    public $addtime;

    /**
     *
     * @var string
     * @Column(column="remark", type="string", nullable=true)
     */
    public $remark;

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
        $this->setSource("mm_apps");
        
        $this->addBehavior(new SoftDelete(
        		array( 'field'=>'status', 'value'=>'S0' )
        ));
        
        $this->hasOne("id", "MmAppOpcode", "aid");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'mm_apps';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MmApps[]|MmApps|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MmApps|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    
    //----------
    // 自定义
    //----------
    /**
     * 查询
     * @param string $type
     * @param array $conditions
     * @return MmApps[]|MmApps|\Phalcon\Mvc\Model\ResultSetInterface|string
     */
    public static function getApps($conditions=array()){
    	if (self::isConditions($conditions)){
    		$apps = MmApps::find($conditions);
    	}else $apps = MmApps::find();
    	
    	if ($apps) return $apps;
    	else return 'DATAEXCEPTION';
    }
    
    /**
     * 详情
     */
    public static function appDetail($id){
    	$app = MmApps::findFirstById($id);
    	
    	if ($app) return $app;
    	else return 'DATAEXCEPTION';
    }
    
    /**
     * 一级菜单
     */
    public static function stairMenu(){
    	$sms = MmApps::find(array(
    			'conditions'=> "status!=?1 and pid=?2",
    			'bind'		=> array(1=>'S0', 2=>0),
    			'order'		=> 'addtime asc'
    	));
    	
    	if ($sms) return $sms;
    	else return 'DATAEXCEPTION';
    }
    
}
