<?php

class ProductSku extends ModelBase
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
     * @var string
     * @Column(column="skuid", type="string", length=255, nullable=false)
     */
    public $skuid;

    /**
     *
     * @var integer
     * @Column(column="pid", type="integer", length=255, nullable=true)
     */
    public $pid;

    /**
     *
     * @var string
     * @Column(column="price", type="string", length=10, nullable=true)
     */
    public $price;

    /**
     *
     * @var integer
     * @Column(column="stock", type="integer", length=255, nullable=true)
     */
    public $stock;

    /**
     *
     * @var string
     * @Column(column="addtime", type="string", length=16, nullable=true)
     */
    public $addtime;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("product_sku");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'product_sku';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProductSku[]|ProductSku|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProductSku|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    
    //----------
    // 自定义
    //----------
    /**
     * 获取sku
     */
    public static function getSku($type='id', $params){
    	if ($type == 'id'){
    		$sku = self::findFirst("id=$params");
    	}else if ($type == 'spid'){//skuid+pid
    		if (!isset($params['skuid'])||empty($params['skuid']) || 
    				!isset($params['pid'])||empty($params['pid'])) return 'DATAERR';
    		
    		$sku = self::findFirst(array(
    				'conditions'=> "skuid=?1 and pid=?2",
    				'bind'		=> array(1=>trim($params['skuid'], ','), 2=>intval($params['pid']))
    		));
    	}
    	
    	if ($sku && $sku->count()) return $sku;
    	else return 'DATAEXCEPTION';
    }
    public static function getSkus($conditions){
    	$sku = self::find($conditions);
    	
    	if ($sku && $sku->count()) return $sku;
    	else return 'DATAEXCEPTION';
    }
    
    /**
     * 判断库存
     */
    public static function skuStock(){
    	
    }
    
}
