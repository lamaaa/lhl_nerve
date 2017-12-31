<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2017/12/24
 * Time: 15:40
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = "注册";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-signup">
    <div class="row">
      <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
          <?= $form->field($model, 'username')->label('用户名')->textInput(['autofocus' => true]) ?>
          <?= $form->field($model, 'email')->label('邮箱') ?>
          <?= $form->field($model, 'password')->label('密码')->passwordInput() ?>
          <div class="form-group">
            <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
          </div>
        <?php ActiveForm::end(); ?>
      </div>
    </div>
</div>
