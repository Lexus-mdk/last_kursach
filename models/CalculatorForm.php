<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\bootstrap4\Html;

class CalculatorForm extends Model{
    public $radio;
    public $length;
    public $checkbox;
    public $cost;
    public $button;
    public $radioList = [
        'Средний' => 1.3,
        'Толстый' => 3.0,
        'Тонкий' => 0.5
    ];

    public function __construct()
    {
        $this->radioList = Products::find()->all();
    }


    public function getRadioList()
    {
        $list = [];
        foreach ($this->radioList as $key=>$value)
        {
            $list[$value['id']] = $value['description'];
        }
        
        return $list;
    }

    public function justCalculate()
    {
        $prod = Products::findOne(['id'=>$this->radio]);
        $num = $this->length * $prod['price'];
        if($this->checkbox)
        {
            $num+= 20;
        }
        $this->cost = number_format($num, 2, '.', '');
    }

    public function getHtml()
    {
        return '<div style="display:flex; justify-content:center;"><h1>Рассчетная стоимость: <strong>' . $this->cost. ' руб</strong></h1>' . Html::submitButton('Добавить в корзину',  [
            'class' => 'btn btn-primary', 
            'id'=>'tobasket', 
            'name'=>'tobasket', 
            'value'=>'tobasket',
            'form'=>'calc-form',
            'onclick' => 'handleSubmitButton(this)'
            ]
        ) . '</div>';
    }

    public function rules()
    {
        return [
            [['radio', 'length', 'button'], 'required'],
            [['checkbox', 'calculat'], 'boolean'],
            ['length', 'double', 'message' => 'Введите число без пробелов. Если число не целое, то оно должно иметь вид: "<целое число>.<число после запятой>"!']
        ];
    }

    public function attributeLabels() {
        return [
            'radio' => 'Выберите тип кабеля',
            'length' => 'Введите длину кабеля',
            'checkbox' => 'Добавить коннекторы (20 руб на каждый отрезок)',
        ];
    }

}