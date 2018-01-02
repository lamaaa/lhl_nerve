<?php
/**
 * Created by PhpStorm.
 * User: LAM
 * Date: 2018/1/1
 * Time: 22:24
 */
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
