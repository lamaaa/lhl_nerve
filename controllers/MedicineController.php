<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2017/12/24
 * Time: 21:17
 */
namespace app\controllers;

use app\models\Medicine;
use app\models\ReleaseMedicineForm;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;

class MedicineController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'storage', 'release', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verb' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET'],
                    'release' => ['GET', 'POST'],
                    'storage' => ['GET', 'POSt'],
                    'delete' => ['POST']
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Medicine::find()->where(['status' => 1]),
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionStorage()
    {
        $model = new Medicine();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(Url::toRoute('medicine/index'));
            }
        }

        return $this->render('storage', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Medicine::findOne($id);

        if (!$model) {
            throw new HttpException(404, "您找的页面不见了！");
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(Url::toRoute('medicine/index'));
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        $model = Medicine::findOne($id);
        if (!$model) {
            throw new HttpException(404, "您找的页面不见了！");
        }

        $model->status = 0;
        if ($model->save()) {
            return $this->redirect(Url::toRoute('medicine/index'));
        } else {
            throw new HttpException(500, "服务器出了点小问题，请稍等");
        }
    }

    public function actionRelease($id)
    {
        $model = new ReleaseMedicineForm();
        $medicine = Medicine::findOne($id);

        if (!$medicine) {
            throw new HttpException(404, "该药品不存在");
        }

        $model->id = $id;
        $model->medicine_name = $medicine['medicine_name'];
        $model->quantity = $medicine['quantity'];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $medicine = Medicine::findOne($id);
            $medicine->quantity = $medicine->quantity - $model->release_quantity;
            if ($medicine->update()) {
                return $this->redirect(Url::toRoute('medicine/index'));
            }
        }

        return $this->render('release', [
            'model' => $model
        ]);
    }
}