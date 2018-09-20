<?php

class LogisticsShop extends \Phalcon\Mvc\Model
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
     * @Column(column="shop_id", type="integer", length=255, nullable=true)
     */
    public $shop_id;
    
    /**
     *
     * @var string
     * @Column(column="code", type="string", length=10, nullable=true)
     */
    public $code;
    
    /**
     *
     * @var string
     * @Column(column="name", type="string", length=32, nullable=true)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="description", type="string", length=255, nullable=true)
     */
    public $description;

    /**
     *
     * @var string
     * @Column(column="printkd", type="string", nullable=true)
     */
    public $printkd;

    /**
     *
     * @var string
     * @Column(column="remark", type="string", nullable=true)
     */
    public $remark;

    /**
     *
     * @var integer
     * @Column(column="sort", type="integer", length=6, nullable=true)
     */
    public $sort;

    /**
     *
     * @var string
     * @Column(column="default", type="string", nullable=true)
     */
    public $default;

    /**
     *
     * @var string
     * @Column(column="status", type="string", nullable=true)
     */
    public $status;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("logistics_company");
        
        $this->hasOne('shop_id', 'Shangchang', 'id');
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'logistics_shop';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return LogisticsShop[]|LogisticsShop|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return LogisticsShop|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    
    //---------
    // 自定义
    //---------
    /**
     * 查询店铺所有物流公司
     */
    public static function shopAllWl($sid=0){
    	if (empty($sid)) return 'DATAERR';
    	
    	$lcs = LogisticsShop::find("shop_id=$sid and status='S1'");
    	
    	if ($lcs) return $lcs->toArray();
    	else return 'DATAEXCEPTION';
    }
    
    /**
     * 添加物流公司
     */
    public static function saveLogistics($params, $id){
    	if ($id){
    		$wl = LogisticsShop::findFirst($id);
    	}else {
    		$wl= new LogisticsShop();
    	}
    	
    	if ($params['default']){
    		if (!self::cancelDefault($params['shop_id'])) return 'OPEFILE';
    	}
    	
    	$wl->shop_id = $params['shop_id'];
    	$wl->code = $params['code'];
    	$wl->name = $params['name'];
    	$wl->description = $params['description'];
    	$wl->printkd = $params['printkd'];
    	$wl->remark = $params['remark'];
    	$wl->sort = $params['sort'];
    	$wl->default =  $params['default']?'D1':'D0';
    	
    	if ($wl->save()) return 'SUCCESS';
    	else return 'OPEFILE';
    }
    
    /**
     * 取消所有默认
     */
    public static function cancelDefault($sid){
    	$sas = LogisticsShop::find("shop_id=$sid");
    	if ($sas){
    		foreach ($sas as $k=>$v){
    			$v->default = 'D0'; if (!$v->save()) return false;
    		}
    	}
    	
    	return true;
    }
    
    /**
     * 删除
     */
    public static function delLogistics($id, $sid){
    	$lc = LogisticsShop::findFirst("id=$id and shop_id=$sid");
    	
    	if ($lc){
    		if ($lc->delete()) return 'SUCCESS';
    		else return 'OPEFILE';
    	}else return 'DATAEXCEPTION';
    }
    
    /**
     * 获取物流公司信息
     */
    public static function lcInfo($id, $sid, $shopInfo=false){
    	$lc = LogisticsShop::findFirst("id=$id and shop_id=$sid");
    	
    	if ($lc) {
    		if ($shopInfo){
    			$si = $lc->Shangchang;
    			$lc = $lc->toArray();
    			
    			$lc['shopInfo'] = $si->toArray();
    		}else $lc = $lc->toArray();
    		return $lc;
    	}else return 'DATAEXCEPTION';
    }
    
}
