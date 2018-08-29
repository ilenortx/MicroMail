<?php

class CutPriceSpritesFriends extends \Phalcon\Mvc\Model
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
     * @Column(column="cp_id", type="integer", length=255, nullable=false)
     */
    public $cp_id;

    /**
     *
     * @var string
     * @Column(column="openid", type="string", length=255, nullable=true)
     */
    public $openid;

    /**
     *
     * @var string
     * @Column(column="fname", type="string", length=20, nullable=true)
     */
    public $fname;

    /**
     *
     * @var string
     * @Column(column="avatar", type="string", nullable=true)
     */
    public $avatar;

    /**
     *
     * @var string
     * @Column(column="time", type="string", nullable=true)
     */
    public $time;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("cut_price_sprites_friends");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'cut_price_sprites_friends';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return CutPriceSpritesFriends[]|CutPriceSpritesFriends|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return CutPriceSpritesFriends|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
