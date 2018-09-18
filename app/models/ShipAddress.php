<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class ShipAddress extends \Phalcon\Mvc\Model
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
     * @Column(column="area_ids", type="string", length=125, nullable=true)
     */
    public $area_ids;

    /**
     *
     * @var string
     * @Column(column="address", type="string", length=255, nullable=true)
     */
    public $address;

    /**
     *
     * @var string
     * @Column(column="postcode", type="string", length=16, nullable=true)
     */
    public $postcode;

    /**
     *
     * @var string
     * @Column(column="tel", type="string", length=16, nullable=true)
     */
    public $tel;

    /**
     *
     * @var string
     * @Column(column="fhname", type="string", length=16, nullable=true)
     */
    public $fhname;

    /**
     *
     * @var string
     * @Column(column="default", type="string", nullable=true)
     */
    public $default;
    
    /**
     *
     * @var integer
     * @Column(column="sort", type="integer", length=16, nullable=true)
     */
    public $sort;
    
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
        $this->setSource("ship_address");
        
        $this->addBehavior(new SoftDelete(
        	array( 'field' => 'status', 'value' => 'S0' )
        ));
        
        $this->hasOne("shop_id", "Shangchang", "id");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'ship_address';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ShipAddress[]|ShipAddress|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ShipAddress|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    
    
    
    //----------
    // 自定义
    //----------
    /**
     * 获取发货地址
     */
    public static function getSAs($type='sid', $sid, $params, $isShopInfo=false){
    	$saArr = array();
    	if ($type == 'sid'){//店铺所有
    		if (empty($sid)) return 'DATAERR';
    		
    		$conditions = array();
    		if (isset($params['conditions'])) $conditions['conditions'] = $params['conditions'];
    		else $conditions['conditions'] = "shop_id=$sid and status='S1'";
    		
    		if (isset($params['limit'])) $conditions['limit'] = $params['limit'];
    		if (isset($params['order'])) $conditions['order'] = $params['order'];
    		
    		$sas = ShipAddress::find($conditions);
    		
    		$shop = array();
    		if ($sas){
    			foreach ($sas as $k=>$v){
    				$aname = Area::getNamesByIds(trim($v->area_ids, ','));
    				
    				$saArr[$k] = $v->toArray();
    				if ($saArr[$k]['default']=='D1') $saArr[$k]['defaultInfo'] = '是';
    				else $saArr[$k]['defaultInfo'] = '';
    				$saArr[$k]['aname'] = $aname;
    				
    				if ($isShopInfo){
    					if (!isset($shop[$v->shop_id]))$shop[$v->shop_id] = $v->Shangchang->toArray();
    				}
    			}
    			
    			if ($isShopInfo) $saArr['shops'] = $shop;
    			
    			return $saArr;
    		}else return 'DATAEXCEPTION';
    	}else return 'DATAERR';
    }

    /**
     * 修改发货地址
     */
    public static function saveSa($params, $id=0){
    	if ($id){
    		$sa = ShipAddress::findFirst($id);
    	}else {
    		$sa = new ShipAddress();
    	}
    	
    	if ($params['default']){
    		if (!self::cancelDefault($params['shop_id'])) return 'OPEFILE';
    	}
    	
    	$sa->shop_id = $params['shop_id'];
    	$sa->area_ids = $params['area_ids'];
    	$sa->address = $params['address'];
    	$sa->postcode = $params['postcode'];
    	$sa->tel = $params['tel'];
    	$sa->fhname = $params['fhname'];
    	$sa->default = $params['default']?'D1':'D0';
    	
    	if ($sa->save()) return 'SUCCESS';
    	else return 'OPEFILE';
    }
    	
    /**
     * 取消所有默认
     */
    public static function cancelDefault($sid){
    	$sas = ShipAddress::find("shop_id=$sid");
    	if ($sas){
    		foreach ($sas as $k=>$v){
    			$v->default = 'D0'; if (!$v->save()) return false;
    		}
    	}
    	
    	return true;
    }
    
    /**
     * 删除发货地址
     */
    public static function delSa($id, $sid){
    	$sa = ShipAddress::findFirst("id=$id and shop_id=$sid");
    	
    	if ($sa){
    		if($sa->delete()) return 'SUCCESS';
    		else return 'OPEFILE';
    	}else return 'DATAEXCEPTION';
    }
    
    /**
     * 获取单个发货地址信息
     */
    public static function saInfo($id, $sid){
    	$sa = ShipAddress::findFirst("id=$id and shop_id=$sid");
    	
    	if ($sa){
    		$aids = explode(',', trim($sa->area_ids, ','));
    		$sheng = Area::getAPCByPid(0, $aids[0]);
    		$shi = Area::getAPCByPid($aids[0], $aids[1]);
    		$qu = Area::getAPCByPid($aids[1], $aids[2]);
    		
    		if (count($aids)==4) $jd = Area::getAPCByPid($aids[2], $aids[3]);
    		else $jd = Area::getAPCByPid($aids[2]);
    		
    		return array('sheng'=>$sheng, 'shi'=>$shi, 'qu'=>$qu, 'jd'=>$jd, 'addressInfo'=>$sa->toArray());
    	}else array('sheng'=>array(), 'shi'=>array(), 'qu'=>array(), 'jd'=>array(), 'addressInfo'=>array(
    			'shop_id'=>'', 'area_ids'=>'', 'address'=>'', 'postcode'=>'','tel'=>'',
    			'fhname'=>'', 'default'=>'D0'
    	));
    }
    
    /**
     * 获取多个发货地址信息
     */
    public static function sasInfo($sid, $params=array()){
    	if (empty($sid)) return 'DATAERR';
    	
    	$conditions = array('conditions'=>"shop_id=$sid");
    	if (isset($params['conditions']) && !empty($params['conditions'])){
    		$conditions['conditions'] .= " and ".$params['conditions'];
    	}
    	
    }
    
}
