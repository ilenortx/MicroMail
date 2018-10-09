<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

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
    
}
