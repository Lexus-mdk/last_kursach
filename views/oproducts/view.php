<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\OrderProducts */

$this->title = "Продукт" . $model->product_id;
$this->params['breadcrumbs'][] = ['label' => 'Продукты в заказе', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-products-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'product_id' => $model->product_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'product_id' => $model->product_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить данный продукт из заказа?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'product_id',
            'order_id',
            'product_name',
            'price',
            'length',
            'patchcord',
            'cost',
        ],
    ]) ?>

</div>
