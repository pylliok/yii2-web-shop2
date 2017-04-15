<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<div class="container">


    <div class="news col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-4 ">

        <?php $form = ActiveForm::begin([

            'enableClientValidation' => true,
            'enableAjaxValidation' => false


        ]) ?>

        <?=$form->field($model,'title')->textInput()?>
        <?=$form->field($model,'text')->textInput()?>
        <?=$form->field($model,'description')->textInput()?>
        <?=$form->field($model,'verifyCode')->widget(\yii\captcha\Captcha::className(), [
            'template' => '{input}{image}',
            'captchaAction' => yii\helpers\Url::to(['site/captcha'])
        ]) ?>


        <?= Html::submitButton('Добавить новость', ['class' => 'btn btn-primary', 'name' => 'news-button']) ?>

        <? ActiveForm::end()?>

    </div>

</div>