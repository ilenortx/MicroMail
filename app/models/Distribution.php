<?php

class Distribution extends \Phalcon\Mvc\Model
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
     * @Column(column="shop_id", type="integer", length=255, nullable=true)
     */
    public $shop_id;
    
    /**
     *
     * @var integer
     * @Column(column="uid", type="integer", length=255, nullable=true)
     */
    public $uid;
    
    /**
     *
     * @var string
     * @Column(column="name", type="string", length=16, nullable=true)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="phone", type="string", length=16, nullable=true)
     */
    public $phone;

    /**
     *
     * @var string
     * @Column(column="addtime", type="string", length=16, nullable=true)
     */
    public $addtime;

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
        $this->setSource("distribution");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'distribution';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Distribution[]|Distribution|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Distribution|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
