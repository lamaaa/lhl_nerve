<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2017/12/24
 * Time: 12:04
 */

namespace app\models;

use yii\base\Model;
use yii\db\Expression;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $created_at;
    public $updated_at;

    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required', 'message' => '用户名不能为空'],
            ['username', function ($attribute, $params) {
                if (User::find()->where([
                    'status' => 1,
                    'username' => $this->$attribute
                ])->one()) {
                    $this->addError($attribute, '用户名已存在');
                }
            }],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['password', 'required', 'message' => '密码不能为空'],
            ['password', 'string', 'min' => 6],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required', 'message' => '邮箱不可以为空'],
            ['email', 'string', 'max' => '255'],
            ['email', 'email'],
            ['email', function ($attribute, $params) {
                if (User::find()->where([
                    'status' => 1,
                    'email' => $this->$attribute
                ])->one()) {
                    $this->addError($attribute, '邮箱已经存在');
                }
            }]
        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $now = new Expression('NOW()');
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->created_at = $now;
            $user->updated_at = $now;
            $user->generateAuthKey();
            if ($user->save(false)) {
                return $user;
            }
        }

        return null;
    }


}