<?php

class Guige extends \Phalcon\Mvc\Model
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
     * @var integer
     * @Column(column="attr_id", type="integer", length=11, nullable=true)
     */
    public $attr_id;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=50, nullable=false)
     */
    public $name;

    /**
     *
     * @var double
     * @Column(column="price", type="double", length=9, nullable=true)
     */
    public $price;

    /**
     *
     * @var integer
     * @Column(column="stock", type="integer", length=11, nullable=false)
     */
    public $stock;

    /**
     *
     * @var string
     * @Column(column="img", type="string", length=100, nullable=true)
     */
    public $img;

    /**
     *
     * @var integer
     * @Column(column="addtime", type="integer", length=11, nullable=false)
     */
    public $addtime;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("guige");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'guige';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Guige[]|Guige|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Guige|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
