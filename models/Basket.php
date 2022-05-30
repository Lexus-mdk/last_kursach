<?php

namespace app\models;

use yii\bootstrap4\Html;
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
        
        $cost_html = '<th score="row"></th><td></td><td></td><td></td></td><td><td>Итого: <strong>' . number_format($this->basket_cost, 2, '.', '') . ' руб</strong></td><td>'. Html::submitButton('Оформить заказ', [
            'class' => 'btn btn-primary', 
            'id'=>'calculate', 
            'name'=>number_format($this->basket_cost, 2, '.', ''),
            'form'=>'basket-form',
            'onclick' => 'handleSubmitButton(this, "#cost")'
            ]
        ) . '</td>';
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
            $c = 0;
            $result = '<div id="result"><table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Тип</th>
                <th scope="col">Стоимость за см</th>
                <th scope="col">С коннекторами</th>
                <th scope="col">Стоимость</th>
                <th scope="col">Длина в см</th>
                <th scope="col"></th>
                
              </tr>
            </thead>
            <tbody>';
            foreach($this->session->get('basket') as $key=>$value)
            {
                if($key!=0)
                {
                    $c++;
                    $result.= '<tr><th scope="row">'. $c . '</th>';
                    $result.= '<td>'. $value['type'] . '</th>';
                    $result.= '<td>'. $value['price'] . ' руб</td><td>';
                    $result.= $value['patchcord'] == 1 ? 'Да</td>' : 'Нет</td>';
                    $result.= '<td><strong id="'. $key .'">'. $value['cost'] .' руб</strong></td>';
                    $result.= '<td>';
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
                    ) . '</td>';
                    $result.= '<td>' . Html::submitButton('Удалить', [
                        'class' => 'btn btn-primary', 
                        'id'=>'calculate', 
                        'name'=>$key,
                        'form'=>'product-form',
                        'onclick' => 'handleSubmitButton(this, "#button-name")'
                        ]
                    );
                    $result.= '</td>';
                    $this->basket_cost += $value['cost'];
                }

            }
            $result.='<tr id="result2">'. $this->allCost() .'</tr>
            </tbody>
            </table>
            </div>';
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