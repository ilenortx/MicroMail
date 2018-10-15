<?php

class MmManagerRole extends ModelBase
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
     * @Column(column="uid", type="integer", length=255, nullable=true)
     */
    public $uid;

    /**
     *
     * @var string
     * @Column(column="rids", type="string", length=255, nullable=true)
     */
    public $rids;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("mm_manager_role");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'mm_manager_role';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MmManagerRole[]|MmManagerRole|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MmManagerRole|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    
    //----------
    // 自定义
    //----------
    /**
     * 编辑管理员角色
     * @param string $type aogj Adminuser对象
     * @param unknown $ai
     * @param unknown $roles
     * @return string
     */
    public static function adminRoleEdit($type='aobj', $ai, $roles){
    	if ($type == 'aobj'){
    		$managerRole = $ai->MmManagerRole;
    		
    		if (!$managerRole|| !count($managerRole->toArray())) $managerRole= new MmManagerRole();
    		$managerRole->uid = $ai->id; $managerRole->rids = $roles; 
    		if ($managerRole->save()) return 'SUCCESS';
    		else return 'OPEFILE';
    	}
    }
    
    /**
     * 查询管理员的rids
     */
    public static function adminRids($aid){
    	$rids = MmManagerRole::findFirstByUid($aid);
    	
    	if ($rids) return trim($rids->toArray()['rids'], ',');
    	else return '';
    }
}
