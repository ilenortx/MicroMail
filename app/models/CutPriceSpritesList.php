<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class CutPriceSpritesList extends ModelBase
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
     * @Column(column="cp_id", type="integer", length=255, nullable=true)
     */
    public $cp_id;

    /**
     *
     * @var integer
     * @Column(column="shop_id", type="integer", length=255, nullable=true)
     */
    public $shop_id;

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
     * @Column(column="cpnum", type="integer", length=125, nullable=true)
     */
    public $cpnum;
    
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
     * @var string
     * @Column(column="cp_result", type="string", nullable=true)
     */
    public $cp_result;
    
    /**
     *
     * @var string
     * @Column(column="skuid", type="string", nullable=true)
     */
    public $skuid;
    
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("cut_price_sprites_list");
        
        $this->hasOne("cp_id", "CutPriceSprites", "id");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'cut_price_sprites_list';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return CutPriceSpritesList[]|CutPriceSpritesList|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return CutPriceSpritesList|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    
    
    //----------
    // 自定义
    //----------
    /**
     * 获取砍价列表
     */
    public static function getCpl($type='cplid', $params){
    	if ($type == 'cplid'){
    		$cpl = self::findFirst("id=$params");
    		if ($cpl){
    			
    		}return false;
    	}
    	
    }
    public static function getCpls($type='cpid', $params){
    	if ($type == 'cpid'){
    		$cpls = self::find("cp_id=$params");//用户砍价
    		
    		if ($cpls) return $cpls;
    		else return 'DATAEXCEPTION';
    	}
    	
    }
}
