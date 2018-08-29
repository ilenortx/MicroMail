<?php

class OrderProduct extends \Phalcon\Mvc\Model
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
     * @Column(column="pid", type="integer", length=11, nullable=false)
     */
    public $pid;

    /**
     *
     * @var string
     * @Column(column="pay_sn", type="string", length=20, nullable=true)
     */
    public $pay_sn;

    /**
     *
     * @var integer
     * @Column(column="order_id", type="integer", length=11, nullable=false)
     */
    public $order_id;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=50, nullable=false)
     */
    public $name;

    /**
     *
     * @var double
     * @Column(column="price", type="double", length=8, nullable=false)
     */
    public $price;

    /**
     *
     * @var string
     * @Column(column="photo_x", type="string", length=100, nullable=true)
     */
    public $photo_x;

    /**
     *
     * @var integer
     * @Column(column="addtime", type="integer", length=11, nullable=false)
     */
    public $addtime;

    /**
     *
     * @var integer
     * @Column(column="num", type="integer", length=11, nullable=false)
     */
    public $num;

    /**
     *
     * @var string
     * @Column(column="pro_guige", type="string", length=50, nullable=true)
     */
    public $pro_guige;
    
    /**
     *
     * @var string
     * @Column(column="skuid", type="string", length=255, nullable=true)
     */
    public $skuid;
    
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("order_product");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'order_product';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return OrderProduct[]|OrderProduct|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return OrderProduct|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
