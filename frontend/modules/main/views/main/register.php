<?
class Model {
    public static $table = 'table';
    public static function getTable($x) {
        return static::$table;
    }
    public function __invoke($x) {
# Обрабатываем значение переданное объекту как функции
        echo $x;
    }
}

$a = new Model();
$a(5);
echo $a->getTable(3); // 'table'
?>


<div class="row register">
    <div class="col-lg-6 col-lg-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 ">
        <?php $form = \yii\bootstrap\ActiveForm::begin([
            // 'enableClientValidation' => true,
        ]);?>
        <?=$form->field($model,'name')?>
        <?=$form->field($model,'email')?>
        <?=$form->field($model,'password')->passwordInput()?>
        <?=$form->field($model,'repassword')->passwordInput()?>
        <?=\yii\helpers\Html::submitButton('Register',['class' => 'btn btn-success'])?>
        <?php \yii\bootstrap\Activeform::end(); ?>

        <?
        if($model->scenario === 'emailActivation'):
            ?>
            <i>*Na email otpravleno pismo s aktivaciei</i>
            <?php
        endif;
        ?>

    </div>

</div></br>