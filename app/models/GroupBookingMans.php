<?php

class GroupBookingMans extends \Phalcon\Mvc\Model
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
     * @Column(column="order_id", type="integer", length=255, nullable=true)
     */
    public $order_id;

    /**
     *
     * @var integer
     * @Column(column="gb_id", type="integer", length=255, nullable=true)
     */
    public $gb_id;

    /**
     *
     * @var integer
     * @Column(column="gbl_id", type="integer", length=255, nullable=true)
     */
    public $gbl_id;

    /**
     *
     * @var integer
     * @Column(column="uid", type="integer", length=255, nullable=false)
     */
    public $uid;

    /**
     *
     * @var string
     * @Column(column="time", type="string", length=16, nullable=true)
     */
    public $time;
    
    /**
     *
     * @var enum
     * @Column(column="type", type="enum", length=0, nullable=true)
     */
    public $type;
    
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("group_booking_mans");
        
        $this->hasOne("uid", "User", "id");
        $this->hasOne('gbl_id', 'GroupBookingList', 'id');
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'group_booking_mans';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return GroupBookingMans[]|GroupBookingMans|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return GroupBookingMans|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
