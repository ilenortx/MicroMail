<?php

class ProductCx extends \Phalcon\Mvc\Model
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
     * @var string
     * @Column(column="name", type="string", length=64, nullable=true)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="photo", type="string", length=255, nullable=true)
     */
    public $photo;
    
    /**
     *
     * @var string
     * @Column(column="adphoto", type="string", length=255, nullable=true)
     */
    public $padphoto;
    
    /**
     *
     * @var string
     * @Column(column="proids", type="string", length=255, nullable=true)
     */
    public $proids;
    
    /**
     *
     * @var enum
     * @Column(column="sstyle", type="enum", length=0, nullable=true)
     */
    public $sstyle;
    
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
        $this->setSource("product_cx");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'product_cx';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProductCx[]|ProductCx|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProductCx|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
