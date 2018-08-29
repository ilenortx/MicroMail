<?php

class ShoppingChar extends \Phalcon\Mvc\Model
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
     * @var double
     * @Column(column="price", type="double", length=9, nullable=false)
     */
    public $price;

    /**
     *
     * @var integer
     * @Column(column="num", type="integer", length=11, nullable=false)
     */
    public $num;

    /**
     *
     * @var string
     * @Column(column="skuid", type="string", length=255, nullable=false)
     */
    public $skuid;

    /**
     *
     * @var integer
     * @Column(column="addtime", type="integer", length=10, nullable=false)
     */
    public $addtime;

    /**
     *
     * @var integer
     * @Column(column="uid", type="integer", length=11, nullable=false)
     */
    public $uid;

    /**
     *
     * @var integer
     * @Column(column="shop_id", type="integer", length=11, nullable=false)
     */
    public $shop_id;

    /**
     *
     * @var integer
     * @Column(column="gid", type="integer", length=11, nullable=true)
     */
    public $gid;

    /**
     *
     * @var integer
     * @Column(column="type", type="integer", length=2, nullable=true)
     */
    public $type;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("shopping_char");
        
        $this->belongsTo("pid", "Product", "id");
        $this->belongsTo("shop_id", "Shangchang", "id");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'shopping_char';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ShoppingChar[]|ShoppingChar|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ShoppingChar|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
