<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrderProducts */

$this->title = 'Создать продукт в заказе';
$this->params['breadcrumbs'][] = ['label' => 'Продукты заказа', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
