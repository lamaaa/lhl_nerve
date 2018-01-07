<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2017/12/24
 * Time: 21:17
 */
namespace app\controllers;

use app\models\Medicine;
use app\models\MedicineStatistics;
use app\models\ReleaseMedicineForm;
use app\models\User;
use app\models\WarningConfig;
use app\models\WarningType;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
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
                'only' => ['index', 'storage', 'release', 'delete', 'statistics'],
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
                'pageSize' => 15
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
                if (!MedicineStatistics::record($model->id, $model->quantity, MedicineStatistics::STORAGE)) {
                    throw new HttpException(500, "Server has a problem");
                }
                Yii::$app->session->setFlash('success', '入库成功');
                return $this->redirect(Url::toRoute('medicine/index'));
            }
        }

        return $this->render('storage', [
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
        if ($model->update()) {
            Yii::$app->session->setFlash('success', '删除成功');
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
                if (!MedicineStatistics::record($model->id, $model->release_quantity, MedicineStatistics::RELEASE)) {
                    throw new HttpException(500, "Server has a problem");
                }
                $this->warn($medicine->quantity, $model->id);
                Yii::$app->session->setFlash('success', '出库成功');
                return $this->redirect(Url::toRoute('medicine/index'));
            }
        }

        return $this->render('release', [
            'model' => $model
        ]);
    }

    public function warn($quantity, $medicineId)
    {
        $warningConfigModels = WarningConfig::find()->where([
            'status' => 1,
            'medicine_id' => $medicineId
        ])->all();
        foreach ($warningConfigModels as $warningConfigModel) {
            if ($warningConfigModel['quantity'] >= $quantity) {
                foreach (WarningConfig::getWarningTypes($warningConfigModel->id) as $warningType) {
                    if ($warningType['name'] == 'email') {
                        foreach (WarningConfig::getWarningUsers($warningConfigModel->id) as $warningUser) {
                            $this->sendEmailTo($warningUser, [
                                'quantity' => $quantity,
                                'medicineId' => $medicineId
                            ]);
                        }
                    }
                    // 暂时只做email
                }
            }
        }
    }

    public function sendEmailTo($warningUser, $options)
    {
        $medicine = Medicine::findOne($options['medicineId']);
        $mail = Yii::$app->mail->compose();
        $mail->setTo($warningUser['email']);
        $mail->setFrom('lhl_nerve@163.com');
        $mail->setSubject($medicine['medicine_name'] . "告警");
        $mail->setTextBody($medicine['medicine_name'] . "在库仅剩" . $medicine['quantity'] . "。请尽快入库该药品！");
        $mail->send();
    }

    public function actionStatistics()
    {
        $rows = MedicineStatistics::find()->where([
            'status' => 1
        ])->all();
        $records = [];

        foreach ($rows as $row) {
            $records[] = [
                'medicine_name' => Medicine::getNameById($row['medicine_id']),
                'quantity' => $row['quantity'],
                'type' => $row['type'],
                'created_at' => $row['created_at'],
                'user' => User::getUsernameById($row['user_id']),
                'serial_number' => Medicine::getSerialNumberById($row['medicine_id'])
            ];
        }
        $dataProvider = new ArrayDataProvider(
            [
                'allModels' => $records,
                'pagination' => [
                    'pageSize' => 15
                ],
            ]
        );

        return $this->render('statistics', [
            'dataProvider' => $dataProvider
        ]);
    }
}