<?php
use yii\bootstrap4\Html;




// echo '<div class="card col-md-4">';
// echo Html::a(Html::encode($model->cost), ['orderinfo', 'id' => $model->order_id]);
// echo $model->name;
// echo '</div>';
?>
<div class="card-body">
    <h5 class="card-title"><?= $model->status ?> <small>#<?= $model->order_id ?></small></h5>
    <p class="card-text">
    Количество товаров: <?= $model->products_count ?><br>
    Стоимость: <?= $model->cost ?> руб<br>
    Дата: <?= $model->date ?>
    
    </p>
    <? echo Html::a(Html::encode("Перейти к заказу"), ['orderinfo', 'id' => $model->order_id], ['class'=>'btn btn-primary']); ?>
    <!-- <a href="#" class="btn btn-primary">Переход куда-нибудь</a> -->
  </div>