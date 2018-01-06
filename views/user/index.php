<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/4
 * Time: 22:40
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = "用户管理";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-management">
    <div class="container">
        <div class="row">
            <?= $this->render('@app/views/layouts/_sidebar') ?>
            <div class="col-sm-10">
                <?= Html::a('添加用户', Url::toRoute('user/create'), ['class' => 'btn btn-success']) ?>
                <div style="margin-top: 20px;">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => '',
                        'columns' => [
                            'id',
                            'username',
                            'email',
                            'created_at',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '{update}{delete}',
                                'contentOptions' => ['style' => 'width: 15%'],
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        return Html::a('修改', $url, [
                                            'class' => 'btn btn-primary btn-xs'
                                        ]);
                                    },
                                    'delete' => function ($url, $model) {
                                        return Html::a('删除', $url, [
                                            'class' => 'btn btn-danger btn-xs',
                                            'style' => 'margin-left: 15px',
                                            'data-confirm' => Yii::t('yii', '前方高能，非战斗人员速速退下！'),
                                            'data-method' => 'POST'
                                        ]);
                                    }
                                ]
                            ]
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>