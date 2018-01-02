<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/1
 * Time: 21:25
 */
$this->title = '修改';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="medicine-update">
    <div class="container">
        <div class="row">
            <?= $this->render('_form', [
                'model' => $model,
                'isNewRecord' => false,
            ]) ?>
        </div>
    </div>
</div>