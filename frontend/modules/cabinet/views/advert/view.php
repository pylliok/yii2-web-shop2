<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Advert */

$this->title = $model->idadvert;
$this->params['breadcrumbs'][] = ['label' => 'Adverts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advert-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idadvert], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idadvert], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idadvert',
            'price',
            'address',
            'id_user',
            'bedroom',
            'livinroom',
            'parking',
            'kitchen',
            'general_image',
            'description:ntext',
            'location',
            'hot',
            'sold',
            'type',
            'recommend',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
