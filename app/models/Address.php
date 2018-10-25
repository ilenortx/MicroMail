<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class Address extends ModelBase
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=10, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="tel", type="string", length=15, nullable=false)
     */
    public $tel;

    /**
     *
     * @var integer
     * @Column(column="sheng", type="integer", length=11, nullable=true)
     */
    public $sheng;

    /**
     *
     * @var integer
     * @Column(column="city", type="integer", length=11, nullable=true)
     */
    public $city;

    /**
     *
     * @var integer
     * @Column(column="quyu", type="integer", length=11, nullable=true)
     */
    public $quyu;

    /**
     *
     * @var string
     * @Column(column="address", type="string", length=255, nullable=false)
     */
    public $address;

    /**
     *
     * @var string
     * @Column(column="address_xq", type="string", length=255, nullable=false)
     */
    public $address_xq;

    /**
     *
     * @var integer
     * @Column(column="code", type="integer", length=11, nullable=false)
     */
    public $code;

    /**
     *
     * @var integer
     * @Column(column="uid", type="integer", length=11, nullable=false)
     */
    public $uid;

    /**
     *
     * @var integer
     * @Column(column="is_default", type="integer", length=2, nullable=false)
     */
    public $is_default;

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
        $this->setSource("address");
        
        $this->addBehavior(new SoftDelete(
        	array(
        		'field' => 'status',
        		'value' => 0
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
        return 'address';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Address[]|Address|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Address|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    
    //----------
    // 自定义
    //----------
    /**
     * 获取地址信息
     */
    public static function addrInfo($type='id', $params){
    	if ($type == 'id'){
    		$addr = self::findFirst("id=$params and status='1'");
    		if ($addr) return $addr;
    		else return 'DATAEXCEPTION';
    	}
    }
    
}
