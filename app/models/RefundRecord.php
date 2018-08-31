<?php

class RefundRecord extends \Phalcon\Mvc\Model
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
     * @Column(column="order", type="string", length=64, nullable=true)
     */
    public $order;

    /**
     *
     * @var integer
     * @Column(column="tamount", type="integer", length=255, nullable=true)
     */
    public $tamount;

    /**
     *
     * @var integer
     * @Column(column="ramount", type="integer", length=255, nullable=true)
     */
    public $ramount;

    /**
     *
     * @var string
     * @Column(column="rway", type="string", nullable=true)
     */
    public $rway;

    /**
     *
     * @var string
     * @Column(column="time", type="string", length=16, nullable=true)
     */
    public $time;

    /**
     *
     * @var string
     * @Column(column="reason", type="string", length=255, nullable=true)
     */
    public $reason;

    /**
     *
     * @var integer
     * @Column(column="vipid", type="integer", length=255, nullable=true)
     */
    public $vipid;

    /**
     *
     * @var integer
     * @Column(column="handler", type="integer", length=11, nullable=true)
     */
    public $handler;

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
        $this->setSource("refund_record");
        
        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'refund_record';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RefundRecord[]|RefundRecord|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RefundRecord|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    
    //----------
    // 自定义
    //----------
    /**
     * 添加退款记录
     */
    public static function addRefund($params){
    	//数据验证
    	if ((!isset($params['order'])||empty($params['order'])) ||
    			(!isset($params['tamount'])||empty($params['tamount'])) ||
    			(!isset($params['ramount'])||empty($params['ramount']))){
    		return 'DATAERR';
    	}
    	
    	$rr = new RefundRecord();
    	$rr->order = $params['order'];
    	$rr->tamount = $params['tamount'];
    	$rr->ramount = $params['ramount'];
    	$rr->rway = isset($params['rway'])?$params['rway']:'';
    	$rr->reason = isset($params['reason'])?$params['reason']:'';
    	$rr->vipid = isset($params['vipid'])?$params['vipid']:'';
    	$rr->handler = isset($params['handler'])?$params['handler']:'';
    	$rr->status = 'S1';
    	
    	if ($rr->save()) return $rr;
    	else return 'OPEFILE';
    }
    /**
     * 修改退款记录
     */
    public static function reRefundStatus(){
    	
    }
    
}
