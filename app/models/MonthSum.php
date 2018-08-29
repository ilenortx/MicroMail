<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class MonthSum extends \Phalcon\Mvc\Model
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
     * @Column(column="shop_id", type="integer", length=20, nullable=true)
     */
    public $shop_id;

    /**
     *
     * @var string
     * @Column(column="year", type="string", length=4, nullable=true)
     */
    public $year;

    /**
     *
     * @var string
     * @Column(column="month", type="string", length=4, nullable=true)
     */
    public $month;

    /**
     *
     * @var string
     * @Column(column="amount", type="string", nullable=true)
     */
    public $amount;

    /**
     *
     * @var string
     * @Column(column="addtime", type="string", length=16, nullable=true)
     */
    public $addtime;
    
    /**
     *
     * @var string
     * @Column(column="sqtxtime", type="string", length=16, nullable=true)
     */
    public $sqtxtime;
    
    /**
     *
     * @var string
     * @Column(column="txtime", type="string", length=16, nullable=true)
     */
    public $txtime;
    
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
        $this->setSource("month_sum");
        
        $this->hasOne("shop_id", "Shangchang", "id");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'month_sum';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MonthSum[]|MonthSum|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MonthSum|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
