<div class="row login" style="margin: 0 auto">
    <div class="col-lg-6 col-lg-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">

        <?
        $form = \yii\bootstrap\ActiveForm::begin([
            'enableClientValidation' => true,
            //   'enableAjaxValidation' => true,
        ]);
        ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'subject') ?>
        <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
        <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className(), [
            'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            'captchaAction' => \yii\helpers\Url::to(['main/captcha'])
        ]) ?>


        <?=\yii\helpers\Html::submitButton('Send',['class' => 'btn btn-success']) ?>
        <?
        \yii\bootstrap\ActiveForm::end();
        ?>


    </div>

</div>