<?php

class ShopConfig extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $shop_id;

    /**
     *
     * @var string
     */
    public $lv_1_name;

    /**
     *
     * @var integer
     */
    public $lv_1_discount;

    /**
     *
     * @var string
     */
    public $lv_1_exp;

    /**
     *
     * @var string
     */
    public $lv_2_name;

    /**
     *
     * @var integer
     */
    public $lv_2_discount;

    /**
     *
     * @var string
     */
    public $lv_2_exp;

    /**
     *
     * @var string
     */
    public $lv_3_name;

    /**
     *
     * @var integer
     */
    public $lv_3_discount;

    /**
     *
     * @var string
     */
    public $lv_3_exp;

    /**
     *
     * @var string
     */
    public $lv_4_name;

    /**
     *
     * @var integer
     */
    public $lv_4_discount;

    /**
     *
     * @var string
     */
    public $lv_4_exp;

    /**
     *
     * @var string
     */
    public $lv_5_name;

    /**
     *
     * @var integer
     */
    public $lv_5_discount;

    /**
     *
     * @var string
     */
    public $lv_5_exp;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("shop_config");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'shop_config';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ShopConfig[]|ShopConfig|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ShopConfig|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function getShopConf($shop_id){
        $lv = UserLv::find()->toArray();
        $shop_config = ShopConfig::findFirst("shop_id = $shop_id");

        $lv_array = array();
        foreach ($lv as $k => $v) {
            $lv_array[$v['lv_id']] = array(
                'lv'=>$v['lv_id'],
                'name'=>$shop_config['lv_'.$v['lv_id'].'_name']? $shop_config['lv_'.$v['lv_id'].'_name']:$v['lv_name'],
                'discount'=>$shop_config['lv_'.$v['lv_id'].'_discount']? $shop_config['lv_'.$v['lv_id'].'_discount']:100,
                'need_exp'=>$shop_config['lv_'.$v['lv_id'].'_exp'],
            );

            unset($shop_config['lv_'.$v['lv_id'].'_name']);
            unset($shop_config['lv_'.$v['lv_id'].'_discount']);
            // unset($shop_config['lv_'.$v['lv_id'].'_exp']);
        }
        $shop_config['lv_info'] = $lv_array;

        return $shop_config;
    }
}
