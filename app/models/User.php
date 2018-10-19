<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class User extends \Phalcon\Mvc\Model
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
     * @Column(column="addtime", type="integer", length=11, nullable=false)
     */
    public $addtime;

    /**
     *
     * @var double
     * @Column(column="jifen", type="double", length=11, nullable=true)
     */
    public $jifen;

    /**
     *
     * @var string
     * @Column(column="photo", type="string", length=255, nullable=true)
     */
    public $photo;

    /**
     *
     * @var string
     * @Column(column="tel", type="string", length=15, nullable=true)
     */
    public $tel;

    /**
     *
     * @var string
     * @Column(column="qq_id", type="string", length=20, nullable=false)
     */
    public $qq_id;

    /**
     *
     * @var string
     * @Column(column="email", type="string", length=50, nullable=true)
     */
    public $email;

    /**
     *
     * @var integer
     * @Column(column="sex", type="integer", length=2, nullable=false)
     */
    public $sex;

    /**
     *
     * @var integer
     * @Column(column="del", type="integer", length=2, nullable=false)
     */
    public $del;

    /**
     *
     * @var string
     * @Column(column="openid", type="string", length=50, nullable=false)
     */
    public $openid;

    /**
     *
     * @var string
     * @Column(column="source", type="string", length=10, nullable=false)
     */
    public $source;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        /* $validator->add(
            'email',
            new EmailValidator(
                [
                    'model'   => $this,
                    'message' => 'Please enter a correct email address',
                ]
            )
        ); */

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("micro_mail");
        $this->setSource("user");

        $this->addBehavior(new SoftDelete(
            array(
                'field' => 'del',
                'value' => 1
            )
        ));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]|User|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


    //----------
    // 自定义
    //----------
    /**
     * 添加用户
     */
    public static function addUser($datas=array()){
    	$uie = User::findFirstByName($datas['name']);
    	if ($uie && count($uie)) return 'NAME_EXIST';//账号存在

    	if (!isset($datas['name']) || empty($datas['name']) ||
    			!isset($datas['pwd']) || empty($datas['pwd'])) return 'DATAERR';

    	$user = new User();
    	$user->name = $datas['name'];
    	$user->uname = (isset($datas['uname'])&&!empty($datas['uname']))?$datas['uname']:$datas['name'];
    	$user->pwd = md5($datas['pwd']);
    	$user->addtime = time();
    	$user->jifen = isset($datas['jifen']) ? $datas['jifen'] : 0;
    	$user->photo = isset($datas['photo']) ? $datas['photo'] : '';
    	$user->sex = isset($datas['sex']) ? $datas['sex'] : 0;
    	$user->del = 0;
    	$user->tel = isset($datas['tel']) ? $datas['tel'] : '';
    	$user->email = isset($datas['email']) ? $datas['email'] : '';
    	if ($user->save()) return $user;
    	else return 'OPEFILE';
    }

    public static function getAllUser($limit = 10, $page = 1, $parameters = null){
        $conditions = array(
            'order'     => "addtime desc",
            'limit'     => array("number" => $limit, "offset" => $limit*($page-1)),
            'conditions'=> "del = 0",
        );
        if($parameters){
            $conditions['conditions'] .= " and ".$parameters['conditions'];
            $conditions['bind'] = $parameters['bind'];
        }

        $list = User::find($conditions);
        // $lv = UserLv::find()->toArray();
        // $lv_info = array_column($lv, 'lv_name', 'lv_id');

        $data['data'] = array();
        foreach ($list as $key => $value) {
            $item = $value->toArray();
            // $item['lv'] = $lv_info[$item['lv_id']];

            array_push($data['data'], $item);
        }

        unset($conditions['limit']);
        $data['count'] = User::count($conditions);

        return $data;
    }

    public static function getUserInfo($user_id, $shop_id){
        $ext_user_obj = ShopUsers::findFirst("shop_id = $shop_id and user_id = $user_id");

        $user_data = User::findFirstById($user_id)? User::findFirstById($user_id)->toArray():array();
        if($ext_user_obj && count($ext_user_obj)){
            unset($user_data['pwd']);

            $user_data['point'] = $ext_user_obj->point;
            $user_data['exp'] = $ext_user_obj->exp;
            $user_data['user_lv'] = $ext_user_obj->user_lv;
        }else{
            $user_data['point'] = 0;
            $user_data['exp'] = 0;
            $user_data['user_lv'] = 1;
        }

        return $user_data;
    }
}
