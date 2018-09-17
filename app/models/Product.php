<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Query\Status;

class Product extends \Phalcon\Mvc\Model
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
     * @Column(column="shop_id", type="integer", length=11, nullable=false)
     */
    public $shop_id;

    /**
     *
     * @var integer
     * @Column(column="brand_id", type="integer", length=11, nullable=true)
     */
    public $brand_id;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=50, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="intro", type="string", length=100, nullable=true)
     */
    public $intro;

    /**
     *
     * @var string
     * @Column(column="pro_number", type="string", length=100, nullable=true)
     */
    public $pro_number;

    /**
     *
     * @var double
     * @Column(column="price", type="double", length=8, nullable=false)
     */
    public $price;

    /**
     *
     * @var double
     * @Column(column="price_yh", type="double", length=8, nullable=false)
     */
    public $price_yh;

    /**
     *
     * @var integer
     * @Column(column="price_jf", type="integer", length=11, nullable=false)
     */
    public $price_jf;

    /**
     *
     * @var string
     * @Column(column="photo_x", type="string", length=100, nullable=true)
     */
    public $photo_x;
    
    /**
     *
     * @var string
     * @Column(column="photo_d", type="string", length=100, nullable=true)
     */
    public $photo_d;
    
    /**
     *
     * @var string
     * @Column(column="photo_tjx", type="string", length=100, nullable=true)
     */
    public $photo_tjx;
    
    /**
     *
     * @var string
     * @Column(column="photo_tj", type="string", length=100, nullable=true)
     */
    public $photo_tj;
    
    /**
     *
     * @var string
     * @Column(column="video", type="string", length=100, nullable=true)
     */
    public $video;
    
    /**
     *
     * @var string
     * @Column(column="photo_string", type="string", nullable=true)
     */
    public $photo_string;

    /**
     *
     * @var string
     * @Column(column="content", type="string", nullable=true)
     */
    public $content;

    /**
     *
     * @var integer
     * @Column(column="addtime", type="integer", length=11, nullable=true)
     */
    public $addtime;

    /**
     *
     * @var integer
     * @Column(column="updatetime", type="integer", length=11, nullable=false)
     */
    public $updatetime;

    /**
     *
     * @var integer
     * @Column(column="sort", type="integer", length=11, nullable=true)
     */
    public $sort;

    /**
     *
     * @var integer
     * @Column(column="renqi", type="integer", length=11, nullable=false)
     */
    public $renqi;

    /**
     *
     * @var integer
     * @Column(column="shiyong", type="integer", length=11, nullable=false)
     */
    public $shiyong;

    /**
     *
     * @var integer
     * @Column(column="num", type="integer", length=11, nullable=false)
     */
    public $num;

    /**
     *
     * @var integer
     * @Column(column="type", type="integer", length=2, nullable=false)
     */
    public $type;
    
    /**
     *
     * @var integer
     * @Column(column="stype", type="integer", length=2, nullable=false)
     */
    public $stype;
    
    /**
     *
     * @var string
     * @Column(column="snids", type="string", length=10, nullable=true)
     */
    public $snids;
    
    /**
     *
     * @var integer
     * @Column(column="del", type="integer", length=2, nullable=false)
     */
    public $del;

    /**
     *
     * @var integer
     * @Column(column="del_time", type="integer", length=10, nullable=true)
     */
    public $del_time;

    /**
     *
     * @var integer
     * @Column(column="cid", type="integer", length=11, nullable=false)
     */
    public $cid;

    /**
     *
     * @var string
     * @Column(column="company", type="string", length=10, nullable=true)
     */
    public $company;

    /**
     *
     * @var integer
     * @Column(column="is_show", type="integer", length=1, nullable=false)
     */
    public $is_show;

    /**
     *
     * @var integer
     * @Column(column="is_down", type="integer", length=1, nullable=false)
     */
    public $is_down;

    /**
     *
     * @var integer
     * @Column(column="is_hot", type="integer", length=1, nullable=true)
     */
    public $is_hot;

    /**
     *
     * @var integer
     * @Column(column="is_sale", type="integer", length=1, nullable=true)
     */
    public $is_sale;

    /**
     *
     * @var integer
     * @Column(column="start_time", type="integer", length=11, nullable=true)
     */
    public $start_time;

    /**
     *
     * @var integer
     * @Column(column="end_time", type="integer", length=11, nullable=true)
     */
    public $end_time;
    
    /**
     *
     * @var integer
     * @Column(column="hd_type", type="enum", length=0, nullable=false)
     */
    public $hd_type;
    
    /**
     *
     * @var integer
     * @Column(column="pro_type", type="integer", length=1, nullable=false)
     */
    public $pro_type;
    
    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="hd_id", type="integer", length=255, nullable=false)
     */
    public $hd_id;
    
    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="procxid", type="integer", length=255, nullable=false)
     */
    public $procxid;
    
    /**
     *
     * @var string
     * @Column(column="tjpro", type="string", length=10, nullable=true)
     */
    public $tjpro;
    
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("product");
        
        $this->addBehavior(new SoftDelete(
        	array(
        		'field' => 'del',
        		'value' => 1
        	)
        ));
        
        $this->hasOne("cid", "Category", "id");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'product';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Product[]|Product|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Product|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    
    /**
     * 
     * @param unknown $parameters
     * @return \Phalcon\Mvc\Model\ResultsetInterface
     */
    /* public function getCategory($parameters=null){
    	return $this->getRelated('Category', $parameters);
    } */
    
    
    //----------
    // 自定义
    //----------
    /**
     * 获取商品列表
     */
    public static function proList($params=array()){
    	if (isset($param['conditions'])) $conditions['conditions'] = $params['conditions'];
    	if (isset($params['limit'])) $conditions['limit'] = $params['limit'];
    	if (isset($params['order'])) $conditions['order'] = $params['order'];
    	
    	if (isset($conditions) && count($conditions)) $pros = Product::find($conditions);
    	else $pros = Product::find();
    	$proArr = array();
    	
    	if ($pros) $proArr = $pros->toArray();
    	
    	return $proArr;
    }
    /**
     * 设置商品上下架
     */
    public static function soldOutIn($pids, $sid, $status=0){
    	if (empty(trim($pids, ''))) return 'DATAERR';
    	
    	$pids = trim($pids, ',');
    	$pros = Product::find("id in ($pids) and del=0 and shop_id=$sid");
    	
    	if ($pros){
    		foreach ($pros as $k=>$v){
    			$v->is_down = $status;
    			if (!$v->save()) return 'OPEFILE';
    		}
    		
    		return 'SUCCESS';
    	}else return 'DATAEXCEPTION';
    }
    /**
     * 删除商品
     */
    public static function proDel($pids, $sid){
    	if (empty($pids) || empty($sid)) return 'DATAERR';
    	
    	$pros = Product::find("id in ($pids) and shop_id={$sid}");
    	
    	if ($pros){
    		foreach ($pros as $k=>$v){
    			if (!$v->delete()) return 'OPEFILE';
    		}
    		return 'SUCCESS';
    	}else return 'DATAEXCEPTION';
    }

}
