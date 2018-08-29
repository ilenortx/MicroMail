<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class JoinShangchang extends \Phalcon\Mvc\Model
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
     * @Column(column="uid", type="integer", length=255, nullable=true)
     */
    public $uid;

    /**
     *
     * @var string
     * @Column(column="uname", type="string", length=16, nullable=true)
     */
    public $uname;

    /**
     *
     * @var string
     * @Column(column="shop_name", type="string", length=16, nullable=true)
     */
    public $shop_name;

    /**
     *
     * @var string
     * @Column(column="utel", type="string", length=15, nullable=true)
     */
    public $utel;

    /**
     *
     * @var string
     * @Column(column="address", type="string", length=50, nullable=true)
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
     * @var string
     * @Column(column="kftel", type="string", length=15, nullable=true)
     */
    public $kftel;

    /**
     *
     * @var integer
     * @Column(column="shnum", type="integer", length=2, nullable=true)
     */
    public $shnum;

    /**
     *
     * @var string
     * @Column(column="addtime", type="string", length=20, nullable=true)
     */
    public $addtime;

    /**
     *
     * @var string
     * @Column(column="sqtime", type="string", length=20, nullable=true)
     */
    public $sqtime;

    /**
     *
     * @var integer
     * @Column(column="sale_type", type="integer", length=20, nullable=true)
     */
    public $sale_type;

    /**
     *
     * @var string
     * @Column(column="audit_info", type="string", nullable=true)
     */
    public $audit_info;

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
        $this->setSource("join_shangchang");
        
        $this->hasOne("uid", "User", "id");
        $this->hasOne("sale_type", "SaleType", "id");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'join_shangchang';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return JoinShangchang[]|JoinShangchang|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return JoinShangchang|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
