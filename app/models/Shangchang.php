<?php

class Shangchang extends ModelBase
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
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="uid", type="integer", length=255, nullable=true)
     */
    public $uid;
    
    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="fxtc", type="double", length=0, nullable=true)
     */
    public $fxtc;
    
    /**
     *
     * @var integer
     * @Column(column="cid", type="integer", length=11, nullable=true)
     */
    public $cid;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=20, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="uname", type="string", length=10, nullable=false)
     */
    public $uname;

    /**
     *
     * @var string
     * @Column(column="logo", type="string", length=100, nullable=true)
     */
    public $logo;

    /**
     *
     * @var string
     * @Column(column="vip_char", type="string", length=100, nullable=true)
     */
    public $vip_char;

    /**
     *
     * @var integer
     * @Column(column="sheng", type="integer", length=11, nullable=false)
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
     * @Column(column="address", type="string", length=255, nullable=true)
     */
    public $address;

    /**
     *
     * @var string
     * @Column(column="address_xq", type="string", length=255, nullable=true)
     */
    public $address_xq;

    /**
     *
     * @var integer
     * @Column(column="sort", type="integer", length=11, nullable=false)
     */
    public $sort;

    /**
     *
     * @var string
     * @Column(column="location_x", type="string", length=20, nullable=false)
     */
    public $location_x;

    /**
     *
     * @var string
     * @Column(column="location_y", type="string", length=20, nullable=false)
     */
    public $location_y;

    /**
     *
     * @var integer
     * @Column(column="addtime", type="integer", length=11, nullable=false)
     */
    public $addtime;

    /**
     *
     * @var integer
     * @Column(column="updatetime", type="integer", length=11, nullable=false)
     */
    public $updatetime;

    /**
     *
     * @var string
     * @Column(column="content", type="string", nullable=true)
     */
    public $content;

    /**
     *
     * @var string
     * @Column(column="intro", type="string", length=200, nullable=true)
     */
    public $intro;

    /**
     *
     * @var integer
     * @Column(column="grade", type="integer", length=2, nullable=false)
     */
    public $grade;

    /**
     *
     * @var string
     * @Column(column="tel", type="string", length=15, nullable=true)
     */
    public $tel;

    /**
     *
     * @var string
     * @Column(column="utel", type="string", length=15, nullable=true)
     */
    public $utel;

    /**
     *
     * @var integer
     * @Column(column="status", type="integer", length=2, nullable=true)
     */
    public $status;
    
    /**
     *
     * @var integer
     * @Column(column="type", type="enum", length=0, nullable=false)
     */
    public $sc_type;
    
    /**
     *
     * @var integer
     * @Column(column="type", type="integer", length=2, nullable=false)
     */
    public $type;
    
    /**
     *
     * @var string
     * @Column(column="qq", type="string", length=255, nullable=true)
     */
    public $qq;

    /**
     *
     * @var string
     * @Column(column="wx_appid", type="string", length=32, nullable=true)
     */
    public $wx_appid;

    /**
     *
     * @var string
     * @Column(column="wx_mch_id", type="string", length=32, nullable=true)
     */
    public $shh_mch_id;

    /**
     *
     * @var string
     * @Column(column="wx_key", type="string", length=100, nullable=true)
     */
    public $shh_key;

    /**
     *
     * @var string
     * @Column(column="wx_secret", type="string", length=64, nullable=true)
     */
    public $wx_secret;
    
    /**
     *
     * @var string
     * @Column(column="xcx_appid", type="string", length=32, nullable=true)
     */
    public $xcx_appid;
    
    /**
     *
     * @var string
     * @Column(column="xcx_secret", type="string", length=64, nullable=true)
     */
    public $xcx_secret;
    
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("shangchang");
        
        $this->hasOne('id', 'MmShopRights', 'sid');
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'shangchang';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Shangchang[]|Shangchang|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Shangchang|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    
    //----------
    // 店铺信息
    //----------
    public static function shopInfo($type='id', $sid){
    	if ($type == 'id'){
    		$si = self::findFirstById($sid);
    		
    		if ($si) return $si;
    		else return 'DATAEXCEPTION';
    	}
    }
    
}
