<?php

class MmShopRights extends ModelBase
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
     * @Column(column="sid", type="integer", length=255, nullable=true)
     */
    public $sid;

    /**
     *
     * @var string
     * @Column(column="rjson", type="string", nullable=true)
     */
    public $rjson;

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
        $this->setSource("mm_shop_rights");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'mm_shop_rights';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MmShopRights[]|MmShopRights|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MmShopRights|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    
    //----------
    // 自定义
    //----------
    /**
     * 获取店铺所有权限
     */
    public static function shopRirghts($sid=0){
    	$shop= '';
    	if ($sid > 0){//查询店铺是否存在
    		$shop = Shangchang::findFirstById($sid);
    		
    		if (!$shop || !count($shop)) return 'SHOP_NO_EXIST';//代理商不存在
    	}
    	
    	$rights = array();//所有权限
    	if ($shop && $shop->sc_type=='ST0'){//判断是否是开发者或自营
    		$apps = MmApps::getApps(array(//查询所有应用 status='S1'
    				'conditions'=> "status=?1",
    				'bind'		=> array(1=>'S1')
    		));
    		
    		$pidArr = array(); $aoArr = array();
    		foreach ($apps as $k=>$v){
    			if (!in_array($v->id, $pidArr) && $v->pid==0) {//判断pid
    				array_push($pidArr, $v->id);
    				$aoArr[$v->id] = array();
    			}
    			
    			if ($v->pid > 0){//二级菜单获取操作码
    				$aos = $v->MmAppOpcode;
    				if ($aos && count($aos)){//获取应用所有操作码
    					$aoArr[$v->pid]['paid'] = $v->pid;
    					if (!isset($aoArr[$v->pid]['aids'])) $aoArr[$v->pid]['aids'] = array();
    					array_push($aoArr[$v->pid]['aids'], $v->id);
    					$aoArr[$v->pid]['oids'][$v->id] = explode(',', trim($aos->oids, ','));
    				}else unset($aos[$v->id]);
    			}
    		}
    		foreach ($aoArr as $k=>$v){
    			array_push($rights, $v);
    		}
    	}else {
    		$sr = $shop->MmShopRights;//查询
    		
    		if (!$sr || $ar->satus=='S2'){//不存在单个店铺权限或禁用单个店铺权限
    			$sr = self::findFirstBySid(0);
    			
    			if ($sr && count($sr)) $rights = json_decode($sr->rjson, true);
    		}
    	}
    	return $rights;
    }
    
    /**
     * 获取入驻店铺所有权限(不包括总代理商)
     */
    public static function shopAllRights(){
    	$rights = array();
    	$ar = self::findFirstBySid(0);
    	
    	if ($ar && count($ar)) $rights = json_decode($ar->rjson, true);
    	
    	return $rights;
    }
    
    /**
     * 店铺权限编辑
     */
    public static function shopRightEdit($sid=0, $rjson=''){
    	$sr = self::findFirstBySid($sid);
    	if (!$sr || !count($sr->toArray())) {
    		$sr= new MmShopRights();
    		$sr->sid = 0;
    	}
    	$sr->rjson = $rjson;
    	if ($sr->save()) return 'SUCCESS';
    	else return 'OPEFILE';
    }
    
    
}
