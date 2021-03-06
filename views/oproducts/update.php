<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrderProducts */

$this->title = 'Изменить продукт из заказа: ' . $model->product_id;
$this->params['breadcrumbs'][] = ['label' => 'Продукты из заказа', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_id, 'url' => ['view', 'product_id' => $model->product_id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="order-products-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
