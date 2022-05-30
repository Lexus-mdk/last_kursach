<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!-- <?= Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success']) ?> -->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'order_id',
            'products_count',
            // 'user_id',
            [
                'attribute'=>'cost',
                'label'=>'Стоимость в руб',
                'format'=>'text', // Возможные варианты: raw, html
            ],
            // [
            //     'attribute'=>'fio',
            //     'label'=>'ФИО',
            //     'format'=>'text', // Возможные варианты: raw, html
            //     'content'=>function($data){
            //         $ret = User::findOne(['id'=>$data->user_id]);
            //         return $ret->fio;
            //     },
            //     'filter' => function($data)
            //     {
            //         $user = User::findOne(['id'=>$data->user_id]);
            //         return User::find(['id'=>$data->user_id]);
            //     }
                
            // ],
            'fio',
            'status',
            'date',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'order_id' => $model->order_id]);
                 }
            ],
        ],
    ]); ?>


</div>
