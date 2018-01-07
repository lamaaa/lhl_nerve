<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/6
 * Time: 23:50
 */
namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\Query;
use Yii;

class WarningConfig extends ActiveRecord
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

    public static function getWarningUsersStr($warning_config_id)
    {
        $warningUsers = '';
        $warningUserIdRows = (new Query())->select('user_id')->where([
            'status' => 1,
            'warning_config_id' => $warning_config_id
        ])->from('warning_config_id_user_id')->all();

        foreach ($warningUserIdRows as $warningUserIdRow) {
            $warningUsers .= User::findOne($warningUserIdRow['user_id'])['username'] . " ";
        }

        return $warningUsers;
    }

    public static function getWarningTypesStr($warning_config_id)
    {
        $warningTypes = '';
        $warningTypeIdRows = (new Query())->select('warning_type_id')->where([
            'status' => 1,
            'warning_config_id' => $warning_config_id
        ])->from('warning_config_id_warning_type_id')->all();

        foreach ($warningTypeIdRows as $warningTypeIdRow) {
            $warningTypes .= WarningType::findOne($warningTypeIdRow['warning_type_id'])['description'] . " ";
        }

        return $warningTypes;
    }

    public static function getSelectedWarningTypeNames($warning_config_id)
    {
        $warningTypes = [];
        $warningTypeIds = array_column(
            (new Query())->select('warning_type_id')->where([
                'status' => 1,
                'warning_config_id' => $warning_config_id
            ])->from('warning_config_id_warning_type_id')->all(), 'warning_type_id'
        );
        foreach ($warningTypeIds as $warningTypeId) {
            $warningTypes[] = WarningType::findOne($warningTypeId)['name'];
        }

        return $warningTypes;
    }

    public static function getSelectedWarningUserIds($warning_config_id)
    {
        return array_column(
            (new Query())->select('user_id')->where([
            'status' => 1,
            'warning_config_id' => $warning_config_id
        ])->from('warning_config_id_user_id')->all(), 'user_id');
    }

    public static function deleteUsers($warningConfigId)
    {
        Yii::$app->db->createCommand()->update('warning_config_id_user_id', [
                        'status' => 0
                    ], 'warning_config_id = ' . $warningConfigId)->execute();
    }

    public static function addUsers($warningConfigId, $userIds)
    {
        foreach ($userIds as $userId) {
            Yii::$app->db->createCommand()->insert('warning_config_id_user_id', [
                'warning_config_id' => $warningConfigId,
                'user_id' => $userId
            ])->execute();
        }
    }

    public static function addWarningTypes($warningConfigId, $warningTypes)
    {
         foreach ($warningTypes as $warningType) {
                $warningTypeId = WarningType::find()->select('id')->where([
                    'status' => 1,
                    'name' => $warningType
                ])->one()['id'];
                Yii::$app->db->createCommand()->insert('warning_config_id_warning_type_id', [
                    'warning_config_id' => $warningConfigId,
                    'warning_type_id' => $warningTypeId
                ])->execute();
         }
    }

    public static function getWarningTypes($warningConfigId)
    {
        $warningTypes = [];
        $warningTypeIdRows = (new Query())->select('warning_type_id')->where([
            'status' => 1,
            'warning_config_id' => $warningConfigId
        ])->from('warning_config_id_warning_type_id')->all();
        foreach ($warningTypeIdRows as $warningTypeIdRow) {
            $warningTypes[] = WarningType::findOne($warningTypeIdRow['warning_type_id']);
        }

        return $warningTypes;
    }

    public static function getWarningUsers($warningConfigId)
    {
        $warningUsers = [];
        $warningUserIdRows = (new Query())->select('user_id')->where([
            'status' => 1,
            'warning_config_id' => $warningConfigId
        ])->from('warning_config_id_user_id')->all();
        foreach ($warningUserIdRows as $warningUserIdRow) {
            $warningUsers[] = User::findOne($warningUserIdRow['user_id']);
        }

        return $warningUsers;
    }

    public static function deleteWarningTypes($warningConfigId)
    {
        Yii::$app->db->createCommand()->update('warning_config_id_warning_type_id', [
            'status' => 0
        ], 'warning_config_id = ' . $warningConfigId)->execute();
    }
}