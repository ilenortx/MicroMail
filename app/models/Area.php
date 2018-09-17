<?php

class Area extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=10, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(column="area_name", type="string", length=50, nullable=false)
     */
    public $area_name;

    /**
     *
     * @var integer
     * @Column(column="parent_id", type="integer", length=10, nullable=false)
     */
    public $parent_id;

    /**
     *
     * @var string
     * @Column(column="shortname", type="string", length=50, nullable=true)
     */
    public $shortname;

    /**
     *
     * @var integer
     * @Column(column="zipcode", type="integer", length=10, nullable=true)
     */
    public $zipcode;

    /**
     *
     * @var string
     * @Column(column="pinyin", type="string", length=100, nullable=true)
     */
    public $pinyin;

    /**
     *
     * @var string
     * @Column(column="lng", type="string", length=20, nullable=true)
     */
    public $lng;

    /**
     *
     * @var string
     * @Column(column="lat", type="string", length=20, nullable=true)
     */
    public $lat;

    /**
     *
     * @var integer
     * @Column(column="level", type="integer", length=1, nullable=false)
     */
    public $level;

    /**
     *
     * @var integer
     * @Column(column="sort", type="integer", length=3, nullable=true)
     */
    public $sort;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("area");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'area';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Area[]|Area|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Area|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    
    
    
    //----------
    // 自定义
    //----------
    /**
     * 获取所有省
     */
    public static function getAllArea($pid){
    	if (empty($pid)&&$pid!=0){
    		$ps = Area::find(array('order'=>'id asc'));
    	}else {
    		$ps = Area::find(array(
    				'conditions'=> "parent_id=$pid",
    				'order'		=> 'id asc'
    		));
    	}
    	
    	if ($ps) {
    		$psArr = array();
    		foreach ($ps as $k=>$v){
    			$psArr[$k] = $v->toArray();
    			$psArr[$k]['checked'] = false;
    		}
    		return $psArr;
    	}
    	return array();
    }
    
    /**
     * 通过多个id获取地区名
     */
    public static function getNamesByIds($ids='', $split=' '){
    	if (empty($ids)) return 'DATAERR';
    	$ids = trim($ids, ',');
    	$areas = Area::find(array(
    			'conditions'=> "id in ($ids)",
    			//"cache" 	=> array("key" => "area-model", "lifetime" => 30000000)
    	));
    	
    	$names = '';
    	if ($areas){
    		foreach ($areas as $k=>$v){
    			$names .= $v->area_name . $split;
    		}
    		
    		$names = trim($names, $split);
    	}
    	
    	return $names;
    }
    
    /**
     * 获取单个信息
     */
    public static function areaInfo($id){
    	
    }
    
    /**
     * 获取同类列表
     */
    public static function getAPCByPid($pid, $id=0){
    	$as = Area::find("parent_id=$pid");
    	
    	$asArr = array();
    	if($as){
    		foreach ($as as $k=>$v){
    			$asArr[$k] = $v->toArray();
    			if ($v->id == $id) $asArr[$k]['checked'] = true;
    			else $asArr[$k]['checked'] = false;
    		}
    		
    		return $asArr;
    	}else return array();
    }
    
    
}
