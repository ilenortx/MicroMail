<?php

class NoticeConfig extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="id", type="integer", length=16, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(column="bgcolor", type="string", length=255, nullable=true)
     */
    public $bgcolor;

    /**
     *
     * @var string
     * @Column(column="color", type="string", length=255, nullable=true)
     */
    public $color;

    /**
     *
     * @var string
     * @Column(column="speed", type="string", nullable=true)
     */
    public $speed;

    /**
     *
     * @var string
     * @Column(column="direction", type="string", nullable=true)
     */
    public $direction;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("notice_config");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'notice_config';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return NoticeConfig[]|NoticeConfig|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return NoticeConfig|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
