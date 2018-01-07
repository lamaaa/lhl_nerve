<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/6
 * Time: 20:01
 */
namespace app\controllers;

use app\models\AddAndUpdateWarningConfigForm;
use app\models\Medicine;
use app\models\User;
use app\models\WarningConfig;
use app\models\WarningType;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;

class WarningConfigController extends Controller
{
    public function actionIndex()
    {
        $warningConfigs = [];
        $warningConfigRows = WarningConfig::find()->where([
            'status' => 1
        ])->all();
        foreach ($warningConfigRows as $warningConfigRow) {
            $warningUsers = WarningConfig::getWarningUsersStr($warningConfigRow['id']);
            $warningTypes = WarningConfig::getWarningTypesStr($warningConfigRow['id']);
            $warningConfigs[] = [
                'id' => $warningConfigRow['id'],
                'medicine_id' => $warningConfigRow['medicine_id'],
                'quantity' => $warningConfigRow['quantity'],
                'created_at' => $warningConfigRow['created_at'],
                'medicine_name' => Medicine::findOne($warningConfigRow['medicine_id'])['medicine_name'],
                'warningUsers' => $warningUsers,
                'warningTypes' => $warningTypes
            ];
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $warningConfigs,
            'pagination' => [
                'pageSize' => 15
            ]
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate()
    {
        $model = new AddAndUpdateWarningConfigForm();
        $warningTypes = WarningType::forWidget();
        $users = User::forWidget();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $warningConfig = new WarningConfig();
            $warningConfig->medicine_id = $model->medicine_id;
            $warningConfig->quantity = $model->quantity;
            if (!$warningConfig->save()) {
                throw new HttpException(500, "服务器出了一点问题");
            }
            WarningConfig::addUsers($warningConfig->id, $model->warningUserIds);
            WarningConfig::addWarningTypes($warningConfig->id, $model->warningTypes);
            Yii::$app->session->setFlash('success', '添加预警成功');
            return $this->redirect(Url::toRoute('warning-config/index'));
        }

        return $this->render('create', [
            'model' => $model,
            'warningTypes' => $warningTypes,
            'users' => $users
        ]);
    }

    public function actionUpdate($id)
    {
        $warningConfigModel = WarningConfig::findOne($id);
        if (!$warningConfigModel) {
            throw new HttpException(404, "没有该预警配置");
        }
        $model = new AddAndUpdateWarningConfigForm();
        $model->medicine_id = $warningConfigModel->medicine_id;
        $model->quantity = $warningConfigModel->quantity;
        $model->warningUserIds = WarningConfig::getSelectedWarningUserIds($warningConfigModel->id);
        $model->warningTypes = WarningConfig::getSelectedWarningTypeNames($warningConfigModel->id);
        $warningTypes = WarningType::forWidget();
        $users = User::forWidget();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $warningConfigModel->quantity = $model->quantity;
            if (!$warningConfigModel->update()) {
                throw new HttpException(500, '服务器出了一些问题');
            }
            if (!($model->warningUserIds == WarningConfig::getSelectedWarningUserIds($warningConfigModel->id))) {
                WarningConfig::deleteUsers($warningConfigModel->id);
                WarningConfig::addUsers($warningConfigModel->id, $model->warningUserIds);
            }

            if (!($model->warningTypes == WarningConfig::getSelectedWarningTypeNames($warningConfigModel->id))) {
                WarningConfig::deleteWarningTypes($warningConfigModel->id);
                WarningConfig::addWarningTypes($warningConfigModel->id, $model->warningTypes);
            }

            Yii::$app->session->setFlash('success', '修改预警成功');
            return $this->redirect(Url::toRoute('warning-config/index'));
        }

        return $this->render('update', [
            'model' => $model,
            'warningTypes' => $warningTypes,
            'users' => $users
        ]);
    }

    public function actionDelete($id)
    {
        $warningConfigModel = WarningConfig::findOne($id);
        if (!$warningConfigModel) {
            throw new HttpException(404, "找不到该预警配置");
        }
        $warningConfigModel->status = 0;
        if (!$warningConfigModel->update()) {
            throw new HttpException(500, "服务器出了一些问题");
        }
        WarningConfig::deleteWarningTypes($warningConfigModel->id);
        WarningConfig::deleteUsers($warningConfigModel->id);

        Yii::$app->session->setFlash('success', '删除预警配置成功');
        return $this->redirect(Url::toRoute('warning-config/index'));
    }
}