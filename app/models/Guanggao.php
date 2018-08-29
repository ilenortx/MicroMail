<?php

class Guanggao extends \Phalcon\Mvc\Model
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
     * @var string
     * @Column(column="name", type="string", length=20, nullable=true)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="photo", type="string", length=100, nullable=true)
     */
    public $photo;

    /**
     *
     * @var integer
     * @Column(column="addtime", type="integer", length=11, nullable=false)
     */
    public $addtime;

    /**
     *
     * @var integer
     * @Column(column="sort", type="integer", length=11, nullable=false)
     */
    public $sort;

    /**
     *
     * @var string
     * @Column(column="type", type="string", nullable=true)
     */
    public $type;

    /**
     *
     * @var string
     * @Column(column="action", type="string", length=255, nullable=false)
     */
    public $action;

    /**
     *
     * @var integer
     * @Column(column="position", type="integer", length=2, nullable=true)
     */
    public $position;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("guanggao");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'guanggao';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Guanggao[]|Guanggao|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Guanggao|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
