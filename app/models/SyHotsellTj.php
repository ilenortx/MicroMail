<?php

class SyHotsellTj extends \Phalcon\Mvc\Model
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
     * @Column(column="shop_id", type="integer", length=255, nullable=false)
     */
    public $shop_id;

    /**
     *
     * @var string
     * @Column(column="zphoto", type="string", length=255, nullable=true)
     */
    public $zphoto;

    /**
     *
     * @var integer
     * @Column(column="zproid", type="integer", length=255, nullable=true)
     */
    public $zproid;

    /**
     *
     * @var string
     * @Column(column="rtphoto", type="string", length=255, nullable=true)
     */
    public $rtphoto;

    /**
     *
     * @var integer
     * @Column(column="rtproid", type="integer", length=255, nullable=true)
     */
    public $rtproid;

    /**
     *
     * @var string
     * @Column(column="rbphoto", type="string", length=255, nullable=true)
     */
    public $rbphoto;

    /**
     *
     * @var integer
     * @Column(column="rbproid", type="integer", length=255, nullable=true)
     */
    public $rbproid;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("sy_hotsell_tj");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sy_hotsell_tj';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SyHotsellTj[]|SyHotsellTj|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SyHotsellTj|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
