<?php

class Promotion extends ModelBase
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
     * @Column(column="name", type="string", length=20, nullable=true)
     */
    public $name;

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
     * @var string
     * @Column(column="pprice", type="string", length=10, nullable=true)
     */
    public $pprice;
    
    /**
     *
     * @var integer
     * @Column(column="num", type="integer", length=255, nullable=true)
     */
    public $num;
    
    /**
     *
     * @var integer
     * @Column(column="maxnum", type="integer", length=255, nullable=true)
     */
    public $maxnum;

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
        $this->setSource("promotion");
        
        $this->hasOne("pro_id", "Product", "id");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'promotion';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Promotion[]|Promotion|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Promotion|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    
    //----------
    // 自定义
    //----------
    /**
     * 获取秒杀
     */
    public static function getSk($type='id', $params, $verify=true){
    	if ($type == 'id'){//秒杀id
    		$sk = self::findFirst("id=$params");
    		
    		if ($sk) {
    			if ($verify) $sk = self::skVerify($sk);
    			
    			return $sk;
    		}else return 'DATAEXCEPTION';
    	}
    	
    }
    public static function getSksArr($conditions, $verify=true){
    	$sks = self::find($conditions);
    	
    	if ($sks){
    		$sksArr = array();
    		if ($verify){
    			foreach ($sks as $k=>$v){
    				$sksArr[$k] = self::skVerify($v)->toArray();
    			}
    		}else $sksArr = $sks->toArray();
    		
    		return $sksArr;
    	}else return 'DATAEXCEPTION';
    }
    
    /**
     * 秒杀验证
     * @param unknown $sk
     * @return Promotion
     */
    public static function skVerify($sk){
    	if ($sk->status!='S0'){//未删除
    		$time = time();
    		if ($sk->stime>$time && $sk->status!='S1'){//未开始
    			$sk->status = 'S1'; $sk->save();
    		}else if ($sk->stime<$time && $sk->etime>$time && $sk->status=='S1'){
    			$sk->status = 'S2'; $sk->save();
    		}else if ($sk->etime<$time || $sk->status=='S3'){//结束
    			if ($sk->status!='S3'){ $sk->status = 'S3'; $sk->save(); }
    			
    			$pros = Product::hdPros(1, $sk->id);//商品活动
    			if (Product::isObject($pros)){
    				foreach ($pros as $k){
    					$k->hd_id = 0; $k->hd_type = '0'; $k->save();
    				}
    			}
    			
    			$orders = Order::hdOrders(2, $sk->id, 10);//订单
    			if (Order::isObject($orders)){
    				foreach ($orders as $k){
    					$k->status = 90; $k->save();//设置订单状态为90(交易失败)
    				}
    			}
    		}
    	}
    	return $sk;
    }
}
