<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/2
 * Time: 23:36
 */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "药品统计";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="medicine-statistics">
    <div class="container">
        <div class="row">
            <?= $this->render('@app/views/layouts/_sidebar') ?>
            <div class="col-sm-10">
                <div style="margin-top: 20px;">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => '',
                        'columns' => [
                            [
                                'attribute' => 'medicine_name',
                                'header' => '药品名称'
                            ],
                            [
                                'attribute' => 'serial_number',
                                'header' => '药品批号'
                            ],
                            [
                                'attribute' => 'quantity',
                                'header' => '数量'
                            ],
                            [
                                'attribute' => 'type',
                                'header' => '统计类型',
                                'value' => function ($model) {
                                    return $model['type'] == 1 ? '入库' : '出库';
                                }
                                
                            ],
                            [
                                'attribute' => 'created_at',
                                'header' => '操作时间'
                            ],
                            [
                                'attribute' => 'user',
                                'header' => '操作人'
                            ],
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>