<?php

class UserLv extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $lv_id;

    /**
     *
     * @var string
     */
    public $lv_name;

    /**
     *
     * @var double
     */
    public $lv_discount;

    /**
     *
     * @var string
     */
    public $lv_exp;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("user_lv");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user_lv';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserLv[]|UserLv|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserLv|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
