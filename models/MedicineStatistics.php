<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/2
 * Time: 23:20
 */
namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\db\Expression;

class MedicineStatistics extends ActiveRecord
{
    const STORAGE = 1;
    const RELEASE = 2;

    public static function tableName()
    {
        return 'medicine_statistics';
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

    public static function record($medicineId, $quantity, $type)
    {
        $model = new MedicineStatistics();
        $model->medicine_id = $medicineId;
        $model->type = $type;
        $model->user_id = Yii::$app->user->identity->getId();
        $model->quantity = $quantity;

        return $model->save();
    }
}