<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/4
 * Time: 23:06
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
    <?= $form->field($model, 'username')->label('用户名')->textInput([
        'autofocus' => true,
        'readOnly' => $isNewRecord ? false : true
    ]) ?>
    <?= $form->field($model, 'email')->label('邮箱') ?>
    <?= $form->field($model, 'password')->label('密码')->passwordInput() ?>
    <div class="form-group">
        <?= Html::submitButton($isNewRecord ? '添加' : '修改', ['class' => $isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>
