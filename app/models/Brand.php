<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class Brand extends \Phalcon\Mvc\Model
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
     * @var string
     * @Column(column="name", type="string", length=100, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="photo", type="string", length=100, nullable=true)
     */
    public $photo;

    /**
     *
     * @var integer
     * @Column(column="type", type="integer", length=2, nullable=true)
     */
    public $type;

    /**
     *
     * @var integer
     * @Column(column="addtime", type="integer", length=11, nullable=true)
     */
    public $addtime;

    /**
     *
     * @var integer
     * @Column(column="shop_id", type="integer", length=11, nullable=true)
     */
    public $shop_id;

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
        $this->setSource("brand");
        
        $this->addBehavior(new SoftDelete(
        	array(
        		'field' => 'status',
        		'value' => 'S0'
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
        return 'brand';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Brand[]|Brand|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Brand|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
