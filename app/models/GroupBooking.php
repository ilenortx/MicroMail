<?php

class GroupBooking extends \Phalcon\Mvc\Model
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
     * @Column(column="gbname", type="string", length=16, nullable=true)
     */
    public $gbname;
    
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
     * @var integer
     * @Column(column="pid", type="integer", length=255, nullable=true)
     */
    public $pid;

    /**
     *
     * @var integer
     * @Column(column="mannum", type="integer", length=2, nullable=true)
     */
    public $mannum;

    /**
     *
     * @var integer
     * @Column(column="gbtime", type="integer", length=2, nullable=true)
     */
    public $gbtime;

    /**
     *
     * @var integer
     * @Column(column="gbnum", type="integer", length=2, nullable=true)
     */
    public $gbnum;

    /**
     *
     * @var string
     * @Column(column="gbprice", type="string", length=10, nullable=true)
     */
    public $gbprice;

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
        $this->setSource("group_booking");
        
        $this->hasOne("pid", "Product", "id");
        $this->hasMany("id", "GroupBookingList", "gb_id");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'group_booking';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return GroupBooking[]|GroupBooking|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return GroupBooking|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
