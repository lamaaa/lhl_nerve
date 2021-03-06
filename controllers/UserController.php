<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/4
 * Time: 22:37
 */
namespace app\controllers;

use app\models\SignupForm;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['status' => 1])
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', '添加成功');
            return $this->redirect(Url::toRoute('user/index'));
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = User::findOne($id);

        if (!$model) {
            throw new HttpException(404, '没有该用户噢');
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '更新成功');
                return $this->redirect(Url::toRoute('user/index'));
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        if (count(User::find()->where(['status' => 1])->all()) <= 1) {
            return $this->redirect(Url::toRoute('user/index'));
        }
        $model = User::findOne($id);

        if (!$model) {
            throw new HttpException(404, "没有该用户噢");
        }

        $model->status = 0;
        if ($model->update()) {
            Yii::$app->session->setFlash('success', '删除成功');
            return $this->redirect(Url::toRoute('user/index'));
        } else {
            throw new HttpException(500, "服务器出了点小问题噢");
        }
    }
}