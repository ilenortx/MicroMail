<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class Notice extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=16, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(column="title", type="string", length=16, nullable=true)
     */
    public $title;

    /**
     *
     * @var string
     * @Column(column="context", type="string", nullable=true)
     */
    public $content;

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
     *
     * @var integer
     * @Column(column="position", type="integer", length=4, nullable=true)
     */
    public $position;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("notice");
        
        $this->addBehavior(new SoftDelete(
        	array(
        		'field' => 'status',
        		'value' => 'S0'
        	)
        ));
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'notice';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Notice[]|Notice|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Notice|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
