<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/1
 * Time: 16:59
 */
namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;

class Medicine extends ActiveRecord
{
    public static function tableName()
    {
        return 'medicine';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
                ],
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    public function rules()
    {
        return [
            [['medicine_name', 'manufacturer', 'purchase_price', 'serial_number', 'origin', 'validity', 'quantity'], 'required'],
            [['medicine_name', 'manufacturer', 'purchase_price', 'serial_number', 'origin', 'validity', 'quantity'], 'trim'],
            [['purchase_price'], 'number'],
            [['quantity'], 'integer', 'integerOnly' => true, 'min' => 0],
            [['medicine_name', 'manufacturer', 'origin', 'serial_number'], 'string', 'length' => [1, 100]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => '序号',
            'medicine_name' => '药品名字',
            'manufacturer' => '出品商',
            'purchase_price' => '进价',
            'serial_number' => '产品批号',
            'origin' => '产地',
            'validity' => '有效期',
            'quantity' => '数量',
            'created_at' => '入库时间'
        ];
    }

    public static function getNameById($id)
    {
        return Medicine::findOne($id)['medicine_name'];
    }

    public static function getSerialNumberById($id)
    {
        return Medicine::findOne($id)['serial_number'];
    }
}