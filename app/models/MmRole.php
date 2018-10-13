<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class MmRole extends ModelBase
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
     * @Column(column="sid", type="integer", length=255, nullable=false)
     */
    public $sid;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=16, nullable=true)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="remark", type="string", nullable=true)
     */
    public $remark;

    /**
     *
     * @var string
     * @Column(column="addtime", type="string", length=13, nullable=true)
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
        $this->setSource("mm_role");
        
        $this->addBehavior(new SoftDelete(
        		array( 'field'=>'status', 'value'=>'S0' )
        ));
        
        $this->hasOne("id", "MmRoleRights", "rid");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'mm_role';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MmRole[]|MmRole|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MmRole|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    
    //----------
    // 自定义
    //----------
    /**
     * 获取职位
     */
    public static function getRoles($conditions=array()){
    	$roles = self::find($conditions);
    	
    	if ($roles) return $roles;
    	else return array();
    }
    
    /**
     * 获取店铺所有职位
     */
    public static function shopRoles($sid){
    	$srArr = array();
    	$srs = self::find(array(
    			'conditions'=> "sid=?1 and status!=?2",
    			'bind'		=> array(1=>$sid, 2=>'S0')
    	));
    	
    	if ($srs) $srArr = $srs->toArray();
    	
    	return $srArr;
    }
    
    /**
     * 根据职位id获取职位信息
     */
    public static function getRoleInfo($rid){
    	$roleInfo = array(
    			'id'=>'', 'aid'=>'', 'name'=>'', 'remark'=>'',
    			'addtime'=>'', 'status'=>'', 'rjson'=>''
    	);
    	$role = self::findFirstById($rid);
    	
    	if ($role) {
    		$roleInfo = $role->toArray();
    		$rights = $role->MmRoleRights;
    		$roleInfo['rjson'] = json_decode($rights->rjson, true);
    	}
    	
    	return $roleInfo;
    }
    
    /**
     * 
     */
    public static function roleEdit($rid, $rda, $rjson=''){
    	if (is_array($rda) && isset($rda['sid']) && !empty($rda['sid']) && isset($rda['name']) && !empty($rda['name'])){
    		if ($rid){//职位已存在
    			$role = self::findFirstById($rid);
    			
    			if (!$role|| !count($role->toArray())){//判断数据是否存在
    				return '职位不存在!';
    			}
    		}else {
    			$role = new MmRole();
    			$role->addtime = time();
    			$role->status = 'S1';
    		}
    		
    		$role->sid = $rda['sid'];
    		$role->name = $rda['name'];
    		$role->remark = isset($rda['remark'])?$rda['remark']:'';
    		
    		if ($role->save()){
    			//修改role_rights
    			$roleRight = $role->MmRoleRights;
    			if (!$roleRight|| !count($roleRight->toArray())) $roleRight= new MmRoleRights();
    			$roleRight->rid = $role->id; $roleRight->rjson = $rjson; 
    			if ($roleRight->save()) return 'SUCCESS';
    			else {
    				$role->delete(); return 'OPEFILE';
    			}
    		}
    	}else return 'DATAERR';
    }
    
    /**
     * 权限字符串转json
     */
    public static function rightToJson($str=''){
    	$oitems = explode(',', $str);
    	$rights = array(); $rarr = array();
    	foreach ($oitems as $k=>$v){
    		$r = explode('-', $v);
    		if (!isset($rarr[$r[0].'-'.$r[1]])) $rarr[$r[0].'-'.$r[1]] = array();
    		
    		array_push($rarr[$r[0].'-'.$r[1]], $r[2]);
    	}
    	
    	foreach ($rarr as $k=>$v){
    		$ek = explode('-', $k);
    		if (!isset($rights[$ek[0]])) {
    			$rights[$ek[0]] = array('paid'=>$ek[0], 'aids'=>array(), 'rjson'=>array());
    		}
    		array_push($rights[$ek[0]]['aids'], $ek[1]);
    		$rights[$ek[0]]['rjson'][$ek[1]] = $v;
    	}
    	
    	return json_encode($rights, true);
    }
    
    /**
     * 权限删除
     */
    public static function roleDel($id, $sid){
    	$role = self::findFirst("id=$id and sid=$sid");
    	
    	if ($role && count($role)){
    		if ($role->delete()) return 'SUCCESS';
    		else return 'OPEFILE';
    	}else return 'DATAEXCEPTION';
    			
    }
    
}
