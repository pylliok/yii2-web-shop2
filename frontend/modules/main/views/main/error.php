<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1 style="color: #0000aa"><?= Html::encode($this->title) ?> </h1>
    <div class="alert alert-danger">
        <?

        if ($exception->statusCode == 404):
            echo 'Несуществующая страница!';

        else:
            echo nl2br(Html::encode($message));

        endif;
         ?>
    </div>

</div>
