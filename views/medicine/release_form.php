<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/1
 * Time: 22:27
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = '出库';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(); ?>

    <div class="col-sm-12">
        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'medicine_name')->input('text', [
            'readOnly' => true
        ]) ?>
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'quantity')->input('text', [
            'readOnly' => true
        ]) ?>
    </div>

    <div class="col-sm-12">
        <?= $form->field($model, 'release_quantity')->input('text') ?>
    </div>

    <div class="col-sm-12">
        <div class="form-group">
            <?= Html::submitButton('出库', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
