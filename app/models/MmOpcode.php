<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class MmOpcode extends ModelBase
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=128, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=16, nullable=true)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="code", type="string", length=16, nullable=true)
     */
    public $code;

    /**
     *
     * @var integer
     * @Column(column="sort", type="integer", length=10, nullable=true)
     */
    public $sort;

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
        $this->setSource("mm_opcode");
        
        $this->addBehavior(new SoftDelete(
        		array( 'field'=>'status', 'value'=>'S0' )
        ));
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'mm_opcode';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MmOpcode[]|MmOpcode|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MmOpcode|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    
    //----------
    // 自定义
    //----------
    /**
     * 获取
     */
    public static function getOpcodes($conditions=array()){
    	if (self::isConditions($conditions)){
    		$opcodes = MmOpcode::find($conditions);
    	}else $opcodes = MmOpcode::find();
    	
    	if ($opcodes) return $opcodes;
    	else return 'DATAEXCEPTION';
    }
    
    /**
     * 获取详情
     */
    public static function opcodeDetail($id){
    	$od = MmOpcode::findFirstById($id);
    	
    	if ($od) return $od;
    	else return 'DATAEXCEPTION';
    }
    
}
