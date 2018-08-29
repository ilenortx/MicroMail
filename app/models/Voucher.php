<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class Voucher extends \Phalcon\Mvc\Model
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
     * @Column(column="shop_id", type="integer", length=11, nullable=false)
     */
    public $shop_id;

    /**
     *
     * @var string
     * @Column(column="title", type="string", length=100, nullable=true)
     */
    public $title;

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
     * @Column(column="start_time", type="integer", length=11, nullable=false)
     */
    public $start_time;

    /**
     *
     * @var integer
     * @Column(column="end_time", type="integer", length=11, nullable=false)
     */
    public $end_time;

    /**
     *
     * @var integer
     * @Column(column="point", type="integer", length=11, nullable=true)
     */
    public $point;

    /**
     *
     * @var integer
     * @Column(column="count", type="integer", length=11, nullable=false)
     */
    public $count;

    /**
     *
     * @var integer
     * @Column(column="receive_num", type="integer", length=11, nullable=true)
     */
    public $receive_num;

    /**
     *
     * @var integer
     * @Column(column="addtime", type="integer", length=11, nullable=false)
     */
    public $addtime;

    /**
     *
     * @var integer
     * @Column(column="type", type="integer", length=1, nullable=false)
     */
    public $type;

    /**
     *
     * @var integer
     * @Column(column="del", type="integer", length=1, nullable=true)
     */
    public $del;

    /**
     *
     * @var string
     * @Column(column="proid", type="string", nullable=true)
     */
    public $proid;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("voucher");
        
        $this->addBehavior(new SoftDelete(
        	array(
        		'field' => 'del',
        		'value' => 1
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
        return 'voucher';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Voucher[]|Voucher|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Voucher|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
