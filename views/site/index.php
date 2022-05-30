<?php

/* @var $this yii\web\View */
/* @var $model app\models\CalculatorForm */
/* @var $form yii\bootstrap4\ActiveForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'My Yii Application';
$script = new \yii\web\JsExpression("
    function handleSubmitButton(e) {
        var name = e.name;
        var hiddenInput = $('#button-name');
        hiddenInput.val(name);
    }
");
$this->registerJs($script, \yii\web\View::POS_HEAD);

?>
<div style="display:flex; justify-content:center;">
    <h1>Калькулятор рассчета стоимости кабелей</h1>
</div>
<div style="display:flex; justify-content:center;">
<?php $form = ActiveForm::begin([
        'id' => 'calc-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>

    <?= $form->field($model, 'radio')->radioList($model->getRadioList()) ?>
    
    <?= $form->field($model, 'length', ['template' => '{label} {input} см <br> {error}'])->textInput() ?> 

    <?= $form->field($model, 'checkbox')->checkbox(['template' => '{input} {label}']) ?>
    
    <?= $form->field($model, 'button')->hiddenInput(['id' => 'button-name'])->label(false) ?>

    <div class="form-group">
    <div class="offset-lg-1 col-lg-11">
        <?= Html::submitButton('Рассчитать стоимость', [
                'class' => 'btn btn-primary', 
                'id'=>'calculate', 
                'name'=>'calculate',
                'form'=>'calc-form',
                'onclick' => 'handleSubmitButton(this)'
                ]
            ) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
</div>
<div id='result'></div>
<? 
$js = <<<JS
    $('form').on('beforeSubmit', function(){
    var data = $(this).serialize();    
        $.ajax({
        url: '',
        type: 'POST',
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
<?php $this->registerCssFile('css/css.css') ?>