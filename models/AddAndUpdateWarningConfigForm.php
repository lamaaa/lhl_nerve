<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/6
 * Time: 20:16
 */
namespace app\models;

use yii\base\Model;

class AddAndUpdateWarningConfigForm extends Model
{
    public $id;
    public $medicine_id;
    public $quantity;
    public $warningTypes;
    public $warningUserIds;

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'medicine_id' => '药品ID',
            'quantity' => '预警数量',
            'warningTypes' => '预警类型',
            'warningUserIds' => '预警用户'
        ];
    }

    public function rules()
    {
        return [
            [['medicine_id', 'quantity'], 'trim'],
            [['medicine_id', 'quantity', 'warningTypes', 'warningUserIds'], 'required'],
            ['medicine_id', 'in', 'range' => array_column(Medicine::find()->select('id')->where([
                'status' => 1
            ])->all(), 'id'), 'message' => '没有找到该药品'],
            ['quantity', 'compare', 'compareValue' => Medicine::find()->select('quantity')->where([
                'status' => 1
            ])->one()['quantity'], 'operator' => '<=', 'message' => '输入的预警数量不能超过库存量'],
            ['warningUserIds', function ($attribute, $params) {
                $warningUserIds = $this->$attribute;
                foreach ($warningUserIds as $warningUserId) {
                    $isValidUser = User::find()->select('id')->where([
                        'status' => 1,
                        'id' => $warningUserId
                    ])->one();
                    if (!$isValidUser) {
                        $this->addError($attribute, '输入的预警用户不存在');
                        break;
                    }
                }
            }],
            [
                'warningTypes', function ($attribute, $params) {
                $warningTypes = $this->$attribute;
                foreach ($warningTypes as $warningType) {
                    $isValidWarningType = WarningType::find()->select('id')->where([
                        'status' => 1,
                        'name' => $warningType
                    ])->one();
                    if (!$isValidWarningType) {
                        $this->addError($attribute, '输入的预警方式不存在');
                    }
                }
            }]
        ];
    }
}