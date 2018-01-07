<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2017/12/31
 * Time: 16:06
 */
use yii\bootstrap\Nav;
?>
<div class="col-sm-2">
    <?= Nav::widget([
    'items' => [
        [
            'label' => '药品管理',
            'url' => ['medicine/index']
        ],
        [
            'label' => '药品统计',
            'url' => ['medicine/statistics']
        ],
        [
            'label' => '预警配置',
            'url' => ['warning-config/index']
        ],
        [
            'label' => '用户管理',
            'url' => ['user/index']
        ]
    ],
    'options' => ['class' => 'flex-column nav-pills']
    ]); ?>
</div>

