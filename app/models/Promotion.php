<?php

class Promotion extends \Phalcon\Mvc\Model
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
     * @Column(column="name", type="string", length=20, nullable=true)
     */
    public $name;

    /**
     *
     * @var integer
     * @Column(column="shop_id", type="integer", length=255, nullable=true)
     */
    public $shop_id;

    /**
     *
     * @var integer
     * @Column(column="pro_id", type="integer", length=255, nullable=true)
     */
    public $pro_id;

    /**
     *
     * @var string
     * @Column(column="pprice", type="string", length=10, nullable=true)
     */
    public $pprice;
    
    /**
     *
     * @var integer
     * @Column(column="num", type="integer", length=255, nullable=true)
     */
    public $num;
    
    /**
     *
     * @var integer
     * @Column(column="maxnum", type="integer", length=255, nullable=true)
     */
    public $maxnum;

    /**
     *
     * @var string
     * @Column(column="stime", type="string", length=16, nullable=true)
     */
    public $stime;

    /**
     *
     * @var string
     * @Column(column="etime", type="string", length=16, nullable=true)
     */
    public $etime;

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
        $this->setSource("promotion");
        
        $this->hasOne("pro_id", "Product", "id");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'promotion';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Promotion[]|Promotion|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Promotion|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
