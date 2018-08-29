<?php

class GroupBookingList extends \Phalcon\Mvc\Model
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
     * @Column(column="gb_id", type="integer", length=255, nullable=true)
     */
    public $gb_id;

    /**
     *
     * @var integer
     * @Column(column="pro_id", type="integer", length=255, nullable=true)
     */
    public $pro_id;

    /**
     *
     * @var integer
     * @Column(column="uid", type="integer", length=255, nullable=true)
     */
    public $uid;

    /**
     *
     * @var integer
     * @Column(column="mans", type="integer", length=4, nullable=true)
     */
    public $mans;

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
     * @Column(column="status", type="string", nullable=true)
     */
    public $status;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("group_booking_list");
        
        $this->hasOne("uid", "User", "id");
        $this->hasOne("pro_id", "Product", "id");
        $this->hasOne('gb_id', 'GroupBooking', 'id');
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'group_booking_list';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return GroupBookingList[]|GroupBookingList|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return GroupBookingList|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
