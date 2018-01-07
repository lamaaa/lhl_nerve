<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/6
 * Time: 20:12
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin() ?>
    <div class="col-sm-6">
        <?= $form->field($model, 'medicine_id')->input('text', [
            'readOnly' => $isNewRecord ? false : true
        ]) ?>

    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'quantity')->input('text') ?>
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'warningUserIds')->checkboxList($users) ?>
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'warningTypes')->checkboxList($warningTypes) ?>
    </div>

    <div class="col-sm-12">
        <div class="form-group">
            <?= Html::submitButton($isNewRecord ? '添加' : '修改', ['class' => $isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

<?php ActiveForm::end() ?>
