<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class Adminuser extends \Phalcon\Mvc\Model
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
     * @Column(column="sid", type="integer", length=11, nullable=false)
     */
    public $sid;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=20, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="uname", type="string", length=10, nullable=true)
     */
    public $uname;

    /**
     *
     * @var string
     * @Column(column="pwd", type="string", length=50, nullable=false)
     */
    public $pwd;

    /**
     *
     * @var integer
     * @Column(column="qx", type="integer", length=4, nullable=false)
     */
    public $qx;

    /**
     *
     * @var integer
     * @Column(column="addtime", type="integer", length=11, nullable=false)
     */
    public $addtime;

    /**
     *
     * @var string
     * @Column(column="status", type="string", nullable=false)
     */
    public $status;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("adminuser");
        
        $this->addBehavior(new SoftDelete(
			array(
				'field' => 'status',
				'value' => 'S2'
			)
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
        return 'adminuser';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Adminuser[]|Adminuser|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Adminuser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    
    
    //----------
    // 自定义
    //----------
    /**
     * 获取用户列表
     */
    public static function ausersList($type='shop', $dataArr=array()){
    	if ($type == 'all'){
    		
    	}else if ($type == 'shop'){//获取店铺管理员
    		if (isset($dataArr['sid'])){
    			$aus = self::find("sid={$dataArr['sid']} and status!='S2'");
    			
    			if ($aus) {
    				$auarr = array();
    				foreach ($aus as $k=>$v){
    					$auarr[$k] = $v->toArray();
    					$auarr[$k]['addtime'] = empty($v->addtime) ? '' : date('Y-m-d', $v->addtime);
    				}
    				return $auarr;
    			}else return 'DATAEXCEPTION';
    		}else return 'DATAERR';
    	}
    }
    
}
