<?php

/* @var $this yii\web\View */
/* @var $model app\models\OrderInfo */
/* @var $form yii\bootstrap4\ActiveForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$script = new \yii\web\JsExpression("
    function handleSubmitButton(e, btn_name) {
        var name = e.name;
        var hiddenInput = $(btn_name);
        hiddenInput.val(name);
    }
");
$this->registerJs($script, \yii\web\View::POS_HEAD);

$form = ActiveForm::begin([
    'id' => 'product-form',
]);
echo Html::hiddenInput('product_id', Null, ['id' => 'button-name']);
echo Html::hiddenInput('id', $model->order->order_id);
?>
<div id="result">
<?
echo $model->getOrderProducts();
?>
</div>
<?
ActiveForm::end(); 
?>


<?
$js = <<<JS
    $('#product-form').on('beforeSubmit', function(){
    var data = $(this).serialize();    
        $.ajax({
        url: '',
        type: 'GET',
        data: data,
        success: function(res){
            document.getElementById("result").innerHTML = res;
        },
        error: function(){
            alert('Error!');
        }
        });
        return false;
        }
    );
    
JS;
$this->registerJs($js);
?>