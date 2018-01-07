<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2017/12/24
 * Time: 11:57
 */

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use Yii;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'id' => '用户ID',
            'email' => '邮箱',
            'created_at' => '创建时间'
        ];
    }

    public function rules()
    {
        return [
            ['password', 'string', 'min' => 6, 'message' => '密码不能小于6位'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => '255'],
            ['username', function($attribute, $params) {
                $username = User::findOne($this->id)['username'];
                if ($username != $this->$attribute) {
                    $this->addError($attribute, '不能修改用户名噢');
                }
            }]
        ];
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function getPassword()
    {
        return '';
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne([['access_token' => $token]]);
    }

    public static function findByUsername($username)
    {
        $user = User::find()
            ->where(['username' => $username])
            ->asArray()
            ->one();

        if ($user) {
            return new static($user);
        }
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public static function getUsernameById($id)
    {
        return User::findOne($id)['username'];
    }

    public static function forWidget()
    {
        $userRows = User::find()->select(['username', 'id'])->where([
            'status' => 1
        ])->all();
        return ArrayHelper::map($userRows, 'id', 'username');
    }
}