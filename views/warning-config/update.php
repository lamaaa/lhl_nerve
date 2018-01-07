<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/7
 * Time: 11:35
 */

use yii\helpers\Url;

$this->title = '修改预警';
$this->params['breadcrumbs'][] = ['label' => '预警配置', 'url' => Url::toRoute('warning-config/index')];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="warning-config-update">
    <div class="container">
        <div class="row">
            <?= $this->render('_form', [
                'model' => $model,
                'warningTypes' => $warningTypes,
                'users' => $users,
                'isNewRecord' => false
            ]) ?>
        </div>
    </div>
</div>
