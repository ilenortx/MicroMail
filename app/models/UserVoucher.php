<?php

class UserVoucher extends \Phalcon\Mvc\Model
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
     * @Column(column="uid", type="integer", length=11, nullable=false)
     */
    public $uid;

    /**
     *
     * @var integer
     * @Column(column="vid", type="integer", length=11, nullable=false)
     */
    public $vid;

    /**
     *
     * @var integer
     * @Column(column="shop_id", type="integer", length=11, nullable=false)
     */
    public $shop_id;

    /**
     *
     * @var double
     * @Column(column="full_money", type="double", length=9, nullable=false)
     */
    public $full_money;

    /**
     *
     * @var double
     * @Column(column="amount", type="double", length=9, nullable=false)
     */
    public $amount;

    /**
     *
     * @var integer
     * @Column(column="start_time", type="integer", length=11, nullable=true)
     */
    public $start_time;

    /**
     *
     * @var integer
     * @Column(column="end_time", type="integer", length=11, nullable=true)
     */
    public $end_time;

    /**
     *
     * @var integer
     * @Column(column="addtime", type="integer", length=11, nullable=false)
     */
    public $addtime;

    /**
     *
     * @var integer
     * @Column(column="status", type="integer", length=2, nullable=true)
     */
    public $status;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("user_voucher");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user_voucher';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserVoucher[]|UserVoucher|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserVoucher|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
