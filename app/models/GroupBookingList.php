<?php

class GroupBookingList extends ModelBase
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
     * @Column(column="gb_id", type="integer", length=255, nullable=true)
     */
    public $gb_id;

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
     * @Column(column="mans", type="integer", length=4, nullable=true)
     */
    public $mans;

    /**
     *
     * @var string
     * @Column(column="stime", type="string", length=16, nullable=true)
     */
    public $stime;

    /**
     *
     * @var string
     * @Column(column="etime", type="string", length=16, nullable=true)
     */
    public $etime;

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
        $this->setSource("group_booking_list");
        
        $this->hasOne("uid", "User", "id");
        $this->hasOne("pro_id", "Product", "id");
        $this->hasOne('gb_id', 'GroupBooking', 'id');
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'group_booking_list';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return GroupBookingList[]|GroupBookingList|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return GroupBookingList|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    
    //----------
    // 自定义
    //----------
    /**
     * 获取团购列表
     */
    public static function getGbl($type='gblid', $params, $verify=true){
    	if ($type == 'gblid'){	
    		$gbl = self::findFirst(array(
    				'conditions'=>"id=?1", 'bind'=>array(1=>$params)
    		));
    				
    		if ($gbl) {
    			if ($verify) $gbl = self::gblVerify($gbl);
    			return $gbl;
    		}
    		else return 'DATAEXCEPTION';
    	}else if ($type == 'ugbid'){
    		if (!isset($params['uid']) || empty($params['uid']) || 
    				!isset($params['gbid']) || empty($params['gbid'])) return 'DATAERR';
    		
    		$gbl = self::findFirst(array(
    				'conditions'=>"uid=?1 and gb_id=?2", 'bind'=>array(1=>$params['uid'], 2=>$params['gbid'])
    		));
    		
    		if ($gbl) {
    			if ($verify) $gbl = self::gblVerify($gbl);
    			return $gbl;
    		}
    		else return 'DATAEXCEPTION';
    	}
    }
    public static function getGbls($type='gbid', $params, $verify=true){
    	if ($type == 'gbid'){
    		if (!isset($params['gbid']) || empty($params['gbid']) || 
    				!isset($params['status']) || empty($params['status'])) return 'DATAERR';
    		
    		$status = $params['status']=='all' ? "status!='S0'" : $params['status'];
    		$gbls = self::find(array(
    				'conditions'=> "gb_id=?1 and $status",
    				'bind'		=> array(1=>$params['gbid'])
    		));
    		
    		if ($gbls) {
    			if ($verify){//验证
    				foreach ($gbls as $k=>$v){ self::gblVerify($v); }
    			}
    			return $gbls;
    		}
    		else return 'DATAEXCEPTION';
    	}
    	
    }
    
    /**
     * 团购列表验证
     * @param GroupBookingList $gbl
     */
    public static function gblVerify($gbl){
    	$gblStatus = 'S0';
    	if ($gbl->status != 'S0'){
    		if (($gbl->etime<time()&&($gbl->status=='S1'||$gbl->status=='S2')) || $gbl->status=='S4'){//结束
    			if ($gbl->status!='S4'){ $gbl->status = 'S4'; $gbl->save(); }
    			
    			$orders = self::gblOrders($gbl->id);//订单
    			if (Order::isObject($orders)){
    				foreach ($orders as $k){
    					//退款处理
    					Order::orTaskQueue($k);
    					
    					if ($k->status>0 && $k->status!=90){//设置订单状态为90(交易失败)
    						$k->status = 90; $k->save();
    					}
    				}
    			}
    		}
    	}
    	return $gbl;
    }
    
    /**
     * 查询团购活动订单
     */
    public static function gblOrders($gblid, $status='all'){
    	$orders = Order::hdOrders(3, $gblid, $status);//订单
    	return $orders;
    }
    
    
    /**
     * 新增团购
     * @param string $type gb GroupBooking、 bgid 
     * @param unknown $gbp
     * @param unknown $uid
     * @param unknown $proId
     * @return GroupBookingList|string
     */
    public static function addGbl($type='gb', $gbp, $uid, $proId){
    	if ($type == 'gb') $gbi = $gbp;
    	else if ($type == 'gbid') $gbi = GroupBooking::getGb('id', $gbp);
    	
    	if ($gbi && count($gbi)){
    		$etime = (time()+($gbi->gbtime*3600))<$gbi->etime ? time()+($gbi->gbtime*3600) : $gbi->etime;
    		$gbl = new GroupBookingList();
    		$gbl->gb_id = $gbi->id;
    		$gbl->pro_id = $proId;
    		$gbl->uid = $uid;
    		$gbl->stime = time();
    		$gbl->etime = $etime;
    		$gbl->mans = 0;
    		$gbl->status = 'S1';
    		
    		if ($gbl->save()) return $gbl;
    		else return 'OPEFILE';
    	}else return 'DATAEXCEPTION';
    }
    
}
