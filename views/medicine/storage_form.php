<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/1
 * Time: 10:41
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use dosamigos\datetimepicker\DateTimePicker;
?>

<?php $form = ActiveForm::begin([]); ?>

    <div class="col-sm-6">
        <?= $form->field($model, 'medicine_name')->input('text') ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'manufacturer')->input('text') ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'purchase_price')->input('text') ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'quantity')->input('text') ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'serial_number')->input('text') ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'validity')->widget(DateTimePicker::className(), [
            'language' => 'zh-CN',
            'size' => 'ms',
            'template' => '{input}',
            'clientOptions' => [
                'todayBtn' => true
            ]
        ]) ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'origin')->input('text') ?>
    </div>

    <div class="col-sm-12">
        <div class="form-group">
            <?= Html::submitButton('入库', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>