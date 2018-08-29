<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class ProductAttr extends \Phalcon\Mvc\Model
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
     * @Column(column="sid", type="integer", length=255, nullable=true)
     */
    public $sid;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=255, nullable=true)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="type", type="string", nullable=true)
     */
    public $type;

    /**
     *
     * @var string
     * @Column(column="pro_id", type="string", length=255, nullable=true)
     */
    public $pro_id;
    
    /**
     *
     * @var string
     * @Column(column="values", type="string", nullable=true)
     */
    public $values;
    
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
     *
     * @var string
     * @Column(column="audit_result", type="string", nullable=true)
     */
    public $audit_result;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("product_attr");
        
        $this->addBehavior(new SoftDelete(
        	array( 'field' => 'status', 'value' => 'S0' )
        ));
        
        $this->hasMany('id', 'ProductAttrValue', 'pid');
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'product_attr';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProductAttr[]|ProductAttr|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProductAttr|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
