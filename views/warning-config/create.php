<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/6
 * Time: 20:09
 */

use yii\helpers\Url;

$this->title = '添加预警';
$this->params['breadcrumbs'][] = ['label' => '预警配置', 'url' => Url::toRoute('warning-config/index')];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="warning-config-create">
    <div class="container">
        <div class="row">
            <?= $this->render('_form', [
                'model' => $model,
                'warningTypes' => $warningTypes,
                'users' => $users,
                'isNewRecord' => true
            ]) ?>
        </div>
    </div>
</div>
