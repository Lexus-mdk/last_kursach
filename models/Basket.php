<?php

namespace app\models;

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\base\Model;
use Yii;

class Basket extends Model
{
    private $session;
    public $id;
    public $basket_cost;

    public function __construct()
    {
        $this->session = Yii::$app->session;
        $this->basket_cost = 0;
        if (!$this->session['basket']) {
            $this->session['basket'] = [['']];
        }
    }

    public function rules()
    {
        return [
            ['id', 'required'],

        ];
    }

    public function allCost()
    {
        $this->basket_cost = 0;
        foreach($this->session->get('basket') as $key=>$value)
        {
            if($key!=0)
            {
                $this->basket_cost += $value['cost'];
            }
        }
        
        if($this->basket_cost == 0)
        {
            return '';
        }
        $cost_html = number_format($this->basket_cost, 2, '.', '') . " руб " . Html::submitButton('Купить', [
            'class' => 'btn btn-primary', 
            'id'=>'calculate', 
            'name'=>number_format($this->basket_cost, 2, '.', ''),
            'form'=>'basket-form',
            'onclick' => 'handleSubmitButton(this, "#cost")'
            ]
        );
        return $cost_html;
    }

    public function addToBasket($model)
    {
        $prod = Products::findOne(['id'=>$model->radio]);

        if ($busket = $this->session->get('basket')){
            $busket[] = [
                'type'=>$prod['product_name'],
                'price'=>$prod['price'],
                'length'=>$model->length,
                'patchcord'=>$model->checkbox ? 1 : 0,
                'cost'=>$model->cost
            ];
            $this->session['basket'] = $busket;
        }else{
            $this->session['basket'] = [[''],[
                'type'=>$prod['product_name'],
                'price'=>$prod['price'],
                'length'=>$model->length,
                'patchcord'=>$model->checkbox ? 1 : 0,
                'cost'=>$model->cost
                ]];
        }
    }


    public function updateBasket($id, $length = 0)
    {   
        $basket = $this->session->get('basket');
        $cost = $basket[$id]['price'] * $length;
        if ($basket[$id]['patchcord'] == 1) {
            $cost += 20;
        }
        $basket[$id]['length'] = $length;
        $basket[$id]['cost'] = number_format($cost, 2, '.', '');
        $this->session['basket'] = $basket;
        return number_format($cost, 2, '.', '');
    }

    public function unsetBasket()
    {
        if($this->session['basket'])
        {
            unset($this->session['basket']);
        }
    }
    
    public function renderBasket()
    {
        if(count($this->session->get('basket'))>=2)
        {
            $result = '<div style="display:flex; flex-direction:column" id="result">';
            foreach($this->session->get('basket') as $key=>$value)
            {
                if($key!=0)
                {
                    $result.= '<div>';
                    // $result.= Html::hiddenInput('id', Null, ['id' => 'button-name']);
                    $result.= 'Название - '. $value['type'] . ', ';
                    $result.= 'Цена за см - '. $value['price'] . ' см, ';
                    $result.= 'С коннекторами - ';
                    $result.= $value['patchcord'] == 1 ? 'Да, ' : 'Нет, ';
                    $result.= 'Стоимость кабеля - <strong id="'. $key .'">'. $value['cost'] .' руб</strong>, ';
                    $result.= 'Длина кабеля - ';
                    $result.= Html::submitButton('<i class="fa fa-minus"></i>', [
                        'class' => 'btn btn-link px-2', 
                        'id'=>'minus-btn', 
                        'name'=>$key,
                        'form'=>'hidden-form',
                        'onclick' => 'minus(this)'
                        ]
                    );
                    $result.= '<input id="length'. $key .'"
                    min="1" 
                    name="'. $key .'" 
                    type="number"
                    style="width:5rem"
                    form="hidden-form"
                    oninput="inpt(this)"
                    value="'. $value['length'] .'">';
                    $result.= Html::submitButton('<i class="fa fa-plus"></i>', [
                        'class' => 'btn btn-link px-2', 
                        'id'=>'plus-btn', 
                        'name'=>$key,
                        'form'=>'hidden-form',
                        'onclick' => 'plus(this)'
                        ]
                    );
                    $result.= Html::submitButton('Удалить', [
                        'class' => 'btn btn-primary', 
                        'id'=>'calculate', 
                        'name'=>$key,
                        'form'=>'product-form',
                        'onclick' => 'handleSubmitButton(this, "#button-name")'
                        ]
                    );
                    $result.= '</div>';
                    $this->basket_cost += $value['cost'];
                }

            }
            $result.='</div>';
            return $result;
        }
        else
        {
            return "<h2>В корзине нет товаров</h2>";
        }
    }

    public function delElement()
    {
        if(!empty($this->id))
        {
            $basket = $this->session->get('basket');
            if($this->id == 0)
            {
                unset($basket[0]);
            }
            else{
                unset($basket[$this->id]);
            }
            $this->session['basket'] = $basket;
        }
    }



}