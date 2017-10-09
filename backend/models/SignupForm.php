<?php

namespace backend\models;

use common\models\Adminuser;
use common\models\User;
use yii\base\Model;

/**
 * Signup form.
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $nickname;
    public $password_repeat;
    public $profile;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => '该用户名已存在。'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => '该邮箱已存在。'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>'两次输入的密码不一致。'],

            ['nickname', 'required'],
            ['nickname', 'string', 'max'=>128],
            ['profile', 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username'       => '用户名',
            'nickname'       => '昵称',
            'password'       => '密码',
            'password_repeat'=> '重输密码',
            'email'          => 'Email',
            'profile'        => 'Profile',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return;
        }

        $user           = new Adminuser();
        $user->username = $this->username;
        $user->nickname = $this->nickname;
        $user->email    = $this->email;
        $user->profile  = $this->profile;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->password='*';

        return $user->save() ? $user : null;
    }
}
