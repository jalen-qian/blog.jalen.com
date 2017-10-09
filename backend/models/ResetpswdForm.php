<?php

namespace backend\models;

use common\models\Adminuser;
use common\models\User;
use yii\base\Model;

/**
 * Signup form.
 */
class ResetpswdForm extends Model
{
    public $password;
    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>'两次输入的密码不一致。'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password'       => '密码',
            'password_repeat'=> '重输密码',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function resetPswd($id)
    {
        if (!$this->validate()) {
            return null;
        }

        $user = Adminuser::findOne($id);
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save() ? $user : null;
    }
}
