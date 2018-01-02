<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/1
 * Time: 22:08
 */
namespace app\models;

use yii\base\Model;

class ReleaseMedicineForm extends Model
{
    public $id;
    public $medicine_name;
    public $release_quantity;
    public $quantity;

    public function rules()
    {
        return [
            [['release_quantity'], 'trim'],
            [['release_quantity'], 'integer', 'integerOnly' => true, 'min' => 0],
            [['release_quantity'], function ($attribute, $params) {
                $medicine = Medicine::findOne($this->id);
                if ($this->$attribute > $medicine['quantity']) {
                    $this->addError($attribute, '您填写的数量超过了库存量');
                }
            }]
        ];
    }

    public function attributeLabels()
    {
        return [
            'quantity' => '库存量',
            'medicine_name' => '药品名字',
            'release_quantity' => '出库数量'
        ];
    }
}