<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/1
 * Time: 10:23
 */

use yii\helpers\Url;

$this->title = '入库';
$this->params['breadcrumbs'][] = ['label' => '药品管理', 'url' => Url::toRoute('medicine/index')];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="medicine-storage">
    <div class="container">
        <div class="row">
            <?= $this->render('storage_form', [
                'model' => $model,
                'isNewRecord' => true
            ]) ?>
        </div>
    </div>
</div>
