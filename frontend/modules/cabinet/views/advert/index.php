<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Search\AdvertSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adverts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advert-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Advert', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idadvert',
            'price',
            'address',
            'user.email', //Будет выводится Email из связанной таблицы пользователей с advert
            'bedroom',
             'livinroom',
             'parking',
             'kitchen',
            // 'general_image',
            // 'description:ntext',
            // 'location',
            // 'hot',
            // 'sold',
            // 'type',
            // 'recommend',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
