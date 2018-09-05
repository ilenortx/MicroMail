<?php

/**
 * 订单评论
 * @author xiao
 *
 */
class OrderEvaluate extends \Phalcon\Mvc\Model
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
     * @var integer
     * @Column(column="uid", type="integer", length=255, nullable=true)
     */
    public $uid;

    /**
     *
     * @var integer
     * @Column(column="pid", type="integer", length=255, nullable=true)
     */
    public $pid;

    /**
     *
     * @var string
     * @Column(column="order_sn", type="string", length=64, nullable=true)
     */
    public $order_sn;
    
    /**
     *
     * @var string
     * @Column(column="skuids", type="string", length=64, nullable=true)
     */
    public $skuids;
    
    /**
     *
     * @var string
     * @Column(column="grade", type="string", nullable=true)
     */
    public $grade;

    /**
     *
     * @var string
     * @Column(column="evaluate", type="string", nullable=true)
     */
    public $evaluate;

    /**
     *
     * @var string
     * @Column(column="show_photos", type="string", length=255, nullable=true)
     */
    public $show_photos;
    
    /**
     *
     * @var string
     * @Column(column="time", type="string", nullable=true)
     */
    public $time;
    
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
        $this->setSource("order_evaluate");
        
        $this->hasOne("pid", "Product", "id");
        $this->hasOne("uid", "User", "id");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'order_evaluate';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return OrderEvaluate[]|OrderEvaluate|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return OrderEvaluate|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    
    
    //----------
    // 自定义
    //----------
    /**
     * 添加评价
     * @param unknown $orderSn
     * @param unknown $uid
     * @param unknown $datas
     * @return string
     */
    public static function addEvaluate($orderSn, $uid, $datas){
    	$oe = OrderEvaluate::find("order_sn='{$orderSn}'");
    	
    	if (!$oe || !count($oe)){//评价不存在
    		if (!(isset($datas['grade']) && $datas['grade']) || 
    				!(isset($datas['evaluate']) && $datas['evaluate'])){
    			return "DATAERR";
    		}
    		//获取订单信息
    		$orderInfo = Order::findFirst("order_sn=$orderSn");
    		if (!$orderInfo|| !count($orderInfo)) return "DATAERR";
    		$ops = $orderInfo->OrderProduct;
    		
    		$skus = array();
    		foreach ($ops as $k=>$v){
    			if (isset($datas['grade'][$v->pid]) && isset($datas['evaluate'][$v->pid])){
    				if (!isset($skus[$v->pid])) $skus[$v->pid] = $v->skuid;
    				else $skus[$v->pid] .= '/'.$v->skuid;
    			}else return 'DATAERR';
    		}
    		foreach ($skus as $k=>$v){
    			$himg = isset($datas['showPhotos'][$k])&&!empty($datas['showPhotos'][$k]);
    			$oe = new OrderEvaluate();
    			$oe->shop_id = $orderInfo->shop_id;
    			$oe->uid = $uid;
    			$oe->pid = $k;
    			$oe->order_sn = $orderSn;
    			$oe->grade = $datas['grade'][$k];
    			$oe->evaluate = $datas['evaluate'][$k];
    			$oe->show_photos = $himg ? trim($datas['showPhotos'][$k],',') : '';
    			$oe->time = time();
    			$oe->skuids = $v;
    			$oe->status = $himg ? 'S2' : 'S1';
    			
    			if (!$oe->save()) return 'OPEFILE';
    		}
    		return 'SUCCESS';
    	}else {
    		foreach ($oe as $k=>$v){
    			if ($v->status == 'S2') return 'S2';
    			
    			if (!isset($datas['showPhotos'][$v->pid])||empty($datas['showPhotos'][$v->pid])) return 'DATAERR';
    			
    			$v->show_photos = $datas['showPhotos'][$v->pid];
    			$v->status = 'S2';
    			
    			if (!$v->save()) return 'OPEFILE';
    		}
    		return 'SUCCESS';
    	}
    }

    /**
     * 获取商品评论
     * @param string $type pid
     * @param array $params
     */
    public static function proEvaluates($type='pid', $params=null){
    	$conditions = array();
    	if ($type == 'pid'){
    		if (isset($params['pid'])) $conditions['conditions'] = "pid={$params['pid']}";
    		else return 'DATAERR';
    		
    		if (isset($params['type'])){
    			if ($params['type'] == 1) $params['type'] .= " and grade in(4,5)";
    			else if ($params['type'] == 2) $params['type'] .= " and grade=3";
    			else if ($params['type'] == 3) $params['type'] .= " and grade in(1,2)";
    			else if ($params['type'] == 4) $params['type'] .= " and show_photos!=''";
    		}
    		
    		if (isset($params['limit'])) $conditions['limit'] = $params['limit'];
    		else $conditions['limit'] = array('number'=>10, 'offset'=>0);
    		
    		if (isset($params['order'])) $conditions['order'] = $params['order'];
    		else $conditions['order'] = 'time desc';
    	}
    	
    	$pe = OrderEvaluate::find($conditions);
    	
    	if ($pe){
    		//获取sku
    		$skuCond = array();
    		foreach ($pe as $k=>$v){
    			if (!empty($v->skuids)){//sku库存
    				$skus = str_replace('/', ',', $v->skuids);
    				$skus = explode(',', $v->skuids);
    				foreach ($skus as $v){
    					if (!in_array($v, $skuCond)) array_push($skuCond, $v);
    				}
    			}
    		}
    		
    		//获取需要属性值
    		$sb = new SkuBase();
    		$skus = $sb->skuToAttrs(implode(',', $skuCond));
    		
    		$peArr = array();
    		foreach ($pe as $k=>$v){
    			$skuStr = ''; $user = $v->User;
    			if (!empty($v->skuids)){
    				$skuids = explode('/', $v->skuids);
    				for($i=0; $i<count($skuids); ++$i){
    					$skuid = explode(',', trim($skuids[$i], ','));
    					for($j=0; $j<count($skuid); ++$j){
    						$skuStr .= $skus[$skuid[$j]]['pname'].':'.$skus[$skuid[$j]]['name'].'   ';
    					}
    					$skuStr .= '/';
    				}
    				if(strlen($skuStr)>0) $skuStr = trim($skuStr, '/');
    			}
    			
    			$peArr[$v->id] = array(
    					'id'=>$v->id, 'shop_id'=>$v->shop_id, 'pid'=>$v->pid,
    					'grade'=>$v->grade, 'evaluate'=>$v->evaluate, 'sku'=>$skuStr,
    					'show_photos'=>explode(',', $v->show_photos),
    					'time'=>date('Y-h-d', $v->time), 'uid'=>$v->uid,
    					'uname'=>$user->uname, 'uavatar'=>$user->photo
    			);
    		}
    		
    		return $peArr;
    	}else return 'DATAERR';
    }
    
    /**
     * 获取对应等级数量
     * @param array $pe
     * @return number[]
     */
    public static function getTypeNum($pe){
    	$typeArr = array('qb'=>count($pe), 'hp'=>0, 'zp'=>0, 'cp'=>0, 'sd'=>0);
    	foreach ($pe as $k=>$v){
    		if ($v['grade']==4 || $v['grade']==5) $typeArr['hp']+=1;
    		else if ($v['grade']==3) $typeArr['zp']+=1;
    		else if ($v-['grade']==1 || $v['grade']==2) $typeArr['cp']+=1;
    		
    		if ($v['show_photos'] != '') $typeArr['sd']+=1;
    	}
    	
    	return $typeArr;
    }
    
}
