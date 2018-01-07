<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/6
 * Time: 20:47
 */
namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class WarningType extends ActiveRecord
{
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

    public static function forWidget()
    {
        $warningTypeRows = WarningType::find()->select(['name', 'description'])->where([
            'status' => 1
        ])->all();
        return ArrayHelper::map($warningTypeRows, 'name', 'description');
    }
}