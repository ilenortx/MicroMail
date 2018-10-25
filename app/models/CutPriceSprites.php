<?php

class CutPriceSprites extends ModelBase
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
     * @Primary
     * @Identity
     * @Column(column="shop_id", type="integer", length=255, nullable=false)
     */
    public $shop_id;
    
    /**
     *
     * @var string
     * @Column(column="name", type="string", length=18, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="stime", type="string", length=16, nullable=false)
     */
    public $stime;

    /**
     *
     * @var string
     * @Column(column="etime", type="string", length=16, nullable=false)
     */
    public $etime;

    /**
     *
     * @var string
     * @Column(column="cptype", type="string", nullable=false)
     */
    public $cptype;

    /**
     *
     * @var integer
     * @Column(column="friends", type="integer", length=3, nullable=false)
     */
    public $friends;

    /**
     *
     * @var integer
     * @Column(column="low_price", type="integer", length=125, nullable=false)
     */
    public $low_price;

    /**
     *
     * @var string
     * @Column(column="pro_ids", type="string", length=255, nullable=false)
     */
    public $pro_ids;

    /**
     *
     * @var string
     * @Column(column="addtime", type="string", length=16, nullable=false)
     */
    public $addtime;

    /**
     *
     * @var string
     * @Column(column="status", type="string", nullable=false)
     */
    public $status;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("cut_price_sprites");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'cut_price_sprites';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return CutPriceSprites[]|CutPriceSprites|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return CutPriceSprites|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    
    //----------
    // 自定义
    //----------
    /**
     * 获取砍价
     * @param string $type
     * @param unknown $params
     * @param string $verify
     * @return CutPriceSprites|string
     */
    public static function getCp($type='cpid', $params, $verify=true){
    	if ($type == 'cpid'){
    		$cp = self::findFirstById($params);
    		
    		if ($cp){
    			if ($verify) $cp = self::cpVerify($cp);
    			
    			return $cp;
    		}else return 'DATAEXCEPTION';
    	}
    	
    }
    public static function getCps($type='cpid', $params){
    	
    }
    public static function getCpsArr($conditions, $verify=true){
    	$cps = self::find($conditions);
    	
    	if ($cps){
    		$cpsArr = array();
    		if ($verify){
    			foreach ($cps as $k=>$v){
    				$cpsArr[$k] = self::cpVerify($v)->toArray();
    			}
    		}else $cpsArr = $cps->toArray();
    		
    		return $cpsArr;
    	}else return 'DATAEXCEPTION';
    }
    
    
    /**
     * 砍价验证
     * @param CutPriceSprites $cp
     */
    public static function cpVerify($cp){
    	$time = time();
    	if ($cp->status != 'S0'){
    		if ($cp->stime>$time && $cp->status!='S1'){//未开始
    			$cp->status = 'S1'; $cp->save();
    		}else if ($cp->stime<$time && $cp->etime>$time && $cp->status=='S1'){
    			$cp->status = 'S2'; $cp->save();
    		}else if ($cp->etime<$time || $cp->status=='S3'){//结束
    			if ($cp->status!='S3'){ $cp->status = 'S3'; $cp->save(); }
    			
    			$pros = Product::hdPros(2, $gb->id);//商品活动
    			if (Product::isObject($pros)){
    				foreach ($pros as $k){
    					$k->hd_id = 0; $k->hd_type = '0'; $k->save();
    				}
    			}
    			
    			$cpl = CutPriceSpritesList::getCpls('cpid', $cp->id);//用户砍价
    			if (self::isObject($cpl)){
    				foreach ($cpl as $k){
    					if ($k->cp_result == '1'){
    						$k->status = 'S2'; $k->cp_result = '2'; $k->save();
    					}
    				}
    			}
    			
    		}else {
    			$cpl = CutPriceSpritesList::getCpls('cpid', $cp->id);//用户砍价
    		}
    	}
    	return $cp;
    }
    
}
