<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class Category extends \Phalcon\Mvc\Model
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
     * @Column(column="tid", type="integer", length=11, nullable=false)
     */
    public $tid;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=50, nullable=false)
     */
    public $name;

    /**
     *
     * @var integer
     * @Column(column="sort", type="integer", length=11, nullable=false)
     */
    public $sort;

    /**
     *
     * @var integer
     * @Column(column="addtime", type="integer", length=11, nullable=false)
     */
    public $addtime;

    /**
     *
     * @var string
     * @Column(column="concent", type="string", length=255, nullable=true)
     */
    public $concent;

    /**
     *
     * @var string
     * @Column(column="bz_1", type="string", length=100, nullable=true)
     */
    public $bz_1;

    /**
     *
     * @var string
     * @Column(column="bz_2", type="string", length=255, nullable=true)
     */
    public $bz_2;

    /**
     *
     * @var string
     * @Column(column="bz_3", type="string", length=100, nullable=true)
     */
    public $bz_3;

    /**
     *
     * @var integer
     * @Column(column="bz_4", type="integer", length=2, nullable=false)
     */
    public $bz_4;

    /**
     *
     * @var string
     * @Column(column="bz_5", type="string", length=100, nullable=true)
     */
    public $bz_5;

    /**
     *
     * @var string
     * @Column(column="status", type="string", nullable=true)
     */
    public $status;

    /**
     *
     * @var string
     * @Column(column="parm_id", type="integer", length=11, nullable=false)
     */
    public $parm_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("category");

        $this->addBehavior(new SoftDelete(
        	array(
        		'field' => 'status',
        		'value' => 'S0'
        	)
        ));

        $this->hasMany("id", "Product", "cid");
        $this->hasOne("parm_id", "ProductParm", "id");

        $this->useDynamicUpdate(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'category';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Category[]|Category|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Category|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    
    //----------
    // 自定义
    //----------
    /**
     * 获取所有分类 (不包括 tid为0)
     */
    public static function categoryListNT0(){
    	$cls = Category::find(array("tid!=0 and status='S1'"));
    	
    	if ($cls) return $cls->toArray();
    	else return 'DATAEXCEPTION';
    }
    
}
