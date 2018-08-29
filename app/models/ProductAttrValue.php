<?php

class ProductAttrValue extends \Phalcon\Mvc\Model
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
     * @Column(column="name", type="string", length=16, nullable=true)
     */
    public $name;

    /**
     *
     * @var integer
     * @Column(column="pid", type="integer", length=255, nullable=true)
     */
    public $pid;

    /**
     *
     * @var string
     * @Column(column="pname", type="string", length=16, nullable=true)
     */
    public $pname;

    /**
     *
     * @var string
     * @Column(column="icon", type="string", length=255, nullable=true)
     */
    public $icon;

    /**
     *
     * @var integer
     * @Column(column="sort", type="integer", length=4, nullable=true)
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
        $this->setSource("product_attr_value");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'product_attr_value';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProductAttrValue[]|ProductAttrValue|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProductAttrValue|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
