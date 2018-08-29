<?php

class CutPriceSprites extends \Phalcon\Mvc\Model
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
     * @Primary
     * @Identity
     * @Column(column="shop_id", type="integer", length=255, nullable=false)
     */
    public $shop_id;
    
    /**
     *
     * @var string
     * @Column(column="name", type="string", length=18, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="stime", type="string", length=16, nullable=false)
     */
    public $stime;

    /**
     *
     * @var string
     * @Column(column="etime", type="string", length=16, nullable=false)
     */
    public $etime;

    /**
     *
     * @var string
     * @Column(column="cptype", type="string", nullable=false)
     */
    public $cptype;

    /**
     *
     * @var integer
     * @Column(column="friends", type="integer", length=3, nullable=false)
     */
    public $friends;

    /**
     *
     * @var integer
     * @Column(column="low_price", type="integer", length=125, nullable=false)
     */
    public $low_price;

    /**
     *
     * @var string
     * @Column(column="pro_ids", type="string", length=255, nullable=false)
     */
    public $pro_ids;

    /**
     *
     * @var string
     * @Column(column="addtime", type="string", length=16, nullable=false)
     */
    public $addtime;

    /**
     *
     * @var string
     * @Column(column="status", type="string", nullable=false)
     */
    public $status;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("cut_price_sprites");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'cut_price_sprites';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return CutPriceSprites[]|CutPriceSprites|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return CutPriceSprites|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
