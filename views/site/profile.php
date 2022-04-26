<?php
/* @var $model app\models\Profile */
//echo var_dump(Yii::$app->user);
//echo Yii::$app->user->identity->username;
//echo Yii::$app->user->identity->email;

use app\models\Profile;

?>

<div style="display: flex; align-items: center; flex-direction: row; justify-content: center">
    <h1>Мои данные </h1>
</div>
<div style="font-size: 18px">
Логин: <?= Yii::$app->user->identity->username?> <br>
Email: <?= Yii::$app->user->identity->email?>
</div>
<div style="display: flex; align-items: center; flex-direction: row; justify-content: center">
    <h1>Мои заказы</h1>
    <? 
    $pr = new Profile();
    ?>
</div>
<div>
    <?= $pr->getOrders() ?>
</div>
