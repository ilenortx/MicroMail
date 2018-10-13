<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class Adminuser extends \Phalcon\Mvc\Model
{
	
	public static $suTypes = array('T0'=>0, 'T1'=>1, 'T2'=>2, 'T3'=>3);

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
     * @Column(column="sid", type="integer", length=11, nullable=false)
     */
    public $sid;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=20, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="uname", type="string", length=10, nullable=true)
     */
    public $uname;

    /**
     *
     * @var string
     * @Column(column="pwd", type="string", length=50, nullable=false)
     */
    public $pwd;

    /**
     *
     * @var integer
     * @Column(column="qx", type="integer", length=4, nullable=false)
     */
    public $qx;

    /**
     *
     * @var integer
     * @Column(column="addtime", type="integer", length=11, nullable=false)
     */
    public $addtime;

    /**
     *
     * @var string
     * @Column(column="status", type="string", nullable=false)
     */
    public $status;
    
    /**
     *
     * @var string
     * @Column(column="au_type", type="string", nullable=false)
     */
    public $au_type;
    
    
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("adminuser");
        
        $this->addBehavior(new SoftDelete(
			array(
				'field' => 'status',
				'value' => 'S2'
			)
		));
        
		$this->hasOne('id', 'MmManagerRole', 'uid');
		
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'adminuser';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Adminuser[]|Adminuser|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Adminuser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    
    
    //----------
    // 自定义
    //----------
    /**
     * 获取用户列表
     */
    public static function ausersList($type='shop', $dataArr=array()){
    	if ($type == 'all'){
    		
    	}else if ($type == 'shop'){//获取店铺管理员
    		if (isset($dataArr['sid'])){
    			$aus = self::find("sid={$dataArr['sid']} and status!='S2'");
    			
    			if ($aus)  return $aus;
    			else return 'DATAEXCEPTION';
    		}else return 'DATAERR';
    	}
    }
    
    /**
     * 获取管理员信息
     * @param unknown $uid 管理员id
     * @param unknown $aid 代理商id
     * @return string[]|array[]|NULL[]
     */
    public static function adminInfo($uid, $sid){
    	$adminArr = array(
    			'id'=>'', 'aid'=>'', 'name'=>'', 'uname'=>'', 'phone'=>'',
    			'email'=>'',  'mtype'=>'', 'status'=>'', 'rids'=>''
    	);
    	$admin = self::findFirstById($uid);
    	
    	if ($admin && $admin->sid==$sid) {//判断管理员是否和当前管理员同代理商
    		$adminArr = $admin->toArray();
    		$roles = $admin->MmManagerRole;
    		$adminArr['rids'] = $roles?trim($roles->rids, ','):'';
    	}
    	
    	return $adminArr;
    }
    
    /**
     * 获取管理员角色
     */
    public static function adminRoles($rids, $sid){
    	$roleArr = array();
    	
    	$ridArr = explode(',', trim($rids, ','));
    	$rs = MmRole::getRoles(array(
    			'conditions'=> "sid=?1 and status=?2",
    			'bind'		=> array(1=>$sid, 2=>'S1')
    	));
    	
    	if ($rs && count($rs->toArray())) {
    		foreach ($rs as $k=>$v){
    			$ri = $v->toArray();
    			if (in_array($v->id, $ridArr)) $ri['checked'] = 1;
    			else $ri['checked'] = 0;
    			
    			array_push($roleArr, $ri);
    		}
    	}
    	
    	return $roleArr;
    }
    
    /**
     * 设置用户状态
     * @param unknown $auid 修改管理员id
     * @param string $status 状态
     * @param unknown $sid session id
     * @return number[]|string[]
     */
    public static function setAUserStatus($auid, $status="S0", $suid=0){
    	$result = array();
    	
    	if ($auid == $suid) {
    		$result['status'] = 0;
    		$result['err'] = "不能修改自己！";
    	}else {
    		$auser = self::findFirstById($auid);//查询待修改
    		$suser = self::findFirstById($suid);//查询自己
    		
    		if ($auser && $suser){
    			if (self::$suTypes[$suser->au_type] <= self::$suTypes[$auser->au_type]){
    				$dor = false;
    				if ($status == "S2") $dor = $auser->delete();
    				else { $auser->status = $status; $dor = $auser->save(); }
    				
    				if ($dor) {
    					$result['status'] = 1;
    					$result['msg'] = "操作成功！";
    					$result['auinfo'] = $auser->toArray();
    				}else {
    					$result['status'] = 0;
    					$result['err'] = "操作失败！";
    				}
    			}else {
    				$result['status'] = 0;
    				$result['err'] = "权限不够！";
    			}
    		}else {
    			$result['status'] = 0;
    			$result['err'] = "找不到管理员！";
    		}
    	}
    	
    	return $result;
    }
    
    /**
     * 编辑用户信息 (新增)
     */
    public static function adminEdit($id, $sid, $adminInfo=array()){
    	if ($id){//职位已存在
    		$manager = self::findFirstById($id);
    		
    		//判断数据是否存在
    		if (!$manager || !count($manager->toArray())) return 'ADMIN_NOT_EXIST';
    		
    		//权限不够
    		if ($manager->sid != $sid) return 'RIGHTS_ERR';
    	}else {
    		$mIsExist =  self::findFirstByName($adminInfo['name']);
    		if ($mIsExist && count($mIsExist)) return 'ADMIN_EXIST';
    			
    		$manager= new Adminuser();
    		$manager->sid = $sid;
    		$manager->status = 'S1';
    		$manager->name = $adminInfo['name'];
    		$manager->pwd = md5($adminInfo['pwd']);
    		$manager->au_type = $adminInfo['mtype'];
    		$manager->addtime = time();
    	}
    	
    	$manager->uname = $adminInfo['uname'];
    	$manager->phone = $adminInfo['phone'];
    	$manager->email = $adminInfo['email'];
    	
    	if ($manager->save()) return $manager;
    	else return 'OPEFILE';
    }
    
}
