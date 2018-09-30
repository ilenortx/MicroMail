<?php

class Order extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="fxs_id", type="integer", length=255, nullable=false)
     */
    public $fxs_id;

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="fxtc", type="double", length=0, nullable=true)
     */
    public $fxtc;

    /**
     *
     * @var string
     * @Column(column="order_sn", type="string", length=20, nullable=false)
     */
    public $order;

    /**
     *
     * @var string
     * @Column(column="order_sn", type="string", length=20, nullable=false)
     */
    public $order_sn;

    /**
     *
     * @var string
     * @Column(column="pay_sn", type="string", length=20, nullable=true)
     */
    public $pay_sn;

    /**
     *
     * @var integer
     * @Column(column="shop_id", type="integer", length=11, nullable=false)
     */
    public $shop_id;

    /**
     *
     * @var integer
     * @Column(column="uid", type="integer", length=11, nullable=false)
     */
    public $uid;

    /**
     *
     * @var double
     * @Column(column="price", type="double", length=9, nullable=false)
     */
    public $price;

    /**
     *
     * @var double
     * @Column(column="amount", type="double", length=9, nullable=true)
     */
    public $amount;

    /**
     *
     * @var double
     * @Column(column="price_h", type="double", length=9, nullable=false)
     */
    public $price_h;

    /**
     *
     * @var double
     * @Column(column="total_fee", type="double", length=9, nullable=false)
     */
    public $total_fee;

    /**
     *
     * @var string
     * @Column(column="addtime", type="string", length=16, nullable=false)
     */
    public $addtime;

    /**
     *
     * @var string
     * @Column(column="addtime", type="string", length=16, nullable=true)
     */
    public $paytime;

    /**
     *
     * @var string
     * @Column(column="addtime", type="string", length=16, nullable=true)
     */
    public $fhtime;

    /**
     *
     * @var string
     * @Column(column="addtime", type="string", length=16, nullable=true)
     */
    public $finishtime;

    /**
     *
     * @var integer
     * @Column(column="del", type="integer", length=2, nullable=false)
     */
    public $del;

    /**
     *
     * @var string
     * @Column(column="type", type="string", nullable=true)
     */
    public $type;

    /**
     *
     * @var integer
     * @Column(column="status", type="integer", length=2, nullable=false)
     */
    public $status;

    /**
     *
     * @var integer
     * @Column(column="vid", type="integer", length=11, nullable=true)
     */
    public $vid;

    /**
     *
     * @var string
     * @Column(column="receiver", type="string", length=15, nullable=false)
     */
    public $receiver;

    /**
     *
     * @var string
     * @Column(column="tel", type="string", length=15, nullable=false)
     */
    public $tel;

    /**
     *
     * @var string
     * @Column(column="address_xq", type="string", length=50, nullable=false)
     */
    public $address_xq;

    /**
     *
     * @var integer
     * @Column(column="code", type="integer", length=11, nullable=false)
     */
    public $code;

    /**
     *
     * @var integer
     * @Column(column="post", type="integer", length=11, nullable=true)
     */
    public $post;

    /**
     *
     * @var string
     * @Column(column="remark", type="string", length=255, nullable=true)
     */
    public $remark;

    /**
     *
     * @var string
     * @Column(column="post_remark", type="string", length=255, nullable=false)
     */
    public $post_remark;

    /**
     *
     * @var integer
     * @Column(column="product_num", type="integer", length=11, nullable=false)
     */
    public $product_num;

    /**
     *
     * @var string
     * @Column(column="trade_no", type="string", length=50, nullable=true)
     */
    public $trade_no;

    /**
     *
     * @var string
     * @Column(column="kuaidi_name", type="string", length=10, nullable=true)
     */
    public $kuaidi_name;

    /**
     *
     * @var string
     * @Column(column="kuaidi_num", type="string", length=20, nullable=true)
     */
    public $kuaidi_num;

    /**
     *
     * @var string
     * @Column(column="back", type="string", nullable=true)
     */
    public $back;

    /**
     *
     * @var string
     * @Column(column="back_remark", type="string", length=255, nullable=true)
     */
    public $back_remark;

    /**
     *
     * @var integer
     * @Column(column="back_addtime", type="integer", length=11, nullable=true)
     */
    public $back_addtime;

    /**
     *
     * @var integer
     * @Column(column="order_type", type="integer", length=2, nullable=true)
     */
    public $order_type;

    /**
     *
     * @var integer
     * @Column(column="hd_id", type="integer", length=255, nullable=true)
     */
    public $hd_id;

    /**
     *
     * @var integer
     * @Column(column="note_grade", type="integer", length=255, nullable=true)
     */
    public $note_grade;

    /**
     *
     * @var string
     * @Column(column="note", type="string", length=255, nullable=true)
     */
    public $note;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("order");

        $this->hasOne("uid", "User", "id");
        //$this->hasOne("post", "Post", "id");
        $this->hasMany('id', "OrderProduct", 'order_id');
        $this->hasOne('receiver', 'Address', 'id');
        $this->hasOne('vid', 'UserVoucher', 'id');
        $this->hasOne('shop_id', 'Shangchang', 'id');

        $this->hasOne('order_sn', 'OrderLogistics', 'order_sn');

        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'order';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Order[]|Order|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Order|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


    //----------
    // 自定义
    //----------
    /**
     * 获取订单信息
     */
    public static function orderInfo($type='id', $params){
    	if (!$params) return 'DATAERR';
    	if ($type == 'id'){

    	}else if ($type == 'osn'){//order_sn
    		if (!isset($params['orderSn']) || empty($params['orderSn'])) return 'DATAERR';
    		$conditions = array( 'conditions'=> "order_sn='{$params['orderSn']}'" );

    		if (isset($params['columns'])) $conditions['columns'] = $params['columns'];
    		if (isset($params['order'])) $conditions['order'] = $params['order'];
    		if (isset($params['limit'])) $conditions['limit'] = $params['limit'];

    		$order = Order::findFirst($conditions);

    		if ($order && count($order)) return $order->toArray();
    	}

    	return 'NULL';
    }

    /**
     * 修改订单状态
     */
    public static function reOrderStatus($type='id', $data, $status=10){
    	if (!$data) return 'DATAERR';
    	if ($type == 'id'){

    	}else if ($type == 'osn'){
    		if (!isset($data['orderSn']) || empty($data['orderSn'])) return 'DATAERR';

    		$order = Order::findFirst("order_sn='{$data['orderSn']}'");
    		$order->status = $status;

    		if ($order->save()) return 'SUCCESS';
    		else return 'OPEFILE';
    	}

    	return 'NULL';
    }

    /**
     * 订单列表
     */
    public static function orderList($params=array()){
    	if (isset($params['conditions'])) $conditions['conditions'] = $params['conditions'];
    	if (isset($params['limit'])) $conditions['limit'] = $params['limit'];
    	if (isset($params['order'])) $conditions['order'] = $params['order'];

    	if (isset($conditions) && count($conditions)) $orders = Order::find($conditions);
    	else $orders = Order::find();
    	$orderArr = array();

    	if ($orders) {
    		foreach ($orders as $k=>$v){
    			$user = $v->User;
    			$orderArr[$k] = $v->toArray();
    			$orderArr[$k]['uname'] = $user->uname;
    		}
    	}

    	return $orderArr;
    }

    /**
     * 查询总数
     */
    public static function getCount($conditions){
    	$count = $conditions?Order::count($conditions):Order::count();

    	return $count;
    }

    /**
     * 修改备注
     */
    public static function renote($oid, $sid, $ong=0, $onc=''){
    	if (!$oid || !$sid) return 'DATAERR';

    	$order = Order::findFirst("id=$oid and shop_id=$sid");

    	if ($order) {
    		$order->note_grade = $ong;
    		$order->note = $onc;
    		if ($order->save()) return 'SUCCESS';
    		else return 'OPEFILE';
    	}else return 'DATAEXCEPTION';
    }
    
    /**
     * 自动收货
     */
    public static function autoReceiving($days=7){
    	$time = strtotime($days . ' day');
    	$orders = Order::find("fhtime>$time and status=30 and type='weixin'");
    	
    	if ($orders) {
    		$result = 'SUCCESS';
    		foreach ($orders as $k=>$v){
    			$v->status = 50;
    			if (!$v->save()) $result = 'OPEFILE';
    		}
    		return $result;
    	}else return 'DATAEXCEPTION';
    }
    
}
