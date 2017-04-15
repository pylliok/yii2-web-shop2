<div class="site-login" >
    <div class="col-lg-6 col-lg-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 ">

        <?
        $form = \yii\bootstrap\ActiveForm::begin();
        ?>

        <?php if($model->scenario === 'loginWithEmail'):?>

            <?=$form->field($model,'email') ?>
        <?php else :?>
            <?=$form->field($model,'name') ?>
        <?php endif;?>

        <?=$form->field($model,'password')->passwordInput() ?>
        <?=$form->field($model,'rememberMe')->checkbox(['class' => 'btncheckbox']) ?>

        <?=\yii\helpers\Html::submitButton('Login',['class' => 'btn btn-success']) ?>

        <?
        \yii\bootstrap\ActiveForm::end();
        ?>
        <?= \yii\bootstrap\Html::a('Zabil parol?',['/main/main/send-email'])?>
    </div>

</div>