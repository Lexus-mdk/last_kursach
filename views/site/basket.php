<?php

/* @var $this yii\web\View */
/* @var $model app\models\Basket */
/* @var $order app\models\Order */
/* @var $form yii\bootstrap4\ActiveForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;


$script = new \yii\web\JsExpression("
    function handleSubmitButton(e, btn_name) {
        var name = e.name;
        var hiddenInput = $(btn_name);
        hiddenInput.val(name);
    }
    function inpt(e) {
        var name = e.name;
        var data = $(e).serialize();
        if (e.value == '' || e.value < 1){
            e.value = 1;
        }
        $.ajax({
            url: 'updatebasket',
            type: 'POST',
            data: {'id':name, 'length':e.value},
            success: function(res){
                var r = $.parseJSON(res)
                document.getElementById(name).innerHTML = r['1'] + ' руб, ';
                document.getElementById('result2').innerHTML = r['2'];
            },
            error: function(){
                alert('Error!');
            }
            });
            return false;
    }

    function plus(e) {
        var doc = document.getElementById('length'+e.name);
        doc.value = +doc.value + 1;
        inpt(doc);
    }

    function minus(e) {
        var doc = document.getElementById('length'+e.name);
        doc.value = +doc.value - 1;
        inpt(doc);
    }
");
$this->registerJs($script, \yii\web\View::POS_HEAD);
ActiveForm::begin([
    'id' => 'hidden-form',
]);
ActiveForm::end();
?>
<? $form = ActiveForm::begin([
        'id' => 'product-form',
    ]); ?>
    <!-- <?= Html::hiddenInput('id', Null, ['id' => 'button-name'])?> -->
    <?= $form->field($model, 'id')->hiddenInput(['id' => 'button-name'])->label(false) ?>
    <?= $model->renderBasket()?>
    
<?php ActiveForm::end(); ?>

<? $form = ActiveForm::begin([
        'id' => 'basket-form',
    ]); ?>
    <?= Html::hiddenInput('cost', Null, ['id' => 'cost']) ?>
    
    
<?php ActiveForm::end(); ?>
<div id='rat'></div>
<?
$js = <<<JS
    $('#product-form').on('beforeSubmit', function(){
    var data = $(this).serialize();    
        $.ajax({
        url: '',
        type: 'POST',
        data: data,
        success: function(res){
            var r = $.parseJSON(res)
            document.getElementById("result").innerHTML = r['1'];
            document.getElementById("result2").innerHTML = r['2'];
        },
        error: function(){
            alert('Error!');
        }
        });
        return false;
        }
    );

    $('#basket-form').on('beforeSubmit', function(){
    var data = $(this).serialize();    
        $.ajax({
        url: 'order',
        type: 'POST',
        data: data,
        success: function(res){
            if(res == true){
                document.getElementById("result").innerHTML = '<h1>Заказ оформлен. Отслеживать статус заказа можно в профиле пользователя';
                document.getElementById("result2").innerHTML = '';
            }else{
                document.getElementById("result").innerHTML = res;
            }
        },
        error: function(){
            alert('Error!');
        }
        });
        return false;
        }
    );

    $('#hidden-form').on('beforeSubmit', function(){
        return false;
    }
    );
    
JS;
$this->registerJs($js);
?>
