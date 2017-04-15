<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\SendEmailForm */
/* @var $form ActiveForm */
?>
<div class="modules-main-views-main-sandEmail col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email') ?>

    <div class="form-group">
        <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- modules-main-views-main-sandEmail -->
