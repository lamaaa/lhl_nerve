<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/7
 * Time: 10:40
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = '预警配置';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="warning-config-index">
    <div class="container">
        <div class="row">
            <?= $this->render('@app/views/layouts/_sidebar') ?>
            <div class="col-sm-10">
                <?= Html::a('添加预警', Url::toRoute('warning-config/create'), ['class' => 'btn btn-success']) ?>
                <div style="margin-top: 20px;">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => '',
                        'columns' => [
                            [
                                'attribute' => 'id',
                                'header' => 'ID'
                            ],
                            [
                                'attribute' => 'medicine_id',
                                'header' => '药品ID'
                            ],
                            [
                                'attribute' => 'medicine_name',
                                'header' => '药品名字'
                            ],
                            [
                                'attribute' => 'quantity',
                                'header' => '预警数量'
                            ],
                            [
                                'attribute' => 'warningUsers',
                                'header' => '预警用户'
                            ],
                            [
                                'attribute' => 'warningTypes',
                                'header' => '预警方式'
                            ],
                            [
                                'attribute' => 'created_at',
                                'header' => '创建时间'
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '{update}{delete}',
                                'contentOptions' => ['style' => 'width: 13%'],
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        $url = Url::toRoute(['warning-config/update', 'id' => $model['id']]);
                                        return Html::a('修改', $url, [
                                            'class' => 'btn btn-primary btn-xs',
                                        ]);
                                    },
                                    'delete' => function ($url, $model) {
                                        $url = Url::toRoute(['warning-config/delete', 'id' => $model['id']]);
                                        return Html::a('删除', $url, [
                                            'class' => 'btn btn-danger btn-xs',
                                            'style' => 'margin-left: 10px',
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
