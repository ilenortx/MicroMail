<?php

class GroupBooking extends ModelBase
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
     * @Column(column="gbname", type="string", length=16, nullable=true)
     */
    public $gbname;
    
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
     * @var integer
     * @Column(column="pid", type="integer", length=255, nullable=true)
     */
    public $pid;

    /**
     *
     * @var integer
     * @Column(column="mannum", type="integer", length=2, nullable=true)
     */
    public $mannum;

    /**
     *
     * @var integer
     * @Column(column="gbtime", type="integer", length=2, nullable=true)
     */
    public $gbtime;

    /**
     *
     * @var integer
     * @Column(column="gbnum", type="integer", length=2, nullable=true)
     */
    public $gbnum;

    /**
     *
     * @var string
     * @Column(column="gbprice", type="string", length=10, nullable=true)
     */
    public $gbprice;

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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("group_booking");
        
        $this->hasOne("pid", "Product", "id");
        $this->hasMany("id", "GroupBookingList", "gb_id");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'group_booking';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return GroupBooking[]|GroupBooking|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return GroupBooking|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    
    
    
    //----------
    // 自定义
    //----------
    /**
     * 获取拼团
     */
    public static function getGb($type='id', $params, $verify=true){
    	if ($type == 'id'){//团购id
    		$gb = self::findFirst("id=$params");
    		
    		if ($gb) {
    			if ($verify) $gb = self::gbVerify($gb);
    			
    			return $gb;
    		}else return 'DATAEXCEPTION';
    	}
    }
    public static function getGbs($type='id', $params, $verify=true){
    	
    }
    public static function getGbsArr($conditions, $verify=true){
    	$gbs = self::find($conditions);
    	
    	if ($gbs){
    		$gbsArr = array();
    		if ($verify){
    			foreach ($gbs as $k=>$v){
    				$gbsArr[$k] = self::gbVerify($v)->toArray();
    			}
    		}else $gbsArr = $gbs->toArray();
    		
    		return $gbsArr;
    	}else return 'DATAEXCEPTION';
    }
    
    
    /**
     * 团购验证
     * @param GroupBooking $gb
     */
    public static function gbVerify($gb){
    	if ($gb->status != 'S0'){
    		$time = time();
    		if ($gb->stime>$time && $gb->status!='S1'){//未开始
    			$gb->status = 'S1'; $gb->save();
    		}else if ($gb->stime<$time && $gb->etime>$time && $gb->status=='S1'){
    			$gb->status = 'S2'; $gb->save();
    		}else if ($gb->etime<$time || $gb->status=='S3'){//结束
    			if ($gb->status!='S3'){$gb->status = 'S3'; $gb->save();}
    			
    			$pros = Product::hdPros(2, $gb->id);//商品活动
    			if (Product::isObject($pros)){
    				foreach ($pros as $k){
    					$k->hd_id = 0; $k->hd_type = '0'; $k->save();
    				}
    			}
    			
    			$gbl = GroupBookingList::getGbls('gbid', array('gbid'=>$gb->id, 'status'=>"status in('S1','S2')"), false);
    			if (self::isObject($gbl)){
    				foreach ($gbl as $k){
    					$k->status = 'S3'; $k->save();
    					$orders = GroupBookingList::gblOrders($k->id);//订单
    					if (Order::isObject($orders)){
    						foreach ($orders as $k){
    							//退款处理
    							Order::orTaskQueue($k);
    							
    							if ($k->status>0 && $k->status != 90){//设置订单状态为90(交易失败)
    								$k->status = 90; $k->save();
    							}
    						}
    					}
    				}
    			}
    		}else if ($gb->status=='S2'){//进行中
    			$gbl = GroupBookingList::getGbls('gbid', array('gbid'=>$gb->id, 'status'=>"status in('S1','S2')"));
    		}
    	}
    	return $gb;
    }
}
