<?php

class OrderLogistics extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $order_sn;

    /**
     *
     * @var string
     */
    public $logistics_num;

    /**
     *
     * @var string
     */
    public $code;

    /**
     *
     * @var string
     */
    public $shipper;

    /**
     *
     * @var string
     */
    public $address;

    /**
     *
     * @var string
     */
    public $mobile;

    /**
     *
     * @var string
     */
    public $template;

    /**
     *
     * @var string
     */
    public $addtime;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("order_logistics");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'order_logistics';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return OrderLogistics[]|OrderLogistics|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return OrderLogistics|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
