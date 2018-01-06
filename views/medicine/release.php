<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/1
 * Time: 22:24
 */

use yii\helpers\Url;

$this->title = '出库';
$this->params['breadcrumbs'][] = ['label' => '药品管理', 'url' => Url::toRoute('medicine/index')];
?>

<div class="medicine-release">
    <div class="container">
        <div class="row">
            <?= $this->render('release_form', [
                'model' => $model
            ]) ?>
        </div>
    </div>
</div>
