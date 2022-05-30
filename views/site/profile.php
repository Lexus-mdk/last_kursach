<?php
/* @var $model app\models\Profile */
//echo var_dump(Yii::$app->user);
//echo Yii::$app->user->identity->username;
//echo Yii::$app->user->identity->email;

use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use yii\widgets\Pjax;
// use app\models\Profile;

$dataProvider = new ActiveDataProvider([
    'query' => $model::find(['user_id'=>Yii::$app->user->identity->id]),
    'pagination' => [
        'pageSize' => 6,
    ],
]);
Pjax::begin(['enablePushState' => false, 'timeout' => 5000]);
?>

<div style="display: flex; align-items: center; flex-direction: row; justify-content: center">
    <h1>Мои данные </h1>
</div>
<div style="font-size: 18px">
Логин: <?= Yii::$app->user->identity->username?> <br>
Email: <?= Yii::$app->user->identity->email?> <br>
ФИО: <?= Yii::$app->user->identity->fio?>
</div>
<div style="display: flex; align-items: center; flex-direction: row; justify-content: center">
    <h1>Мои заказы</h1>
</div>
<div>
    <?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_order-view',
    'itemOptions' => ['class' => 'card col-lg-4',
    'tag' => 'div',
    ],
    'summary' => 'Показаны записи <strong>{begin}-{end}</strong> из <strong>{totalCount}</strong>.',
    'layout' => '{summary}<div class="row">{items}</div>{pager}',
    'pager' => ['class' => \yii\bootstrap4\LinkPager::class],
    // 'options' => [
    //     'class' => 'row ',
    // ]
]); ?>
</div>
<?php Pjax::end(); ?>
