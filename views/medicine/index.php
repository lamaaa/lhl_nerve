<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2017/12/31
 * Time: 20:08
 */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\daterange\DateRangePicker;

$this->title = "药品管理";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="medicine-index">
    <div class="container">
        <div class="row">
            <?= $this->render('@app/views/layouts/_sidebar') ?>
            <div class="col-sm-10">
                <div style="margin-bottom: 10px;">
                    <?= Html::a('入库', Url::toRoute('medicine/storage'), ['class' => 'btn btn-success']) ?>
                </div>
                <?= Html::beginForm(Url::toRoute('medicine/index'), 'GET', ['class' => 'form-inline']) ?>
                    <?= Html::label('药品名字:', 'medicine_name') ?>
                    <?= Html::input('text', 'medicine_name', $medicine_name, ['class' => 'form-control', 'style' => 'margin-right: 20px;']) ?>
                    <?= Html::label('出品商:', 'manufacturer') ?>
                    <?= Html::input('text', 'manufacturer', $manufacturer, ['class' => 'form-control', 'style' => 'margin-right: 20px;']) ?>
                    <?= Html::label('入库时间:', 'storage_at') ?>
                    <?= DateRangePicker::widget([
                        'name' => 'storage_at',
                        'value' => $storage_at,
                        'options' => [
                            'style' => 'margin-right: 20px;',
                            'class' => 'form-control'
                        ],
                        'pluginOptions' => [
                            'locale' => [
                                'format' => 'Y-M-d',
                                'separator' => ' / '
                            ]
                        ]
                    ]) ?>

                    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
                <?= Html::endForm() ?>
                <div style="margin-top: 20px;">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => '',
                        'columns' => [
                            'id',
                            'medicine_name',
                            'quantity',
                            'validity',
                            'serial_number',
                            'manufacturer',
                            'purchase_price',
                            'origin',
                            'created_at',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '{release}{delete}',
                                'contentOptions' => ['style' => 'width: 13%'],
                                'buttons' => [
                                    'release' => function ($url, $model) {
                                        return Html::a('出库', $url, [
                                            'class' => 'btn btn-primary btn-xs',
                                        ]);
                                    },
                                    'delete' => function ($url, $model) {
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
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

