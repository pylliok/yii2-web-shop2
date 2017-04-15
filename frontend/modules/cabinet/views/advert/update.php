<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Advert */

$this->title = 'Update Advert: ' . $model->idadvert;
$this->params['breadcrumbs'][] = ['label' => 'Adverts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idadvert, 'url' => ['view', 'id' => $model->idadvert]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="advert-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
