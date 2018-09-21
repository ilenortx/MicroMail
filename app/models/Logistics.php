<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class Logistics extends \Phalcon\Mvc\Model
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
     * @var string
     * @Column(column="cys", type="string", nullable=false)
     */
    public $cys;
    
    /**
     *
     * @var string
     * @Column(column="name", type="string", length=32, nullable=true)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="code", type="string", length=16, nullable=true)
     */
    public $code;

    /**
     *
     * @var string
     * @Column(column="tel", type="string", length=16, nullable=true)
     */
    public $tel;
    
    /**
     *
     * @var string
     * @Column(column="isaccount", type="string", nullable=false)
     */
    public $isaccount;
    
    /**
     *
     * @var string
     * @Column(column="isjscx", type="string", nullable=false)
     */
    public $isjscx;

    /**
     *
     * @var string
     * @Column(column="iswlgz", type="string", nullable=false)
     */
    public $iswlgz;

    /**
     *
     * @var string
     * @Column(column="isdzmd", type="string", nullable=false)
     */
    public $isdzmd;

    /**
     *
     * @var string
     * @Column(column="isqj", type="string", nullable=false)
     */
    public $isqj;

    /**
     *
     * @var string
     * @Column(column="remark", type="string", nullable=true)
     */
    public $remark;
    
    /**
     *
     * @var string
     * @Column(column="sort", type="integer", nullable=true)
     */
    public $sort;
    
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
        $this->setSource("logistics");
        
        $this->addBehavior(new SoftDelete(
        		array('field' => 'status', 'value' => 'S0')
        ));
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'logistics';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Logistics[]|Logistics|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Logistics|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    //----------
    // 自定义
    //----------
    /**
     * 获取所有物流公司
     */
    public static function wlgsList($params=array()){
    	$conditions = array('conditions'=>"status!='S0'");
    	
    	if (isset($params['limit'])) $conditions['limit'] = $params['limit'];
    	
    	if (isset($params['order'])) $conditions['order'] = $params['order'];
    	else $conditions['order'] = 'sort desc';
    	
    	$ls = Logistics::find($conditions);
    	
    	if ($ls) return $ls->toArray();
    	else return 'DATAEXCEPTION';
    }
    
    /**
     * 保存物流信息
     */
    public static function saveWlminfo($params, $id=0){
    	if ($id){
    		$wl = Logistics::findFirst($id);
    	}else {
    		$wl= new Logistics();
    	}
    	
    	$wl->cys = $params['cys'];
    	$wl->name = $params['name'];
    	$wl->code = $params['code'];
    	$wl->tel = $params['tel'];
    	$wl->isaccount = $params['isaccount']?'1':'0';
    	$wl->isjscx = $params['isjscx']?'1':'0';
    	$wl->iswlgz = $params['iswlgz']?'1':'0';
    	$wl->isdzmd = $params['isdzmd']?'1':'0';
    	$wl->isqj = $params['isqj']?'1':'0';
    	$wl->remark =  $params['remark'];
    	$wl->sort = $params['sort'];
    	$wl->status = 'S1';
    	
    	if ($wl->save()) return 'SUCCESS';
    	else return 'OPEFILE';
    }
    
    /**
     * 获取物流公司信息
     */
    public static function wlminfo($id=0){
    	$wl = Logistics::findFirst($id);
    	
    	if ($wl) return $wl->toArray();
    	else return array(
    			'id'=>'', 'cys'=>'', 'name'=>'', 'code'=>'', 'tel'=>'',
    			'isjscx'=>'', 'iswlgz'=>'', 'isdzmd'=>'', 'isqj'=>'',
    			'remark'=>'', 'sort'=>'', 'status'=>'', 'isaccount'=>''
    	);
    }
    public static function getWlinfo($type='id', $param=''){
    	$wl = null;
    	if ($type == 'id'){
    		$wl = Logistics::findFirst($id);
    	}else if ($type == 'code'){
    		$wl = Logistics::findFirst("code='{$param}'");
    	}
    	
    	if ($wl) return $wl->toArray();
    	else return 'DATAEXCEPTION';
    }
    
    /**
     * 删除
     */
    public static function delWl($id){
    	$wl = Logistics::findFirst("id=$id");
    	
    	if ($wl){
    		if ($wl->delete()) return 'SUCCESS';
    		else return 'OPEFILE';
    	}else return 'DATAEXCEPTION';
    }
}
