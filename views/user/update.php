<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/4
 * Time: 23:19
 */

use yii\helpers\Url;

$this->title = '修改';
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => Url::toRoute('user/index')];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-update">
    <div class="container">
        <div class="row">
            <?= $this->render('_form', [
                'model' => $model,
                'isNewRecord' => false
            ]) ?>
        </div>
    </div>
</div>
