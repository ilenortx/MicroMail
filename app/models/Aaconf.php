<?php

class Aaconf extends \Phalcon\Mvc\Model
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
     * @Column(column="shop_id", type="integer", length=255, nullable=false)
     */
    public $shop_id;

    /**
     *
     * @var string
     * @Column(column="zqname", type="string", length=16, nullable=true)
     */
    public $zqname;

    /**
     *
     * @var string
     * @Column(column="btname", type="string", length=32, nullable=true)
     */
    public $btname;

    /**
     *
     * @var string
     * @Column(column="ztype", type="string", nullable=true)
     */
    public $ztype;

    /**
     *
     * @var string
     * @Column(column="zurl", type="string", length=64, nullable=true)
     */
    public $zurl;

    /**
     *
     * @var string
     * @Column(column="zphoto", type="string", length=255, nullable=true)
     */
    public $zphoto;

    /**
     *
     * @var string
     * @Column(column="rttype", type="string", nullable=true)
     */
    public $rttype;

    /**
     *
     * @var string
     * @Column(column="rturl", type="string", length=64, nullable=true)
     */
    public $rturl;

    /**
     *
     * @var string
     * @Column(column="rtphoto", type="string", length=255, nullable=true)
     */
    public $rtphoto;

    /**
     *
     * @var string
     * @Column(column="rbtype", type="string", nullable=true)
     */
    public $rbtype;

    /**
     *
     * @var string
     * @Column(column="rburl", type="string", length=64, nullable=true)
     */
    public $rburl;

    /**
     *
     * @var string
     * @Column(column="rbphoto", type="string", length=255, nullable=true)
     */
    public $rbphoto;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("aaconf");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'aaconf';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Aaconf[]|Aaconf|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Aaconf|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
