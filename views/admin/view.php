<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = "Заказ " . $model->order_id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'order_id' => $model->order_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'order_id' => $model->order_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот заказ?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Посмотреть продукты', ['/oproducts/index', 'order_id' => $model->order_id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_id',
            'products_count',
            'cost',
            'user_id',
            'status',
            'date',
        ],
    ]) ?>

</div>
